<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
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

<div class="wrapper">
    <?php include_once '_partials/_sidebar.php' ?>
    <!-- Page Content  -->
    <div id="content">
        <div class="container my-5">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Account</li>
                </ol>
            </nav>
            <img width="200" class="mb-3" src="<?php echo $account->img_src; ?>" alt="Profile picture">

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