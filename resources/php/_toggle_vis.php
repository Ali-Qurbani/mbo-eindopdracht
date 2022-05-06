<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}

require_once '_functions.php';
require_once '_connect_db.php';

$type = $_GET['type'];
$id = $_GET['id'];

switch ($type) {
    case 'slider';
        $statement_select = $db->prepare("SELECT `visibility` FROM `slider-images` WHERE `id` = :id;");
        $statement_update = $db->prepare("UPDATE `slider-images` SET `visibility` = :vis WHERE `slider-images`.`id` = :id;");
        $re_dir = 'admin_sliders.php';
        break;
    case 'coin';
        $statement_select = $db->prepare("SELECT `visibility` FROM `coins` WHERE `id` = :id;");
        $statement_update = $db->prepare("UPDATE `coins` SET `visibility` = :vis WHERE `coins`.`id` = :id;");
        $re_dir = 'admin_coins.php';
        break;
    default;
        $re_dir = 'dashboard.php';
        break;
}

if (isset($statement_select) && isset($statement_update) && isset($id)) {

    $statement_select->execute(array('id' => $id));

    $results = $statement_select->fetch(PDO::FETCH_OBJ);
    $vis = $results->visibility;

    if ($vis === '1') {
        $visibility = '0';
    } else {
        $visibility = '1';
    }

    $statement_update->execute(array('vis' => $visibility, 'id' => $id));

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Toggled visibility on '.$type.' '.$id.'.';
} else {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'Type is undefined.';
}
$db = null;
header("Location: /$re_dir");