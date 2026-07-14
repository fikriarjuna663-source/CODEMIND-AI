<?php

require_once __DIR__ . "/session.php";

function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit;
    }
}