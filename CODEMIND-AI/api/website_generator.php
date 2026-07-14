<?php

require_once "gemini.php";

header("Content-Type: application/json");

/*
==================================================
REQUEST VALIDATION
==================================================
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    echo json_encode([
        "status" => false,
        "message" => "Method tidak diizinkan."
    ]);

    exit;

}

/*
==================================================
GET PROMPT
==================================================
*/

$prompt = trim($_POST["prompt"] ?? "");

if ($prompt === "") {

    echo json_encode([
        "status" => false,
        "message" => "Prompt kosong."
    ]);

    exit;

}

/*
==================================================
SYSTEM PROMPT
==================================================
*/

$systemPrompt = <<<PROMPT

Kamu adalah CodeMind AI Professional Website Generator.

TUGAS

Buat website profesional berdasarkan permintaan user.

WAJIB

Balas HANYA JSON.

Jangan gunakan Markdown.

Jangan gunakan ```html.

Jangan gunakan ```css.

Jangan gunakan ```javascript.

Jangan gunakan ```json.

Jangan berikan penjelasan.

Jangan menambahkan teks selain JSON.

FORMAT WAJIB

[
 {
   "name":"index.html",
   "code":"..."
 },
 {
   "name":"css/style.css",
   "code":"..."
 },
 {
   "name":"js/script.js",
   "code":"..."
 }
]

ATURAN

Minimal menghasilkan file berikut:

index.html

css/style.css

js/script.js

Jika diperlukan tambahkan:

README.md

database.sql

php/config.php

api/

assets/img/

Gunakan

HTML5

CSS3

JavaScript ES6

Responsive Layout

Modern UI

Glassmorphism

Gradient

Animation

Dark Theme

Professional Design

Semua file HARUS lengkap.

CSS hanya berada di css/style.css

JavaScript hanya berada di js/script.js

Jangan pernah menggabungkan CSS ke HTML.

Jangan pernah menggabungkan JavaScript ke HTML.

Setiap file wajib memiliki isi.

Prompt User

{$prompt}

PROMPT;

/*
==================================================
REQUEST GEMINI
==================================================
*/

$response = askGemini($systemPrompt);
/*
==================================================
DECODE GEMINI RESPONSE
==================================================
*/

$data = json_decode($response, true);

if (

    !isset($data["candidates"][0]["content"]["parts"][0]["text"])

) {

    echo json_encode([

        "status" => false,

        "message" => "Gemini tidak memberikan respon.",

        "debug_info" => $data

    ]);

    exit;

}

/*
==================================================
GET AI TEXT
==================================================
*/

$text = $data["candidates"][0]["content"]["parts"][0]["text"];

$text = trim($text);

/*
==================================================
REMOVE MARKDOWN
==================================================
*/

$text = preg_replace('/```json/i', '', $text);
$text = preg_replace('/```html/i', '', $text);
$text = preg_replace('/```css/i', '', $text);
$text = preg_replace('/```javascript/i', '', $text);
$text = preg_replace('/```js/i', '', $text);
$text = preg_replace('/```php/i', '', $text);
$text = preg_replace('/```sql/i', '', $text);
$text = preg_replace('/```xml/i', '', $text);
$text = preg_replace('/```markdown/i', '', $text);
$text = str_replace("```","",$text);

$text = trim($text);

/*
==================================================
FIND JSON ARRAY
==================================================
*/

if(

    preg_match('/\[[\s\S]*\]/', $text, $match)

){

    $text = $match[0];

}

/*
==================================================
PARSE PROJECT JSON
==================================================
*/

$project = json_decode($text, true);

/*
==================================================
SECOND PARSE
==================================================
*/

if(

    json_last_error() !== JSON_ERROR_NONE

){

    $fixed = preg_replace('/,\s*([\]}])/', '$1', $text);

    $project = json_decode($fixed, true);

}

/*
==================================================
CHECK JSON
==================================================
*/

if(

    !is_array($project)

){

    echo json_encode([

        "status" => false,

        "message" => "AI menghasilkan JSON tidak valid.",

        "raw_response" => $response,

        "ai_text" => $text

    ]);

    exit;

}
/*
==================================================
VALIDASI PROJECT
==================================================
*/

$result = [];

$usedFiles = [];

foreach($project as $file){

    if(!is_array($file)){

        continue;

    }

    /*
    ==============================
    FILE NAME
    ==============================
    */

    $name = "";

    if(isset($file["name"])){

        $name = trim($file["name"]);

    }

    if($name===""){

        continue;

    }

    /*
    ==============================
    FILE CONTENT
    ==============================
    */

    $code = "";

    if(isset($file["code"])){

        $code = trim($file["code"]);

    }
    elseif(isset($file["content"])){

        $code = trim($file["content"]);

    }
    elseif(isset($file["text"])){

        $code = trim($file["text"]);

    }

    /*
    ==============================
    NORMALISASI PATH
    ==============================
    */

    $name = str_replace("\\","/",$name);

    while(strpos($name,"//")!==false){

        $name = str_replace("//","/",$name);

    }

    /*
    ==============================
    HAPUS DUPLIKAT
    ==============================
    */

    if(isset($usedFiles[$name])){

        continue;

    }

    $usedFiles[$name]=true;

    /*
    ==============================
    AUTO FILE DEFAULT
    ==============================
    */

    if($name==="style.css"){

        $name="css/style.css";

    }

    if($name==="script.js"){

        $name="js/script.js";

    }

    /*
    ==============================
    SIMPAN
    ==============================
    */

    $result[]=[

        "name"=>$name,

        "code"=>$code

    ];

}

/*
==================================================
CEK HASIL
==================================================
*/

if(count($result)===0){

    echo json_encode([

        "status"=>false,

        "message"=>"AI tidak menghasilkan file project."

    ]);

    exit;

}
/*
==================================================
PASTIKAN FILE WAJIB ADA
==================================================
*/

$requiredFiles = [

    "index.html",
    "css/style.css",
    "js/script.js"

];

foreach($requiredFiles as $required){

    $exists = false;

    foreach($result as $file){

        if($file["name"] === $required){

            $exists = true;
            break;

        }

    }

    if(!$exists){

        $defaultCode = "";

        switch($required){

            case "index.html":

                $defaultCode = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CodeMind AI Project</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Website berhasil dibuat.</h1>

<script src="js/script.js"></script>

</body>
</html>
HTML;
            break;

            case "css/style.css":

                $defaultCode = <<<CSS
body{

    margin:0;

    padding:40px;

    font-family:Arial,sans-serif;

    background:#0F172A;

    color:white;

}
CSS;
            break;

            case "js/script.js":

                $defaultCode = <<<JS
console.log("CodeMind AI");
JS;
            break;

        }

        $result[] = [

            "name" => $required,

            "code" => $defaultCode

        ];

    }

}

/*
==================================================
URUTKAN FILE
==================================================
*/

usort($result,function($a,$b){

    return strcmp($a["name"],$b["name"]);

});

/*
==================================================
PROJECT NAME
==================================================
*/

$projectName = "Website Project";

if(strlen($prompt) > 0){

    $projectName = ucfirst(

        substr(

            preg_replace('/[^a-zA-Z0-9 ]/','',$prompt),

            0,

            40

        )

    );

}

/*
==================================================
SUCCESS
==================================================
*/

echo json_encode([

    "status" => true,

    "project_name" => $projectName,

    "total_files" => count($result),

    "project" => $result

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

exit;