<?php

require_once "../config/auth.php";

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>History</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/history.css">

</head>

<body>

<div class="container mt-5">

<div class="d-flex justify-content-between mb-4">

<h2>🕘 History Chat</h2>

<button
class="btn btn-primary"
id="newChat">

+ New Chat

</button>

</div>

<div id="historyList"></div>

<a
href="ai_chat.php"
class="btn btn-secondary mt-4">

Kembali

</a>

</div>

<script src="../assets/js/history.js"></script>

</body>

</html>