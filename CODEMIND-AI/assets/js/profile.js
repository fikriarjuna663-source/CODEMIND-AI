fetch("../api/profile.php")

.then(res=>res.json())

.then(data=>{

document.getElementById("nama").value=data.nama_lengkap;

document.getElementById("username").value=data.username;

document.getElementById("email").value=data.email;

});

document.getElementById("profileForm")

.addEventListener("submit",function(e){

e.preventDefault();

const form=new FormData();

form.append("nama",nama.value);

form.append("username",username.value);

form.append("email",email.value);

fetch("../api/update_profile.php",{

method:"POST",

body:form

})

.then(res=>res.json())

.then(()=>{

alert("Profile berhasil diperbarui.");

});

});