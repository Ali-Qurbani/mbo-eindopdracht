<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST)) {
    header("Location: /admin_sliders.php");
    return false;
} else {
    unset($_SESSION["dashboard-alert-type"]);
    unset($_SESSION["dashboard-message"]);

    include_once '_connect_db.php';
    include_once '_functions.php';

    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_POST['visibility'])) {
        $visibility = 1;
    } else {
        $visibility = 0;
    }

    if (!is_uploaded_file($_FILES ['picture'] ['tmp_name'])) {
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = 'No image found.';
        header("Location: /admin_sliders.php");
        return false;
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $statement2 = 'SELECT `id` from `slider-images` where id = :id';
        $sth2 = $db->prepare($statement2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth2->execute(array('id' => $unique_filename));
        $slider_result = $sth2->fetch();

        if (isset($slider_result['id'])) {
            header('Location: /addslider.php?title=' . $title . '&description=' . $description);
        } else {
            $info = pathinfo($_FILES['picture']['name']);
            $ext = $info['extension'];
            $id = $unique_filename . '.' . $ext;
            $target = '../../public/images/sliders/' . $unique_filename . '.' . $ext;
            move_uploaded_file($_FILES['picture']['tmp_name'], $target);

            switch ($ext) {
                case 'png':
                    $image = imagecreatefrompng('../../public/images/sliders/' . $id);
                    break;
                case 'jpg':
                    $image = imagecreatefromjpeg('../../public/images/sliders/' . $id);
                    break;
                case 'gif':
                    $image = imagecreatefromgif('../../public/images/sliders/' . $id);
                    break;
                case 'webp':
                    $image = imagecreatefromwebp('../../public/images/sliders/' . $id);
                    break;
            }
        }
    }

    try {
        $statement3 = 'INSERT INTO `slider-images` (`id`, `image_src`, `title`, `description`, `visibility`) 
                    VALUES (NULL, :target, :title, :description, :visibility);';
        $sth3 = $db->prepare($statement3, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth3->execute(array('target' => $target, 'title' => $title, 'description' => $description, 'visibility' => $visibility));
    } catch (PDOException $e) {
        unlink($target);
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = 'Something went wrong storing the slider into the database. '.$target.' '.$e;
        header("Location: /admin_sliders.php");
        return false;
    }

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Slider successfully added.';
    header("Location: /admin_sliders.php");
}