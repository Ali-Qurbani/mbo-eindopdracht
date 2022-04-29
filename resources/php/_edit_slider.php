<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST) || empty($_POST['id'])) {
    header("Location: /admin_sliders.php");
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
        $statement = 'UPDATE `slider-images` SET 
                           `title` = :title, 
                           `description` = :description, 
                           `visibility` = :visibility 
                            WHERE `slider-images`.`id` = :image_id;';
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('title' => $title, 'description' => $description, 'visibility' => $visibility, 'image_id' => $image_id));
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $stmt = $db->query("SELECT `image_src` FROM `slider-images` WHERE id = '$image_id'");
        $old_img = $stmt->fetch(PDO::FETCH_ASSOC);

        $old_img_src = $old_img['image_src'];

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

        $statement = 'UPDATE `slider-images` SET 
                           `image_src` = :target, 
                           `title` = :title, 
                           `description` = :description, 
                           `visibility` = :visibility 
                            WHERE `slider-images`.`id` = :image_id;';
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('target' => $target, 'title' => $title, 'description' => $description, 'visibility' => $visibility, 'image_id' => $image_id));
    }

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Changes successfully saved.';
    header("Location: /admin_sliders.php");
}