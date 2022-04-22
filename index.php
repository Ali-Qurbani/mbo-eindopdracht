<?php
session_start();
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';

$stmt = $conn->prepare("SELECT `image_src`, `title`, `description` FROM `slider-images` WHERE `visibility` = '1'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($img_src, $title, $description);
$stmt->fetch();
$stmt->close();
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

<div id="home_carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#home_carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#home_carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#home_carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?php echo $img_src ?>" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#home_carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#home_carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>