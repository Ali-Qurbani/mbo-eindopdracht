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
    <title>Dashboard</title>
    <meta name="title" content="Dashboard">
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
            <div class="my-4">
                <?php
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
                <h2>Home slider</h2>
                <?php
                    $stmt = $conn->prepare("SELECT `id`, `image_src`, `visibility`, `title`, `description` FROM `slider-images`");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $records[] = '';
                    while ($record = mysqli_fetch_assoc($result)) {
                        if ($record['visibility'] === 1) {
                            $vis = 'Visible';
                            $bg_col_vis = 'success';
                        } else {
                            $vis        = 'Hidden';
                            $bg_col_vis = 'danger';
                        }
                        $records[] .= '<div class="dashboard-item">
                            <img src="'.$record['image_src'].'" width="100" alt="...">
                            <a href="edit_slider.php?id='.$record['id'].'">Edit</a>
                            <a href="resources/php/_delete_slider.php?id='.$record['id'].'">Delete</a>
                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-'.$bg_col_vis.'">'.$vis.'</span>
                        </div>';
                    }

                    $stmt->close();

                    unset($records[0]);
                    foreach ($records as $slider) {
                        echo $slider;
                    }
                ?>
                <a href="add_slider_image.php">
                    <button type="button" class="btn btn-outline-secondary">
                        Add slider image
                    </button>
                </a>
            </div>
            <div class="my-4">
                <h2>Coins</h2>
                <?php
                $stmt = $conn->prepare("SELECT `id`, `icon_src`, `naam`, `prijs`, `zichtbaar` FROM `coins`");
                $stmt->execute();
                $result = $stmt->get_result();

                $coins[] = '';
                while ($record = mysqli_fetch_assoc($result)) {
                    if ($record['zichtbaar'] === 1) {
                        $vis = 'Visible';
                        $bg_col_vis = 'success';
                    } else {
                        $vis        = 'Hidden';
                        $bg_col_vis = 'danger';
                    }
                    $coins[] .= '<div class="dashboard-item">
                            <img src="'.$record['icon_src'].'" width="100" alt="...">
                            <span class="text-light fw-bold">'.$record['id'].'</span> |
                            <span class="text-light fw-bold">'.$record['naam'].'</span>
                            <a href="edit_coin.php?id='.$record['id'].'"><i class="far fa-edit"></i> Edit</a>
                            <a href="resources/php/_delete_coin.php?id='.$record['id'].'"><i class="far fa-trash-alt"></i> Delete</a>
                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-'.$bg_col_vis.'">'.$vis.'</span>
                        </div>';
                }

                $stmt->close();

                unset($coins[0]);
                foreach ($coins as $coin) {
                    echo $coin;
                }
                ?>
                <a href="add_coin.php">
                    <button type="button" class="btn btn-outline-secondary">
                        Add coin
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>