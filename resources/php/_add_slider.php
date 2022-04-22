<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST)) {
    header("Location: /dashboard.php");
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
        header("Location: /dashboard.php");
        return false;
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $stmt2 = $conn->prepare("SELECT `id` from `slider-images` where id = ?");
        $stmt2->bind_param("s", $unique_filename);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $stmt2->close();

        if (mysqli_num_rows($result)) {
            header('Location: /index.php?content=content/add&T=' . $title . '&D=' . $description);
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

    $stmt = $conn->prepare("INSERT INTO `slider-images` (`id`, `image_src`, `title`, `description`, `visibility`) VALUES (NULL, ?, ?, ?, ?);");
    $stmt->bind_param("sssi", $target, $title, $description, $visibility);
    $stmt->execute();

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Slider successfully added.';
    header("Location: /dashboard.php");
}