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
    <title>Sliders</title>
    <meta name="title" content="Sliders">
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
                <h2>Home slider</h2>
                <a href="add_slider_image.php">
                    <button type="button" class="btn btn-outline-secondary">
                        Add slider image
                    </button>
                </a>
                <?php
                $slider_images = get_db_slide_info($db);

                foreach ($slider_images as $slide) {
                    if ($slide['visibility'] === '1') {
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
                                <a href="resources/php/_toggle_vis.php?type=slider&id=<?php echo $slide['id'] ?>">
                                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-<?php echo $bg_col_vis ?>"><?php echo $vis ?></span>
                                </a>
                                <img src="<?php echo $slide['image_src'] ?>" class="img-thumbnail" width="100" alt="<?php echo $slide['title'] ?> icon">
                            </div>
                            <div class="col-xl text-light">
                                <span class="fw-bold"><?php echo $slide['title'] ?></span><hr>
                                <span class="fw-bold"><?php echo $slide['description'] ?></span>
                            </div>
                            <div class="col-xl-2">
                                <a href="edit_slider.php?id=<?php echo $slide['id'] ?>"><i class="far fa-edit"></i> Edit</a><br>
                                <a href="resources/php/_delete_slider.php?id=<?php echo $slide['id'] ?>"><i class="far fa-trash-alt"></i> Delete</a>
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