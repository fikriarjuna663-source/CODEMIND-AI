/*
==================================================
CODEMIND AI
Website Generator v3.0
PART 1
==================================================
*/

"use strict";

/* ==================================================
GLOBAL
================================================== */

let currentFile = "";
let currentProject = "No Project";

const projectFiles = {};
const projectTree = {};

/* ==================================================
ELEMENT
================================================== */

const tree =
document.getElementById("fileTree");

const editor =
document.getElementById("codeEditorContent");

const preview =
document.getElementById("previewFrame");

const tabs =
document.getElementById("editorTabs");

const projectName =
document.getElementById("projectName");

/* ==================================================
GENERATE WEBSITE
================================================== */

async function generateWebsite(prompt){

    if(!prompt || prompt.trim()===""){

        alert("Masukkan prompt terlebih dahulu.");

        return;

    }

    const formData = new FormData();

    formData.append("prompt",prompt);

    try{

        const response = await fetch(

            "../api/website_generator.php",

            {

                method:"POST",

                body:formData

            }

        );

        const data = await response.json();

        if(!data.status){

            alert(data.message);

            console.error(data);

            return;

        }

        /* ==============================
           Nama Project
        ============================== */

        currentProject =
            data.project_name ??
            "Website Project";

        if(projectName){

            projectName.textContent =
            currentProject;

        }

        /* ==============================
           Load Semua File
        ============================== */

        loadProject(data.project);

    }

    catch(error){

        console.error(error);

        alert("Gagal terhubung ke server.");

    }

}

/* ==================================================
LOAD PROJECT
================================================== */

function loadProject(files){

    clearProject();

    files.forEach(file=>{

        projectFiles[file.name]=
        file.code ?? "";

    });

    buildTree();

    createTabs();

    openFirstFile();

}

/* ==================================================
CLEAR PROJECT
================================================== */

function clearProject(){

    currentFile="";

    Object.keys(projectFiles).forEach(

        key=>delete projectFiles[key]

    );

    Object.keys(projectTree).forEach(

        key=>delete projectTree[key]

    );

    if(tree){

        tree.innerHTML="";

    }

    if(editor){

        editor.textContent="";

    }

    if(preview){

        preview.srcdoc="";

    }

    if(tabs){

        tabs.innerHTML="";

    }

}
/*
==================================================
MEMBUAT STRUKTUR PROJECT
==================================================
*/

function buildTree(){

    Object.keys(projectFiles).forEach(path=>{

        const parts = path.split("/");

        let node = projectTree;

        parts.forEach((part,index)=>{

            if(!node[part]){

                node[part]={

                    type:index===parts.length-1
                        ?"file"
                        :"folder",

                    children:{},

                    path:path

                };

            }

            node=node[part].children;

        });

    });

    if(tree){

        renderTree(projectTree,tree);

    }

}

/*
==================================================
RENDER PROJECT TREE
==================================================
*/

function renderTree(data,parent){

    parent.innerHTML="";

    Object.keys(data)
    .sort()
    .forEach(name=>{

        const item=data[name];

        if(item.type==="folder"){

            renderFolder(name,item,parent);

        }else{

            renderFile(name,item,parent);

        }

    });

}

/*
==================================================
FOLDER
==================================================
*/

function renderFolder(name,item,parent){

    const wrapper=document.createElement("div");

    wrapper.className="tree-folder";

    const folder=document.createElement("div");

    folder.className="tree-item tree-folder-item";

    folder.innerHTML=`

<span class="folder-arrow">

▶

</span>

📁

<span>

${name}

</span>

`;

    const child=document.createElement("div");

    child.className="tree-children";

    child.style.display="none";

    folder.onclick=function(e){

        e.stopPropagation();

        const open=

            child.style.display==="block";

        child.style.display=

            open?"none":"block";

        folder.querySelector(".folder-arrow")
        .textContent=open?"▶":"▼";

    };

    wrapper.appendChild(folder);

    wrapper.appendChild(child);

    parent.appendChild(wrapper);

    renderTree(item.children,child);

}

/*
==================================================
FILE
==================================================
*/

function renderFile(name,item,parent){

    const row=document.createElement("div");

    row.className="tree-item tree-file";

    row.dataset.path=item.path;

    row.innerHTML=`

${getFileIcon(name)}

<span>

${name}

</span>

`;

    row.onclick=function(e){

        e.stopPropagation();

        document
        .querySelectorAll(".tree-file")
        .forEach(x=>x.classList.remove("active"));

        row.classList.add("active");

        openFile(item.path);

    };

    parent.appendChild(row);

}

/*
==================================================
ICON FILE
==================================================
*/

function getFileIcon(file){

    const ext=file.split(".").pop().toLowerCase();

    switch(ext){

        case "html":

            return "🌐";

        case "css":

            return "🎨";

        case "js":

            return "🟨";

        case "php":

            return "🐘";

        case "json":

            return "📄";

        case "sql":

            return "🗄";

        case "md":

            return "📘";

        case "png":
        case "jpg":
        case "jpeg":
        case "gif":
        case "svg":

            return "🖼";

        default:

            return "📄";

    }

}
/*
==================================================
MEMBUAT TAB EDITOR
==================================================
*/

function createTabs(){

    if(!tabs) return;

    tabs.innerHTML="";

    const files=Object.keys(projectFiles);

    files.forEach(path=>{

        const tab=document.createElement("div");

        tab.className="tab";

        tab.dataset.path=path;

        tab.innerHTML=`

${getFileIcon(path)}

<span>

${path.split("/").pop()}

</span>

`;

        tab.onclick=function(){

            openFile(path);

        };

        tabs.appendChild(tab);

    });

}

/*
==================================================
MEMBUKA FILE
==================================================
*/

function openFile(path){

    currentFile=path;

    /* ===========================
       ACTIVE TAB
    =========================== */

    document.querySelectorAll(".tab")
    .forEach(tab=>{

        tab.classList.remove("active");

    });

    const activeTab=document.querySelector(

        `.tab[data-path="${CSS.escape(path)}"]`

    );

    if(activeTab){

        activeTab.classList.add("active");

    }

    /* ===========================
       ACTIVE TREE
    =========================== */

    document.querySelectorAll(".tree-file")
    .forEach(item=>{

        item.classList.remove("active");

    });

    const activeTree=document.querySelector(

        `.tree-file[data-path="${CSS.escape(path)}"]`

    );

    if(activeTree){

        activeTree.classList.add("active");

    }

    /* ===========================
       CODE
    =========================== */

    const code=projectFiles[path] ?? "";

    if(editor){

        editor.removeAttribute("data-highlighted");

        editor.textContent=code;

        editor.className=

            "language-"+detectLanguage(path);

        if(window.hljs){

            hljs.highlightElement(editor);

        }

    }

    updatePreview(path);

}

/*
==================================================
AUTO OPEN FILE PERTAMA
==================================================
*/

function openFirstFile(){

    const files=Object.keys(projectFiles);

    if(files.length===0){

        return;

    }

    if(projectFiles["index.html"]){

        openFile("index.html");

        return;

    }

    openFile(files[0]);

}

/*
==================================================
DETECT LANGUAGE
==================================================
*/

function detectLanguage(file){

    const ext=file.split(".").pop().toLowerCase();

    switch(ext){

        case "html":

            return "html";

        case "css":

            return "css";

        case "js":

            return "javascript";

        case "php":

            return "php";

        case "json":

            return "json";

        case "sql":

            return "sql";

        case "xml":

            return "xml";

        case "md":

            return "markdown";

        default:

            return "plaintext";

    }

}
/*
==================================================
UPDATE LIVE PREVIEW
==================================================
*/

function updatePreview(selectedFile){

    if(!preview){

        return;

    }

    // Preview hanya menggunakan index.html
    if(!projectFiles["index.html"]){

        preview.srcdoc="";

        return;

    }

    renderPreview(projectFiles["index.html"]);

}

/*
==================================================
RENDER HTML
==================================================
*/

function renderPreview(html){

    if(!preview){

        return;

    }

    if(!html){

        preview.srcdoc="";

        return;

    }

    let page=html;

    /* ===========================
       CSS
    =========================== */

    if(projectFiles["css/style.css"]){

        page=page.replace(

            "</head>",

            "<style>\n"+

            projectFiles["css/style.css"]+

            "\n</style></head>"

        );

    }

    /* ===========================
       JAVASCRIPT
    =========================== */

    if(projectFiles["js/script.js"]){

        page=page.replace(

            "</body>",

            "<script>\n"+

            projectFiles["js/script.js"]+

            "\n<\/script></body>"

        );

    }

    preview.srcdoc=page;

}

/*
==================================================
COPY CURRENT FILE
==================================================
*/

function copyCurrentCode(){

    if(!currentFile){

        alert("Belum ada file yang dipilih.");

        return;

    }

    navigator.clipboard.writeText(

        projectFiles[currentFile]

    ).then(()=>{

        alert("✅ Code berhasil disalin.");

    }).catch(()=>{

        alert("Gagal menyalin code.");

    });

}

/*
==================================================
DOWNLOAD CURRENT FILE
==================================================
*/

function downloadCurrentFile(){

    if(!currentFile){

        return;

    }

    const blob=new Blob(

        [

            projectFiles[currentFile]

        ],

        {

            type:"text/plain"

        }

    );

    const a=document.createElement("a");

    a.href=URL.createObjectURL(blob);

    a.download=currentFile.split("/").pop();

    a.click();

    URL.revokeObjectURL(a.href);

}

/*
==================================================
REFRESH SYNTAX HIGHLIGHT
==================================================
*/

function refreshHighlight(){

    if(!editor){

        return;

    }

    if(window.hljs){

        editor.removeAttribute(

            "data-highlighted"

        );

        hljs.highlightElement(editor);

    }

}

/*
==================================================
REFRESH PREVIEW
==================================================
*/

function refreshPreview(){

    if(currentFile){

        updatePreview(currentFile);

    }

}

/*
==================================================
GLOBAL WINDOW
==================================================
*/

window.generateWebsite=generateWebsite;

window.openFile=openFile;

window.copyCurrentCode=copyCurrentCode;

window.downloadCurrentFile=downloadCurrentFile;

window.refreshPreview=refreshPreview;