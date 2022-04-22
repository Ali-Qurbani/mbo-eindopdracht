<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST) || empty($_POST['id'])) {
    header("Location: /dashboard.php");
    return false;
} else {
    include_once '_connect_db.php';
    include_once '_functions.php';

    $image_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];


    if (isset($_POST['visibility'])) {
        $visibility = 1;
    } else {
        $visibility = 0;
    }

    if (!is_uploaded_file($_FILES ['picture'] ['tmp_name'])) {
        $stmt = $conn->prepare("UPDATE `slider-images` SET 
                           `title` = ?, 
                           `description` = ?, 
                           `visibility` = ? 
                            WHERE `slider-images`.`id` = ?;");

        $stmt->bind_param("ssii", $title, $description, $visibility, $image_id);
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $stmt3 = $conn->prepare("SELECT `image_src` FROM `slider-images` WHERE id = '$image_id'");
        $stmt3->execute();
        $stmt3->bind_result($db_image_src);

        while (mysqli_stmt_fetch($stmt3)) {
            $old_img_src = $db_image_src;
        }

        $info = pathinfo($_FILES['picture']['name']);
        $ext = $info['extension'];
        $id = $unique_filename . '.' . $ext;
        $target = '../../public/images/sliders/' . $unique_filename . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], $target);

        // Delete the previous slider image from the disk
        $file_pointer = $old_img_src;
        if (!unlink($file_pointer)) {
            echo 'File deletion error';
            return false;
        }

        $stmt = $conn->prepare("UPDATE `slider-images` SET 
                           `image_src` = ?, 
                           `title` = ?, 
                           `description` = ?, 
                           `visibility` = ? 
                            WHERE `slider-images`.`id` = ?;");

        $stmt->bind_param("sssii", $target, $title, $description, $visibility, $image_id);
    }

    $stmt->execute();
    $stmt->close();

    header("Location: /dashboard.php");
}