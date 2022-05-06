<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}

if (empty($_POST['id']) || empty($_POST['name'])) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'Name cannot be empty.';
    header("Location: /admin_coins.php");
    return false;
}

$name = $_POST['name'];
$id = $_POST['id'];

include_once '_connect_db.php';

$statement = "UPDATE `category` SET `name` = :name WHERE `category`.`id` = :id;";
$sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array('name' => $name, 'id' => $id));

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Changes successfully saved.';
header("Location: /admin_coins.php#cat".$id);