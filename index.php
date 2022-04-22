<?php
session_start();
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';

$stmt = $conn->prepare("SELECT `image_src`, `title`, `description` FROM `slider-images` WHERE `visibility` = '1'");
$stmt->execute();
$result = $stmt->get_result();

$records[] = '';
while ($record = mysqli_fetch_assoc($result)) {
    $records[] .= $record['image_src'];
}
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

<div class="home-owl-carousel owl-carousel">
    <?php
    unset($records[0]);
    foreach ($records as $slider) {
        ?>
        <img src="<?php echo $slider ?>" class="img-fluid" alt="...">
        <?php
    }
    ?>
</div>
<div class="container">

</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>