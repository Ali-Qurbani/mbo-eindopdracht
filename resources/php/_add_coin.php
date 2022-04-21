<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (!isset($_POST)) {
    header("Location: /dashboard.php");
    return false;
} else {
    $name = $_POST['name'];
    $exchange_code = $_POST['code'];
}