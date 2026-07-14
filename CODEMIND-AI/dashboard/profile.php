<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$id = $_SESSION['user_id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$id'"));

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>👤 Profile</h2>

<hr>

<table class="table table-bordered">

<tr>

<th>Nama</th>

<td><?= $data['nama_lengkap']; ?></td>

</tr>

<tr>

<th>Username</th>

<td><?= $data['username']; ?></td>

</tr>

<tr>

<th>Email</th>

<td><?= $data['email']; ?></td>

</tr>

<tr>

<th>Bergabung</th>

<td><?= $data['created_at']; ?></td>

</tr>

</table>

<a href="dashboard.php" class="btn btn-primary">

Kembali

</a>

</div>

</body>

</html>