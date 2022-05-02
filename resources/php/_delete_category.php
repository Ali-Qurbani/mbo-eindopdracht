<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
unset($_SESSION["dashboard-alert-type"]);
unset($_SESSION["dashboard-message"]);

include("_connect_db.php");

if (!empty($_GET) && isset($_GET["category_id"]) && isset($_GET["coin_id"])) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'Unspecified target.';
    header("Location: /admin_coins.php");
    return false;
}

$id = $_GET["id"];

// Delete the category
$statement = "DELETE FROM `category` WHERE `category`.`id` = :id";
$sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array('id' => $id));

// Reset AUTO_INCREMENT to the lowest value possible
$sth_ai = $db->prepare("ALTER TABLE `category` AUTO_INCREMENT = 1");
$sth_ai->execute();

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Category successfully removed.';
header("Location: /admin_coins.php");