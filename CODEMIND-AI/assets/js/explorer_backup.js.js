let currentFile = "";
let projectFiles = {};

function detectLanguage(filename){

    const ext = filename.split(".").pop().toLowerCase();

    switch(ext){

        case "html": return "html";
        case "css": return "css";
        case "js": return "javascript";
        case "php": return "php";
        case "json": return "json";
        case "sql": return "sql";
        default: return "plaintext";

    }

}

function showFile(name, code){

    currentFile = name;
    projectFiles[name] = code ?? "";

    const viewer = document.getElementById("codeViewer");

    viewer.innerHTML = "";

    /*
    ========================
    HEADER
    ========================
    */

    const header = document.createElement("div");
    header.className = "viewer-header";

    const title = document.createElement("span");
    title.textContent = "📄 " + name;

    const btn = document.createElement("button");
    btn.className = "copy-btn";
    btn.innerText = "📋 Copy";

    btn.onclick = copyCurrentCode;

    header.appendChild(title);
    header.appendChild(btn);

    /*
    ========================
    PRE
    ========================
    */

    const pre = document.createElement("pre");

    const codeBlock = document.createElement("code");

    codeBlock.className =
        "language-" + detectLanguage(name);

    codeBlock.textContent = code;

    pre.appendChild(codeBlock);

    viewer.appendChild(header);
    viewer.appendChild(pre);

    if(window.hljs){

        hljs.highlightElement(codeBlock);

    }

    updatePreview();

}

function copyCurrentCode(){

    if(!currentFile) return;

    navigator.clipboard.writeText(
        projectFiles[currentFile]
    );

    alert("✅ Berhasil disalin");

}

function updatePreview(){

    const frame =
        document.getElementById("previewFrame");

    if(!frame) return;

    if(!projectFiles["index.html"]){

        frame.srcdoc = "";

        return;

    }

    let html = projectFiles["index.html"];

    html = html.replace(
        /<link[^>]*style\.css[^>]*>/gi,
        ""
    );

    html = html.replace(
        /<script[^>]*script\.js[^>]*><\/script>/gi,
        ""
    );

    if(projectFiles["style.css"]){

        html = html.replace(
            "</head>",
            "<style>" +
            projectFiles["style.css"] +
            "</style></head>"
        );

    }

    if(projectFiles["script.js"]){

        html = html.replace(
            "</body>",
            "<script>" +
            projectFiles["script.js"] +
            "<\/script></body>"
        );

    }

    frame.srcdoc = html;

}