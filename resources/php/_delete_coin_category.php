<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}
unset($_SESSION["dashboard-alert-type"]);
unset($_SESSION["dashboard-message"]);

include("_connect_db.php");

if (!empty($_GET) && isset($_GET["category_id"]) && isset($_GET["coin_id"])) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'One or more required fields to remove coin category are empty.';
    header("Location: /admin_coins.php");
    return false;
}

$coin_id = $_GET["coin_id"];
$category_id = $_GET["cat_id"];

$statement2 = "DELETE FROM `coin_categories` WHERE `coin_categories`.`coin_id` = :coin_id AND `coin_categories`.`category_id` = :category_id";
$sth2 = $db->prepare($statement2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth2->execute(array('coin_id' => $coin_id, 'category_id' => $category_id));

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Coin category successfully removed.';
header("Location: /admin_coins.php");