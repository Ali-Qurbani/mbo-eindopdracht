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
    <title>Add coin</title>
    <meta name="title" content="Add coin">
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
            <form action="/resources/php/_add_coin.php" method="post" enctype="multipart/form-data">
                <div class="my-3">
                    <label for="picture" class="form-label">Icon</label>
                    <input class="form-control" type="file" id="picture" name="picture" accept="image/svg+xml, image/png, image/jpg, image/jpeg, image/gif" aria-describedby="pictureHelp">
                    <small id="pictureHelp" class="form-text text-muted">Supported file types (SVG, PNG, JPEG, GIF)</small>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                    <div id="nameHelp" class="form-text">Name of the coin.</div>
                </div>
                <div class="mb-3">
                    <label for="symbol" class="form-label">Exchange symbol</label>
                    <input type="text" class="form-control" id="symbol" name="symbol">
                    <div id="symbolHelp" class="form-text">Example: "XXXUSDT"</div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="visibility" name="visibility" value="1" checked>
                    <label class="form-check-label" for="visibility">Visible</label>
                </div>
                <button type="submit" class="btn btn-outline-primary">Add</button>
            </form>
        </div>
    </div>
</div>



<?php include_once '_partials/_footer.php' ?>
</body>
</html>