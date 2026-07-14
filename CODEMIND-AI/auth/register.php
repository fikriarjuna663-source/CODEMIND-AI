<?php

require_once "../config/database.php";
require_once "../config/helper.php";
require_once "../config/session.php";

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/dashboard.php");
    exit;
}

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $nama      = bersihkan($_POST['nama']);
    $username  = bersihkan($_POST['username']);
    $email     = bersihkan($_POST['email']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm'];

    if (
        empty($nama) ||
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($confirm)
    ) {

        $error = "Semua field wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid.";

    } elseif ($password != $confirm) {

        $error = "Konfirmasi password tidak sama.";

    } else {

        $cek = mysqli_query(
            $conn,
            "SELECT id FROM users
             WHERE username='$username'
             OR email='$email'"
        );

        if (mysqli_num_rows($cek) > 0) {

            $error = "Username atau Email sudah digunakan.";

        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $simpan = mysqli_query(
                $conn,
                "INSERT INTO users
                (
                    nama_lengkap,
                    username,
                    email,
                    password,
                    role,
                    status
                )
                VALUES
                (
                    '$nama',
                    '$username',
                    '$email',
                    '$hash',
                    'user',
                    'aktif'
                )"
            );

            if ($simpan) {

                echo "<script>
                        alert('Register Berhasil');
                        window.location='login.php';
                      </script>";
                exit;

            } else {

                $error = "Register gagal.";

            }

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Register | CodeMind AI</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="background"></div>

<div class="container d-flex justify-content-center align-items-center vh-100">

<div class="landing-card">

<h2 class="text-center mb-4">

💻 CodeMind AI

</h2>

<h4 class="text-center mb-4">

Register

</h4>

<?php if($error!=""){ ?>

<div class="alert alert-danger">

<?= $error; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
name="nama"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

Konfirmasi Password

</label>

<input
type="password"
name="confirm"
class="form-control"
required>

</div>

<button
type="submit"
name="register"
class="btn btn-primary w-100">

Daftar

</button>

<div class="text-center mt-4">

Sudah punya akun?

<a href="login.php">

Login

</a>

</div>

</form>

</div>

</div>

</body>

</html>