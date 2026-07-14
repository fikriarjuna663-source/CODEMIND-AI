<?php

require_once "../config/database.php";
require_once "../config/helper.php";
require_once "../config/session.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/dashboard.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = trim($_POST['login']);
    $password = $_POST['password'];

    $login = mysqli_real_escape_string($conn, $login);

    $sql = "SELECT * FROM users WHERE username='$login' OR email='$login' LIMIT 1";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Query Error : " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama_lengkap'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../dashboard/dashboard.php");
            exit;

        } else {

            $error = "Password salah.";

        }

    } else {

        $error = "Username atau Email tidak ditemukan.";

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | CodeMind AI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="background"></div>

<div class="container d-flex justify-content-center align-items-center vh-100">

<div class="landing-card">

<h2 class="text-center mb-3">
💻 CodeMind AI
</h2>

<h4 class="text-center mb-4">
Login
</h4>

<?php if (!empty($error)) : ?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Username atau Email

</label>

<input
type="text"
name="login"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
class="btn btn-primary w-100">

Login

</button>

<div class="text-center mt-3">

Belum punya akun?

<a href="register.php">

Register

</a>

</div>

</form>

</div>

</div>

</body>

</html>