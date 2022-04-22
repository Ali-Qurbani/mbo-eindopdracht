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
        $stmt = $conn->prepare("UPDATE `coins` SET 
                           `id` = ?, 
                           `naam` = ?, 
                           `zichtbaar` = ? 
                            WHERE `coins`.`id` = ?;");

        $stmt->bind_param("ssis", $symbol, $coin_name, $visibility, $old_id);
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $stmt3 = $conn->prepare("SELECT `icon_src` FROM `coins` WHERE id = '$old_id'");
        $stmt3->execute();
        $stmt3->bind_result($db_coin_src);

        while (mysqli_stmt_fetch($stmt3)) {
            $old_img_src = $db_coin_src;
        }

        $info = pathinfo($_FILES['picture']['name']);
        $ext = $info['extension'];
        $id = $unique_filename . '.' . $ext;
        $target = '../../public/images/coins/' . $unique_filename . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], $target);

        // Delete the previous coin image from the disk
        $file_pointer = $db_coin_src;
        if (!unlink($file_pointer)) {
            echo 'File deletion error';
            return false;
        }

        $stmt = $conn->prepare("UPDATE `coins` SET 
                           `icon_src` = ?, 
                           `id` = ?, 
                           `naam` = ?, 
                           `zichtbaar` = ? 
                            WHERE `coins`.`id` = ?;");

        $stmt->bind_param("sssis", $target, $symbol, $coin_name, $visibility, $old_id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: /dashboard.php");
}