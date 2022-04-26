<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST) || empty($_POST['symbol'])) {
    header("Location: /dashboard.php");
    return false;
} else {
    include_once '_connect_db.php';
    include_once '_functions.php';

    $old_id = $_POST['old_id'];
    $symbol = $_POST['symbol'];
    $coin_name = $_POST['name'];

    if (isset($_POST['visibility'])) {
        $visibility = 1;
    } else {
        $visibility = 0;
    }

    if (!is_uploaded_file($_FILES ['picture'] ['tmp_name'])) {
        $statement = 'UPDATE `coins` SET 
                           `id` = :symbol, 
                           `name` = :coin_name, 
                           `visibility` = :visibility 
                            WHERE `coins`.`id` = :old_id;';
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('symbol' => $symbol, 'coin_name' => $coin_name, 'visibility' => $visibility, 'old_id' => $old_id));
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $stmt = $db->query("SELECT `icon_src` FROM `coins` WHERE id = '$old_id'");
        $old_img = $stmt->fetch(PDO::FETCH_ASSOC);

        $old_img_src = $old_img['icon_src'];

        $info = pathinfo($_FILES['picture']['name']);
        $ext = $info['extension'];
        $id = $unique_filename . '.' . $ext;
        $target = '../../public/images/coins/' . $unique_filename . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], $target);

        // Delete the previous coin image from the disk
        $file_pointer = $old_img['icon_src'];
        if (!unlink($file_pointer)) {
            echo 'File deletion error';
            return false;
        }

        $statement = 'UPDATE `coins` SET 
                           `id` = :symbol, 
                           `icon_src` = :target, 
                           `name` = :coin_name, 
                           `visibility` = :visibility 
                            WHERE `coins`.`id` = :old_id;';
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('symbol' => $symbol, 'target' => $target, 'coin_name' => $coin_name, 'visibility' => $visibility, 'old_id' => $old_id));
    }

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Coin successfully edited.';
    header("Location: /dashboard.php");
}