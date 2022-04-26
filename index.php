<?php
session_start();
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

<div class="home-owl-carousel owl-carousel">
    <?php
    $statement = $db->query("SELECT * FROM `slider-images` WHERE `visibility` = '1'");

    $slider_images = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($slider_images as $slide) {
        ?>
        <img src="<?php echo $slide['image_src'] ?>" class="img-fluid" alt="Slider image">
        <?php
    }
    ?>
</div>
<div class="container">
    <div class="bg-dark text-light p-5">
        <h1>AE</h1>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>