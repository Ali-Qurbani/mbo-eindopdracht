<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST) || $_POST['coin_id'] === '' || $_POST['category_id'] === '') {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'One or more of the required fields are empty';
    header("Location: /admin_coins.php");
    return false;
} else {
    include_once '_connect_db.php';

    $coin_id = $_POST['coin_id'];
    $category_id = $_POST['category_id'];


    $statement = $db->prepare("SELECT COUNT(category_id) FROM `coin_categories` WHERE `coin_id` = :coin_id AND `category_id` = :cat_id");
    $statement->execute(array('coin_id' => $coin_id, 'cat_id' => $category_id));
    $count = $statement->fetch(PDO::FETCH_COLUMN);

    if ($count !== '0') {
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = $coin_id.' is already in category '.$category_id;
        header("Location: /admin_coins.php");
        return false;
    }

    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    try {
        $statement2 = 'INSERT INTO `coin_categories` (`coin_id`, `category_id`) VALUES (:coin_id, :cat_id);';
        $sth2 = $db->prepare($statement2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth2->execute(array('coin_id' => $coin_id, 'cat_id' => $category_id));
        $_SESSION['dashboard-alert-type'] = 'success';
        $_SESSION['dashboard-message'] = 'Coin category successfully inserted.';
        header("Location: /admin_coins.php");
    } catch (Exception $e) {
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = 'Something went wrong please try again later.';
        header("Location: /admin_coins.php");
        return false;
    }
}