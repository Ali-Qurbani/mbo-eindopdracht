<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';

if (empty($_GET['id'])) {
    header("Location: /");
    return false;
} else {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT `title`, `description`, `visibility` FROM `slider-images` WHERE `id` = '$id'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($title, $description, $visibility);
    $stmt->fetch();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit slider</title>
    <meta name="title" content="Edit slider">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>


<div class="row w-100">
    <div class="col-2">
        <?php include_once '_partials/_sidebar.php' ?>
    </div>
    <div class="col">
        <div class="container p-5">
            <form action="/resources/php/_edit_slider.php" method="post" enctype="multipart/form-data">
                <div class="my-3">
                    <label for="image" class="form-label">ID</label>
                    <input class="form-control" type="text" value="<?php echo $id ?>" aria-label="readonly input example" name="id" readonly>
                </div>
                <div class="my-3">
                    <label for="picture" class="form-label">Icon</label>
                    <input class="form-control" type="file" id="picture" name="picture" accept="image/svg+xml, image/png, image/jpg, image/jpeg, image/gif" aria-describedby="pictureHelp">
                    <small id="pictureHelp" class="form-text text-muted">Supported file types (SVG, PNG, JPEG, GIF)</small>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $title ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?php echo $description ?>">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="visibility" name="visibility" value="1" <?php if ($visibility === 1) echo 'checked' ?>>
                    <label class="form-check-label" for="visibility">Visible</label>
                </div>
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </form>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>