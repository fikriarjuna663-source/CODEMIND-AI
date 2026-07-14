<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];

$title = "New Chat";

mysqli_query($conn,"INSERT INTO conversations(user_id,title)
VALUES('$user_id','$title')");

echo json_encode([
    "status"=>true,
    "conversation_id"=>mysqli_insert_id($conn)
]);
