<?php
$statement = $db->query("SELECT `img_src`, `username` FROM `users` WHERE `id` = '$_SESSION[id]'");

$user = $statement->fetch(PDO::FETCH_ASSOC);

if(isset($_SESSION['dashboard-alert-type']) && isset($_SESSION['dashboard-message'])){
    if ($_SESSION['dashboard-alert-type'] === 'success') {
        ?>
        <div class="alert alert-success mt-3 text-center alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['dashboard-message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    } elseif ($_SESSION['dashboard-alert-type'] === 'error') {
        ?>
        <div class="alert alert-danger mt-3 text-center alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['dashboard-message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }
    unset($_SESSION["dashboard-alert-type"]);
    unset($_SESSION["dashboard-message"]);
}
?>

<div id="sidebar" class="sidebar bg-white">
    <a href="../edit_account.php" class="text-center text-decoration-none">
        <img src="<?php echo $user['img_src'] ?>" class="avatar" alt="profile-image">
    </a>
    <h5 class="text-secondary text-center pt-2"><?php echo $user['username'] ?></h5>
    <a href="admin_account.php">
        <button type="button" class="btn btn-outline-primary mt-3 w-100">
            Account
        </button>
    </a>
    <a href="dashboard.php">
        <button type="button" class="btn btn-outline-primary mt-3 w-100">
            Dashboard
        </button>
    </a>
    <a href="admin_coins.php">
        <button type="button" class="btn btn-outline-primary mt-3 w-100">
            Coins
        </button>
    </a>
    <a href="admin_sliders.php">
        <button type="button" class="btn btn-outline-primary mt-3 w-100">
            Sliders
        </button>
    </a>
    <div class="sidebar-bottom">
        <hr>
        <a href="resources/php/_logout.php">
            <button type="button" class="btn btn-outline-secondary mt-3 w-100">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </a>
    </div>
</div>