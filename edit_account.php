<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';
    $id = $_SESSION['id'];

    $sql = 'SELECT `id`, `img_src`, `username`, `email` FROM `users` WHERE `id` = :id';
    $sth = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array('id' => $id));
    $userinfo = $sth->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $userinfo['username']; ?></title>
    <meta name="title" content="<?php echo $userinfo['username']; ?>">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>

<div class="row w-100">
    <div class="col-2">
        <?php include_once '_partials/_sidebar.php' ?>
    </div>
    <div class="col">
        <div class="container my-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Account</li>
                </ol>
            </nav>
            <form action="/resources/php/_edit_account.php" method="post" enctype="multipart/form-data">
                <div class="d-none">
                    <input class="form-control" type="text" value="<?php echo $userinfo['id']; ?>" aria-label="old_id" name="old_id" readonly>
                </div>
                <div class="my-3">
                    <img id="form_profile_picture" src="<?php echo $userinfo['img_src']; ?>" class="img-thumbnail mb-2" width="200" alt="<?php echo $userinfo['username']; ?> profile picture"><br>
                    <label for="picture" class="form-label">Icon</label>
                    <input class="form-control" type="file" id="admin_page_img_input" name="picture" accept="image/svg+xml, image/png, image/jpg, image/jpeg, image/gif" aria-describedby="pictureHelp">
                    <small id="pictureHelp" class="form-text text-muted">Supported file types (SVG, PNG, JPEG, GIF)</small>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $userinfo['username']; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $userinfo['email']; ?>">
                </div>
                <hr>
                <span class="text-muted">If you want a new password fill the fields down bellow.</span>
                <div class="mb-3">
                    <label for="password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="new_password_1" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new_password_1" name="new_password_1" autocomplete="new-password"/>
                </div>
                <div class="mb-3">
                    <label for="new_password_2" class="form-label">Repeat new Password</label>
                    <input type="password" class="form-control" id="new_password_2" name="new_password_2" autocomplete="new-password"/>
                </div>
                <button type="submit" class="btn btn-outline-primary">Save</button>
            </form>
        </div>
    </div>
</div>



<?php include_once '_partials/_footer.php' ?>
</body>
</html>
