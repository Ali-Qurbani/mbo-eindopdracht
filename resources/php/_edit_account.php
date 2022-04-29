<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST)) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'One or more required fields are empty.';
    header("Location: /admin_account.php");
    return false;
} else {
    include_once '_connect_db.php';
    include_once '_functions.php';

    $user_id = $_SESSION["id"];

    $username = $_POST['username'];
    $email = $_POST['email'];

    if (isset($_POST['password']) && isset($_POST['new_password_1']) && isset($_POST['new_password_2'])) {
        $password = $_POST['password'];
        $new_password_1 = $_POST['new_password_1'];
        $new_password_2 = $_POST['new_password_2'];
        if ($new_password_1 === $new_password_2) {
            $password = password_hash($new_password_1, PASSWORD_BCRYPT);
        } else {
            $_SESSION['dashboard-alert-type'] = 'error';
            $_SESSION['dashboard-message'] = 'New passwords did not match.';
            header("Location: /admin_account.php");
            return false;
        }
    }

    if (!is_uploaded_file($_FILES ['picture'] ['tmp_name'])) {
        $statement = 'UPDATE `users` SET 
                           `username` = :username, 
                           `email` = :email,    
                           `password` = :password
                            WHERE `users`.`id` = :id;';
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('username' => $username, 'email' => $email, 'password' => $password, 'id' => $user_id));

    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $stmt = $db->query("SELECT `img_src` FROM `users` WHERE id = '$user_id'");
        $old_img = $stmt->fetch(PDO::FETCH_ASSOC);

        $old_img_src = $old_img['img_src'];

        $info = pathinfo($_FILES['picture']['name']);
        $ext = $info['extension'];
        $id = $unique_filename . '.' . $ext;
        $target = '../../public/images/' . $unique_filename . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], $target);

        // Delete the previous coin image from the disk
        $file_pointer = $old_img['img_src'];
        if (!unlink($file_pointer)) {
            echo 'File deletion error';
            return false;
        }

        $statement = "UPDATE `users` SET `img_src` = :img_src, `username` = :username, `password` = :password, `email` = :email WHERE `users`.`id` = :id";
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('img_src' => $target, 'username' => $username, 'email' => $email, 'password' => $password, 'id' => $user_id));
    }

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Changes successfully saved.';
    header("Location: /admin_account.php");
}