<?php

require_once "../config/auth.php";
require_once "../config/database.php";

header("Content-Type: application/json");

$conversation_id = intval($_GET['conversation_id']);

$data = [];

$query = mysqli_query($conn,"
SELECT *
FROM messages
WHERE conversation_id='$conversation_id'
ORDER BY id ASC
");

while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data);