<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta name="title" content="Dashboard">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>

<div class="wrapper">
    <?php include_once '_partials/_sidebar.php' ?>
    <!-- Page Content  -->
    <div id="content">
        <div class="container my-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
            <p>Welcome <?php echo $user->username ?></p>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>