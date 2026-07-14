<?php

require_once "../config/auth.php";
require_once "../config/session.php";

$_SESSION['conversation_id'] = intval($_POST['conversation_id']);

echo json_encode([
    "status" => true
]);