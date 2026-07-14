<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn,"
SELECT *
FROM conversations
WHERE user_id='$user_id'
ORDER BY id DESC
");

$data = [];

while($row = mysqli_fetch_assoc($query)){

    $data[] = $row;

}

header("Content-Type: application/json");

echo json_encode($data);