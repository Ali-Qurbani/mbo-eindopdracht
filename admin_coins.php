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
    <title>Coins</title>
    <meta name="title" content="Coins">
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
            <div class="my-4">
                <h2>Coins</h2>
                <a href="add_coin.php">
                    <button type="button" class="btn btn-outline-secondary">
                        Add coin
                    </button>
                </a>
                <?php
                $coins = get_db_coin_info($db);

                foreach ($coins as $coin) {
                    if ($coin['visibility'] === '1') {
                        $vis = 'Visible';
                        $bg_col_vis = 'success';
                    } else {
                        $vis        = 'Hidden';
                        $bg_col_vis = 'danger';
                    }
                    ?>
                    <div class="dashboard-item border-<?php echo $bg_col_vis ?>">
                        <div class="row">
                            <div class="col-xl-2">
                                <a href="resources/php/_toggle_vis.php?type=coin&id=<?php echo $coin['id'] ?>">
                                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-<?php echo $bg_col_vis ?>"><?php echo $vis ?></span>
                                </a>
                                <img src="<?php echo $coin['icon_src'] ?>" class="img-thumbnail" width="100" alt="<?php echo $coin['name'] ?> icon">
                            </div>
                            <div class="col-xl text-light">
                                <span class="fw-bold"><?php echo $coin['id'] ?></span><hr>
                                <span class="fw-bold"><?php echo $coin['name'] ?></span><br>
                                <span class="fw-bold">Rounded: </span><span class="text-secondary fw-bold">$ <?php echo number_format($coin['price'], 2) ?></span>
                                <span class="fw-bold">Full price: </span><span class="text-secondary fw-bold">$ <?php echo $coin['price'] ?></span>
                            </div>
                            <div class="col-xl-2">
                                <a href="edit_coin.php?id=<?php echo $coin['id'] ?>"><i class="far fa-edit"></i> Edit</a><br>
                                <a href="resources/php/_delete_coin.php?id=<?php echo $coin['id'] ?>"><i class="far fa-trash-alt"></i> Delete</a><br>
                                <span class="text-light">Last price update:<br></span>
                                <span class="text-secondary fw-bold">
                                    <?php
                                    $last_update = date_create($coin['last_updated']);
                                    $now = date_create(date('Y-m-d h:i:sa'));
                                    $interval = date_diff($last_update, $now);
                                    $min = $interval->days * 24 * 60;
                                    $min += $interval->h * 60;
                                    $min += $interval->i;
                                    if ($min < 60) {
                                        echo $interval->format($min . ' minutes and %s seconds ago');
                                    } else {
                                        echo '>60 minutes ago';
                                    }
                                    ?>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>