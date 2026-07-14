<?php

require_once "../config/auth.php";

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<h2>👤 Profile</h2>

<hr>

<form id="profileForm">

<div class="mb-3">

<label>Nama Lengkap</label>

<input
type="text"
id="nama"
class="form-control">

</div>

<div class="mb-3">

<label>Username</label>

<input
type="text"
id="username"
class="form-control">

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
id="email"
class="form-control">

</div>

<button
class="btn btn-primary">

Simpan

</button>

</form>

</div>

<script src="../assets/js/profile.js"></script>

</body>

</html>