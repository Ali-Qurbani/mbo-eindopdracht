<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}

if (empty($_POST) || $_POST['name'] === '') {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'A category requires a name to be created.';
    header("Location: /admin_coins.php");
    return false;
} else {
    include_once '_connect_db.php';

    $name = $_POST['name'];

    $statement = 'INSERT INTO `category` (`id`, `name`) VALUES (NULL, :name);';
    $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array('name' => $name));

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Category successfully created.';
    header("Location: /admin_coins.php");
}