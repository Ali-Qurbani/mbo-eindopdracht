<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';

$statement = $db->query("SELECT `img_src`, `username`, `email` FROM `users` WHERE `id` = '$_SESSION[id]'");

$account = $statement->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account</title>
    <meta name="title" content="Account">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>


<div class="row w-100">
    <div class="col col-sm-5 col-md-4 col-xl-2">
        <?php include_once '_partials/_sidebar.php' ?>
    </div>
    <div class="col-sm-6 col-xl">
        <div class="container p-5">
            <img width="200" src="<?php echo $account->img_src; ?>" alt="Profile picture">

            <h3>
                <?php echo $account->username; ?>
            </h3>
            <p>
                <?php echo $account->email; ?>
            </p>
            <a href="edit_account.php">
                <button type="button" class="btn btn-outline-primary mt-3 w-100">
                    Edit account
                </button>
            </a>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>