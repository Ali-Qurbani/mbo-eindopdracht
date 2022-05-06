<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    return false;
}
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';

if (empty($_GET['id'])) {
    header("Location: /");
    return false;
} else {
    $id = $_GET['id'];

    $sql = 'SELECT `id`, `icon_src`, `name`, `price`, `visibility` FROM `coins` WHERE `id` = :id';
    $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array('id' => $id));
    $current_coin = $sth->fetch(PDO::FETCH_OBJ);

    if (empty($current_coin->id)) {
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = 'Coin doesnt exist.';
        header("Location: /admin_coins.php");
        return false;
    }
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit coin</li>
                </ol>
            </nav>
            <form action="/resources/php/_edit_coin.php" method="post" enctype="multipart/form-data">
                <div class="d-none">
                    <input class="form-control" type="text" value="<?php echo $current_coin->id; ?>" aria-label="old_id" name="old_id" readonly>
                </div>
                <div class="my-3">
                    <label for="picture" class="form-label">Icon</label>
                    <input class="form-control" type="file" id="picture" name="picture" accept="image/svg+xml, image/png, image/jpg, image/jpeg, image/gif" aria-describedby="pictureHelp">
                    <small id="pictureHelp" class="form-text text-muted">Supported file types (SVG, PNG, JPEG, GIF)</small>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $current_coin->name; ?>">
                </div>
                <div class="mb-3">
                    <label for="symbol" class="form-label">Symbol</label>
                    <input type="text" class="form-control" id="symbol" name="symbol" value="<?php echo $current_coin->id; ?>">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="visibility" name="visibility" value="1" <?php if ($current_coin->visibility === '1') echo 'checked' ?>>
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