<?php
session_start();
if (!isset($_SESSION["id"]) || empty($_GET)) {
    header("Location: /_login.php");
    return false;
}