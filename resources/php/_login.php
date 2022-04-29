<?php
session_start();
if (isset($_SESSION["id"]) || empty($_POST)) {
    header("Location: /login.php");
    return false;
} else {
    require_once '_connect_db.php';
    require_once '_functions.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    // set login attempt if not set
    if (!isset($_SESSION['attempt'])) {
        $_SESSION['attempt'] = 0;
    }

    // check if there are 5 attempts already
    if ($_SESSION['attempt'] > 5) {
        $_SESSION['login-error'] = 'Attempt limit reached';
        header("Location: ../../login.php");
        return false;
    }

    if (empty($username) || empty($password)) {
        $_SESSION['login-error'] = 'One or more of the required fields are empty';
        header("Location: ../../login.php");
        return false;
    } else {
        $statement = $db->query("SELECT `id`, `password` FROM `users` WHERE `username` = '$username'");

        $id_und_pw = $statement->fetch(PDO::FETCH_ASSOC);
        $userid = $id_und_pw['id'];
        $db_pw = $id_und_pw['password'];

        if (password_verify($password, $db_pw) & isset($userid)) {
            // password matched
            unset($_SESSION['attempt']);
            $_SESSION["id"] = $userid;
            $_SESSION['dashboard-alert-type'] = 'success';
            $_SESSION['dashboard-message'] = 'Successfully logged in.';
            header("Location: ../../dashboard.php");
        } else {
            // password didn't match or db failed
            $_SESSION['login-error'] = 'The Username or Password you entered is incorrect.';
            $_SESSION['attempt'] += 1;
            // set the time to allow login if third attempt is reached
            if ($_SESSION['attempt'] === 3) {
                $_SESSION['attempt_again'] = time() + (5 * 60);
                // note 5*60 = 5mins, 60*60 = 1hr, to set to 2hrs change it to 2*60*60
            }
            header("Location: ../../login.php");
        }
    }
}