<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
unset($_SESSION["dashboard-alert-type"]);
unset($_SESSION["dashboard-message"]);

include("_connect_db.php");
$id = $_GET["id"];

$statement = $db->query("SELECT `icon_src` FROM `coins` WHERE id = '$id'");
$result = $statement->fetch();

if (empty($result)) {
    header("Location: /admin_coins.php");
    return false;
}

$file_pointer = $result['icon_src'];
if (!unlink($file_pointer)) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'File deletion error.';
    header("Location: /admin_coins.php");
    return false;
}

    $statement = "DELETE FROM `coins` WHERE id = :id";
    $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array('id' => $id));


$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Coin successfully removed.';
header("Location: /admin_coins.php");