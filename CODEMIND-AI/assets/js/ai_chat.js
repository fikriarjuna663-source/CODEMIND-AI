/*
=========================================
CodeMind AI
AI CHAT
=========================================
*/

const chatBox = document.getElementById("chatBox");
const promptInput = document.getElementById("prompt");
const sendBtn = document.getElementById("sendBtn");
const modeSelect = document.getElementById("mode");

/*
=========================================
AUTO FOCUS
=========================================
*/

window.addEventListener("load", () => {

    if(promptInput){

        promptInput.focus();

        autoResize();

    }

});

/*
=========================================
KIRIM PESAN
=========================================
*/

function sendMessage(){

    const text = promptInput.value.trim();

    if(text==="") return;

    addUserMessage(text);

    promptInput.value="";

    autoResize();

    const mode = modeSelect.value;

    switch(mode){

        case "website":

            if(typeof generateWebsite==="function"){

                generateWebsite(text);

            }

        break;

        case "chat":

            if(typeof streamMessage==="function"){

                streamMessage(text);

            }

        break;

        case "generate":

            if(typeof streamMessage==="function"){

                streamMessage("Generate code : "+text);

            }

        break;

        case "analyze":

            if(typeof streamMessage==="function"){

                streamMessage("Analyze : "+text);

            }

        break;

        case "convert":

            if(typeof streamMessage==="function"){

                streamMessage("Convert : "+text);

            }

        break;

        case "documentation":

            if(typeof streamMessage==="function"){

                streamMessage("Documentation : "+text);

            }

        break;

        default:

            if(typeof streamMessage==="function"){

                streamMessage(text);

            }

    }

}

/*
=========================================
EVENT
=========================================
*/

if(sendBtn){

    sendBtn.onclick = sendMessage;

}

if(promptInput){

    promptInput.onkeydown=function(e){

        if(e.key==="Enter" && !e.shiftKey){

            e.preventDefault();

            sendMessage();

        }

    };

    promptInput.oninput=function(){

        autoResize();

    };

}

/*
=========================================
USER MESSAGE
=========================================
*/

function addUserMessage(text){

    if(!chatBox) return;

    const div=document.createElement("div");

    div.className="user-message";

    div.innerHTML=`

<div class="user-bubble">

${escapeHTML(text)}

</div>

`;

    chatBox.appendChild(div);

    scrollBottom();

}

/*
=========================================
AI MESSAGE
=========================================
*/

function addAIMessage(text){

    if(!chatBox) return;

    const div=document.createElement("div");

    div.className="ai-message";

    div.innerHTML=`

<div class="ai-bubble">

${text}

</div>

`;

    chatBox.appendChild(div);

    scrollBottom();

}

/*
=========================================
CLEAR CHAT
=========================================
*/

function clearChat(){

    if(chatBox){

        chatBox.innerHTML="";

    }

}

/*
=========================================
SCROLL
=========================================
*/

function scrollBottom(){

    if(chatBox){

        chatBox.scrollTop=chatBox.scrollHeight;

    }

}

/*
=========================================
AUTO RESIZE
=========================================
*/

function autoResize(){

    if(!promptInput) return;

    promptInput.style.height="110px";

    promptInput.style.height=promptInput.scrollHeight+"px";

}

/*
=========================================
ESCAPE HTML
=========================================
*/

function escapeHTML(text){

    return text
    .replace(/&/g,"&amp;")
    .replace(/</g,"&lt;")
    .replace(/>/g,"&gt;")
    .replace(/"/g,"&quot;")
    .replace(/'/g,"&#039;");

}

/*
=========================================
COPY CODE
=========================================
*/

function copyCode(btn){

    const code=btn.parentElement.querySelector("code");

    if(!code) return;

    navigator.clipboard.writeText(code.innerText);

    btn.innerHTML="✅ Copied";

    setTimeout(()=>{

        btn.innerHTML="Copy";

    },1500);

}

/*
=========================================
WELCOME
=========================================
*/

document.addEventListener("DOMContentLoaded",()=>{

    if(!chatBox) return;

    if(chatBox.innerHTML.trim()!=="") return;

    addAIMessage(`

<b>👋 Selamat datang di CodeMind AI</b>

<br><br>

Saya dapat membantu Anda untuk:

<ul>

<li>💻 Website Generator</li>

<li>🤖 AI Chat</li>

<li>⚡ Generate Code</li>

<li>🛠 Debug Error</li>

<li>📄 HTML CSS JS PHP</li>

<li>🗄 SQL Database</li>

<li>📚 Dokumentasi</li>

</ul>

Silakan mulai mengetik prompt.

`);

});