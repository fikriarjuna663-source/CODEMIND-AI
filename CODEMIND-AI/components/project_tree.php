<?php

function projectTree($text){

$text=htmlspecialchars($text);

return "

<div class='project-tree'>

<pre>$text</pre>

</div>

";

}