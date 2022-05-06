<?php
session_start();
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';
if (isset($_SESSION["id"])) {
    header("Location: /dashboard.php");
    return false;
}
unset($_SESSION['attempt']);
unset($_SESSION['attempt_again']);
include_once 'resources/php/_functions.php';

// check if the login cooldown's over
if(isset($_SESSION['attempt_again'])){
    $now = time();
    if($now >= $_SESSION['attempt_again']){
        unset($_SESSION['attempt']);
        unset($_SESSION['attempt_again']);
    }
    $time_remaining = $_SESSION['attempt_again'] - $now;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta name="title" content="Login">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>

<div class="container w-25 my-5">
    <?php
    if(isset($_SESSION['login-error'])){
        ?>
        <div class="alert alert-danger mt-3" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?php echo $_SESSION['login-error']; ?>
        </div>
        <?php
        unset($_SESSION['login-error']);
    } elseif(isset($_SESSION['attempt_again'])) {
        ?>
        <div class="alert alert-danger mt-3" role="alert"><i class="fas fa-exclamation-triangle"></i> Login attempt limit reached, try again in <?php echo $time_remaining ?> seconds</div>
        <?php
    }
    ?>
    <form action="/resources/php/_login.php" method="post">
        <h2>Login</h2>
        <div class="my-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" aria-describedby="nameHelp">
            <div id="nameHelp" class="form-text">Case and space sensitive.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <div id="nameHelp" class="form-text">Case and space sensitive.</div>
        </div>
        <label class="mb-2">
            <input id="show_password_box" type="checkbox">
            Show Password
        </label><br>
        <button type="submit" class="btn btn-outline-primary">Login</button>
    </form>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>