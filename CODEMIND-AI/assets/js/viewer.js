let projectFiles = {};
let currentLanguage = "";

function detectLanguage(filename){

    const ext = filename.split(".").pop().toLowerCase();

    switch(ext){

        case "php":
            return "php";

        case "html":
            return "html";

        case "css":
            return "css";

        case "js":
            return "javascript";

        case "sql":
            return "sql";

        case "json":
            return "json";

        case "py":
            return "python";

        case "java":
            return "java";

        case "cpp":
            return "cpp";

        case "cs":
            return "csharp";

        case "xml":
            return "xml";

        case "ts":
            return "typescript";

        case "go":
            return "go";

        case "dart":
            return "dart";

        case "kt":
            return "kotlin";

        case "swift":
            return "swift";

        default:
            return "plaintext";

    }

}

function showFile(name, code){

    currentLanguage = detectLanguage(name);

    document.getElementById("codeViewer").innerHTML = `

        <div class="viewer-header">

            <div>

                📄 ${name}

            </div>

            <button
            class="copy-btn"
            onclick="copyCurrentCode()">

                📋 Copy

            </button>

        </div>

        <pre>

<code class="language-${currentLanguage}">${escapeHtml(code)}</code>

        </pre>

    `;

    document.querySelectorAll("pre code").forEach((block)=>{

        hljs.highlightElement(block);

    });

}

function escapeHtml(text){

    if(text === undefined || text === null){

        return "";

    }

    return text
        .replace(/&/g,"&amp;")
        .replace(/</g,"&lt;")
        .replace(/>/g,"&gt;");

}

function copyCurrentCode(){

    const code = document.querySelector("#codeViewer code");

    if(!code){

        alert("Tidak ada kode untuk disalin.");

        return;

    }

    navigator.clipboard.writeText(code.innerText);

    alert("✅ Coding berhasil disalin.");

}