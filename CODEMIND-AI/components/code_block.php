<?php

function renderCode($text)
{
    $text = htmlspecialchars($text);

    return '
    <div class="code-container">

        <button class="copy-btn">
            Copy
        </button>

        <pre><code>'.$text.'</code></pre>

    </div>
    ';
}