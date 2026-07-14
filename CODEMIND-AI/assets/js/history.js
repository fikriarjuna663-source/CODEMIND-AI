loadHistory();

function loadHistory(){

fetch("../api/history.php")

.then(res=>res.json())

.then(data=>{

let html="";

if(data.length==0){

html=`
<div class="alert alert-info">
Belum ada history.
</div>
`;

}else{

data.forEach(chat=>{

html+=`

<div class="card mb-3">

<div class="card-body">

<div class="d-flex justify-content-between align-items-center">

<div
style="cursor:pointer"
onclick="openChat(${chat.id})">

<h5>${chat.title}</h5>

<small>${chat.created_at}</small>

</div>

<div>

<button
class="btn btn-warning btn-sm"
onclick="renameChat(${chat.id})">

Rename

</button>

<button
class="btn btn-danger btn-sm"
onclick="deleteChat(${chat.id})">

Delete

</button>

</div>

</div>

</div>

</div>

`;

});

}

document.getElementById("historyList").innerHTML=html;

});

}

function openChat(id){

const form=new FormData();

form.append("conversation_id",id);

fetch("../api/open_chat.php",{

method:"POST",

body:form

})

.then(res=>res.json())

.then(()=>{

window.location="ai_chat.php";

});

}

document.getElementById("newChat").onclick=function(){

fetch("../api/new_chat.php",{

method:"POST"

})

.then(()=>{

window.location="ai_chat.php";

});

};

function deleteChat(id){

if(!confirm("Hapus chat?")) return;

const form=new FormData();

form.append("id",id);

fetch("../api/delete_chat.php",{

method:"POST",

body:form

})

.then(()=>{

loadHistory();

});

}

function renameChat(id){

let title=prompt("Judul Chat");

if(title==null||title=="") return;

const form=new FormData();

form.append("id",id);

form.append("title",title);

fetch("../api/rename_chat.php",{

method:"POST",

body:form

})

.then(()=>{

loadHistory();

});

}