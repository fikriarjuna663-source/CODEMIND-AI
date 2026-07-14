<?php

require_once "../config/auth.php";
require_once "../config/database.php";
require_once "gemini.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit;
}

$prompt = trim($_POST["prompt"]);

if ($prompt == "") {
    echo json_encode([
        "status" => false
    ]);
    exit;
}

$user_id = $_SESSION["user_id"];

/*
==============================
CEK CHAT TERAKHIR
==============================
*/

$query = mysqli_query($conn,"SELECT * FROM conversations
WHERE user_id='$user_id'
ORDER BY id DESC
LIMIT 1");

if(mysqli_num_rows($query)==0){

    mysqli_query($conn,"INSERT INTO conversations(user_id,title)
    VALUES('$user_id','New Chat')");

    $conversation_id=mysqli_insert_id($conn);

}else{

    $row=mysqli_fetch_assoc($query);

    $conversation_id=$row["id"];

}

/*
==============================
SIMPAN PESAN USER
==============================
*/

mysqli_query($conn,"INSERT INTO messages(conversation_id,sender,message)
VALUES('$conversation_id','user','$prompt')");

/*
==============================
KIRIM KE GEMINI
==============================
*/

$result = askGemini($prompt);

$json = json_decode($result,true);

$answer = $json["candidates"][0]["content"]["parts"][0]["text"] ?? "AI tidak memberikan jawaban.";

/*
==============================
SIMPAN JAWABAN AI
==============================
*/

mysqli_query($conn,"INSERT INTO messages(conversation_id,sender,message)
VALUES('$conversation_id','ai','$answer')");

echo json_encode([
    "status"=>true,
    "answer"=>$answer
]);