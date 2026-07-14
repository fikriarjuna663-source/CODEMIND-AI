function parseMarkdown(text){

text=text.replace(/&/g,"&amp;");
text=text.replace(/</g,"&lt;");
text=text.replace(/>/g,"&gt;");

text=text.replace(/^### (.*$)/gim,"<h3>$1</h3>");
text=text.replace(/^## (.*$)/gim,"<h2>$1</h2>");
text=text.replace(/^# (.*$)/gim,"<h1>$1</h1>");

text=text.replace(/\*\*(.*?)\*\*/g,"<strong>$1</strong>");

text=text.replace(/\*(.*?)\*/g,"<em>$1</em>");

text=text.replace(/```([\s\S]*?)```/g,function(match,code){

return `
<div class="code-container">

<button class="copy-btn">

Copy

</button>

<pre><code>${code}</code></pre>

</div>

`;

});

text=text.replace(/\n/g,"<br>");

return text;

}