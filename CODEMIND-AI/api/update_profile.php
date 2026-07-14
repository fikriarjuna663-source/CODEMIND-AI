<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$id=$_SESSION['user_id'];

$nama=mysqli_real_escape_string($conn,$_POST['nama']);

$username=mysqli_real_escape_string($conn,$_POST['username']);

$email=mysqli_real_escape_string($conn,$_POST['email']);

mysqli_query($conn,"
UPDATE users
SET

nama_lengkap='$nama',

username='$username',

email='$email'

WHERE id='$id'
");

$_SESSION['nama']=$nama;

$_SESSION['username']=$username;

echo json_encode([
"status"=>true
]);