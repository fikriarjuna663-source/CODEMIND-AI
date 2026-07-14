document.addEventListener("click",function(e){

if(e.target.classList.contains("copy-btn")){

let code=e.target.parentElement.querySelector("code").innerText;

navigator.clipboard.writeText(code);

e.target.innerHTML="Copied ✓";

setTimeout(()=>{

e.target.innerHTML="Copy";

},1500);

}

});