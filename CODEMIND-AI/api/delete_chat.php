<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$id = intval($_POST['id']);

mysqli_query($conn,"DELETE FROM conversations WHERE id='$id'");

echo "success";