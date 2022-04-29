<?php
$statement = $db->query("SELECT `img_src`, `username` FROM `users` WHERE `id` = '$_SESSION[id]'");

$user = $statement->fetch(PDO::FETCH_ASSOC);

?>

<div class="sidebar">
    <a href="account.php" class="text-center text-decoration-none">
        <img src="<?php echo $user['img_src'] ?>" class="avatar" alt="profile-image">
    </a>
    <h5 class="text-secondary text-center pt-2"><?php echo $user['username'] ?></h5>
    <a href="account.php">
        <button type="button" class="btn btn-primary mt-3 w-100">
            Account
        </button>
    </a>
    <a href="dashboard.php">
        <button type="button" class="btn btn-outline-primary mt-3 w-100">
            Overview
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