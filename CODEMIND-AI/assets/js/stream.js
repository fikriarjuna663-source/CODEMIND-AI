/*
=========================================
CodeMind AI - Streaming Gemini
=========================================
*/

function streamMessage(prompt) {

    const chatBox = document.getElementById("chatBox");

    /*
    =========================
    Bubble AI
    =========================
    */

    const wrapper = document.createElement("div");
    wrapper.className = "ai-message";

    const bubble = document.createElement("div");
    bubble.className = "ai-bubble";
    bubble.innerHTML = "⏳ Sedang berpikir...";

    wrapper.appendChild(bubble);

    chatBox.appendChild(wrapper);

    chatBox.scrollTop = chatBox.scrollHeight;

    /*
    =========================
    Streaming
    =========================
    */

    const source = new EventSource(
        "../api/stream.php?prompt=" + encodeURIComponent(prompt)
    );

    let answer = "";

    source.onmessage = function (event) {

        if (event.data === "[DONE]") {

            source.close();

            bubble.innerHTML = formatMarkdown(answer);

            if (typeof hljs !== "undefined") {

                document.querySelectorAll("pre code").forEach(function (block) {

                    hljs.highlightElement(block);

                });

            }

            chatBox.scrollTop = chatBox.scrollHeight;

            return;

        }

        if (answer === "") {

            bubble.innerHTML = "";

        }

        answer += event.data + " ";

        bubble.textContent = answer;

        chatBox.scrollTop = chatBox.scrollHeight;

    };

    /*
    =========================
    Error
    =========================
    */

    source.onerror = function () {

        source.close();

        bubble.innerHTML = `
            <span style="color:#EF4444">
            ❌ Gagal terhubung ke Gemini AI.
            </span>
        `;

    };

}

/*
=========================================
Markdown Sederhana
=========================================
*/

function formatMarkdown(text) {

    text = escapeHTML(text);

    // ```code```
    text = text.replace(/```([\s\S]*?)```/g, function(match, code){

        return `
<pre><code>
${code.trim()}
</code></pre>
`;

    });

    // Heading
    text = text.replace(/^### (.*)$/gm,"<h3>$1</h3>");
    text = text.replace(/^## (.*)$/gm,"<h2>$1</h2>");
    text = text.replace(/^# (.*)$/gm,"<h1>$1</h1>");

    // Bold
    text = text.replace(/\*\*(.*?)\*\*/g,"<strong>$1</strong>");

    // Italic
    text = text.replace(/\*(.*?)\*/g,"<em>$1</em>");

    // Inline code
    text = text.replace(/`([^`]+)`/g,"<code>$1</code>");

    // New Line
    text = text.replace(/\n/g,"<br>");

    return text;

}

/*
=========================================
Escape HTML
=========================================
*/

function escapeHTML(text){

    return text
        .replace(/&/g,"&amp;")
        .replace(/</g,"&lt;")
        .replace(/>/g,"&gt;");

}