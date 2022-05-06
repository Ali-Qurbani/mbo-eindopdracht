<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}
unset($_SESSION["dashboard-alert-type"]);
unset($_SESSION["dashboard-message"]);

include("_connect_db.php");

if (empty($_GET) || !isset($_GET["id"])) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'One or more required fields to change visibility are empty.';
    header("Location: /admin_coins.php");
    return false;
}

$cat_id = $_GET["id"];

$statement = $db->prepare('SELECT `category_id`, `coin_id` FROM `coin_categories` WHERE `category_id` = :id');
$statement->execute(array('id' => $cat_id));
$coins = $statement->fetchAll(PDO::FETCH_OBJ);

foreach ($coins as $coin) {
    $statement2 = $db->prepare("UPDATE `coins` SET `visibility` = '0' WHERE `coins`.`id` = :coin_id;", array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $statement2->execute(array('coin_id' => $coin->coin_id));

}

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Coin category visibility successfully set to hidden.';
header("Location: /admin_coins.php");