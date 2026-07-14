<?php

require_once "../config/auth.php";
require_once "../config/gemini_config.php";

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");

$prompt = $_GET['prompt'] ?? "";

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . GEMINI_API_KEY;

$data = [

"contents"=>[
[
"parts"=>[
[
"text"=>$prompt
]
]
]
]

];

$ch=curl_init($url);

curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

curl_setopt($ch,CURLOPT_POST,true);

curl_setopt($ch,CURLOPT_HTTPHEADER,[

"Content-Type: application/json"

]);

curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));

$result=curl_exec($ch);

curl_close($ch);

$json=json_decode($result,true);

$text=$json["candidates"][0]["content"]["parts"][0]["text"] ?? "";

$words=explode(" ",$text);

foreach($words as $word){

echo "data: ".$word." \n\n";

ob_flush();
flush();

usleep(40000);

}

echo "data: [DONE]\n\n";

flush();

?>