<?php

require_once "../config/auth.php";

checkLogin();

require_once "../config/koneksi.php";

$nama = $_SESSION["nama"];
$role = $_SESSION["role"];

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | CodeMind AI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

<div class="container-fluid">

<span class="navbar-brand">

💻 CodeMind AI

</span>

<a
href="../logout.php"
class="btn btn-danger">

Logout

</a>

</div>

</nav>

<div class="container mt-5">

<div class="card shadow">

<div class="card-body">

<h2>

Selamat Datang,

<?= htmlspecialchars($nama) ?>

👋

</h2>

<hr>

<p>

Role :

<strong>

<?= htmlspecialchars($role) ?>

</strong>

</p>

<p>

Login berhasil.

</p>

<div class="mt-4">

<a
href="ai_chat.php"
class="btn btn-primary">

🤖 AI Chat

</a>

</div>

</div>

</div>

</div>

</body>

</html>