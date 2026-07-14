<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$id = intval($_POST['id']);

$title = mysqli_real_escape_string($conn,$_POST['title']);

mysqli_query($conn,"
UPDATE conversations
SET title='$title'
WHERE id='$id'
");

echo json_encode([
    "status"=>true
]);