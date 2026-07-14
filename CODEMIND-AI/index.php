<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeMind AI - Intelligent Programming Assistant</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="background"></div>

<div class="container">

    <div class="landing-card">

        <div class="logo">
            💻
        </div>

        <h1>CodeMind AI</h1>

        <p>
            Intelligent Programming Assistant powered by Artificial Intelligence.
        </p>

        <div class="menu-button">

            <a href="auth/login.php" class="btn btn-neon">
                Login
            </a>

            <a href="auth/register.php" class="btn btn-outline-light">
                Register
            </a>

        </div>

        <div class="footer">
            © 2026 CodeMind AI
        </div>

    </div>

</div>

</body>
</html>