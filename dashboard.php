<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta name="title" content="Home">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>


<div class="row w-100">
    <div class="col-2">
        <?php include_once '_partials/_sidebar.php' ?>
    </div>
    <div class="col">
        <div class="container">
            <div class="bg-dark">
                <?php
                    
                ?>
            </div>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>