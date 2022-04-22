<?php
session_start();
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';
//
//$stmt = $conn->prepare("SELECT `image_src`, `title`, `description` FROM `slider-images` WHERE `visibility` = '1'");
//$stmt->execute();
//$stmt->store_result();
//$stmt->bind_result($img_src, $title, $description);
//$stmt->fetch();
//$stmt->close();
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

<div class="container">
    <div class="row">
        <div class="col">
            Lorem ipsum
        </div>
        <div class="col">
            Lorem ipsum
        </div>
        <div class="col">
            Lorem ipsum
        </div>
        <div class="col">
            Lorem ipsum
        </div>
    </div>
</div>