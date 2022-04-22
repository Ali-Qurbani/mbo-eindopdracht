<?php
$stmt = $conn->prepare("SELECT `img_src`, `username` FROM `users` WHERE `id` = '$_SESSION[id]'");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($img_src, $username);
$stmt->fetch();
$stmt->close();
?>

<div class="sidebar">
    <a href="account.php" class="text-center text-decoration-none">
        <img src="<?php echo $img_src ?>" class="img-fluid px-4" alt="profile-image">
    </a>
    <h5 class="text-secondary text-center pt-2"><?php echo $username ?></h5>
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
                Logout
            </button>
        </a>
    </div>
</div>