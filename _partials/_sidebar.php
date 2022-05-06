<?php
$statement = $db->query("SELECT `img_src`, `username` FROM `users` WHERE `id` = '$_SESSION[id]'");

$user = $statement->fetch(PDO::FETCH_OBJ);

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

<!-- Sidebar  -->
<?php
if (isset($_SESSION['id'])) {
    ?>
    <button type="button" id="sidebarCollapse" class="btn btn-outline-info">
        <i class="fas fa-bars"></i>
    </button>
    <?php
}
?>
<nav id="sidebar">
    <div class="sidebar-header">
        <h3><?php echo $user->username ?></h3>
        <strong class="fs-6"><?php echo $user->username ?></strong>
    </div>

    <ul class="list-unstyled components">
        <li>
            <a href="admin_account.php" class="text-center">
                <img class="img-thumbnail" width="150" src="<?php echo $user->img_src ?>" alt="Your profile picture">
            </a>
            <a href="admin_account.php">
                <i class="fas fa-user"></i>
                Account
            </a>
            <a href="dashboard.php">
                <i class="fas fa-columns"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#Coins" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                <i class="fab fa-bitcoin"></i>
                Coins
            </a>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="Coins">
                        <div class="sidebar-expanded">
                            <a href="admin_coins.php" class="dropdown-item text-white">Coins</a>
                            <a href="add_coin.php" class="dropdown-item text-white">Add Coin</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <a class="dropdown-toggle" data-bs-toggle="collapse" href="#Sliders" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                <i class="fas fa-images"></i>
                Sliders
            </a>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="Sliders">
                        <div class="sidebar-expanded">
                            <a href="admin_sliders.php" class="dropdown-item text-white">Sliders</a>
                            <a href="add_slider_image.php" class="dropdown-item text-white">Add Slider</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <a href="resources/php/_logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </li>
    </ul>
</nav>