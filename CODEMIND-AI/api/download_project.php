<?php

require_once "../config/auth.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit;
}

echo json_encode([
    "status" => true,
    "message" => "Fitur Download ZIP akan diaktifkan pada tahap berikutnya."
]);