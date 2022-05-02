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
                    if ($coin->visibility === '1') {
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
                                <a href="resources/php/_toggle_vis.php?type=coin&id=<?php echo $coin->id ?>">
                                    <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-<?php echo $bg_col_vis ?>"><?php echo $vis ?></span>
                                </a>
                                <img src="<?php echo $coin->icon_src ?>" class="img-thumbnail" width="100" alt="<?php echo $coin->name ?> icon">
                            </div>
                            <div class="col-xl text-light">
                                <span class="fw-bold"><?php echo $coin->id ?></span><hr>
                                <span class="fw-bold"><?php echo $coin->name ?></span><br>
                                <span class="fw-bold">Rounded: </span><span class="text-secondary fw-bold">$ <?php echo number_format($coin->price, 2) ?></span>
                                <span class="fw-bold">Full price: </span><span class="text-secondary fw-bold">$ <?php echo $coin->price ?></span>
                            </div>
                            <div class="col-xl-2">
                                <a href="edit_coin.php?id=<?php echo $coin->id ?>"><i class="far fa-edit"></i> Edit</a><br>
                                <a href="resources/php/_delete_coin.php?id=<?php echo $coin->id ?>"><i class="far fa-trash-alt"></i> Delete</a><br>
                                <span class="text-light">Last price update:<br></span>
                                <span class="text-secondary fw-bold">
                                    <?php
                                    $last_update = date_create($coin->last_updated);
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
            <div class="my-4">
                <h2>Category's</h2>
                <form action="/resources/php/_add_category.php" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input id="AddCategory" name="name" type="text" class="form-control border-primary" aria-label="Add category" placeholder="Category name" aria-describedby="AddCategoryAddon">
                        <button class="btn btn-outline-primary" type="submit" id="AddCategoryAddon"><i class="fas fa-plus"></i></button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $statement = $db->query("SELECT `id`, `name` FROM `category` ORDER BY `id`;");

                        $categories = $statement->fetchAll(PDO::FETCH_OBJ);

                        foreach ($categories as $category) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $category->id; ?></th>
                        <td>
                            <input type="text" class="border-0" placeholder="Category name" aria-label="Category name" value="<?php echo $category->name; ?>">
                        </td>
                        <td>
                            <a href="/resources/php/_show_vis_coin_category.php?id=<?php echo $category->id; ?>"><i class="fas fa-eye"></i></a>
                            <a href="/resources/php/_hide_vis_coin_category.php?id=<?php echo $category->id; ?>"><i class="fas fa-eye-slash"></i></a>
                            <a href="/resources/php/_update_category.php?id=<?php echo $category->id; ?>"><i class="fas fa-save"></i></a>
                            <a href="/resources/php/_delete_category.php?id=<?php echo $category->id; ?>"><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Category ID</th>
                        <th scope="col">Coins</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>
                            <form action="/resources/php/_add_coin_category.php" method="post" id="CoinCategory"></form>
                            <select class="form-select" aria-label="Pick a category." form="CoinCategory" name="category_id">
                                <option value="" selected>Select category ID</option>
                                <?php
                                foreach ($categories as $category) {
                                    ?>
                                    <option value="<?php echo $category->id ?>"><?php echo $category->id.' - '.$category->name ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </th>
                        <td>
                            <select class="form-select" aria-label="Pick the coin to add to said category." form="CoinCategory" name="coin_id">
                                <option value="" selected>Select coin ID</option>
                                <?php
                                foreach ($coins as $coin) {
                                    ?>
                                    <option value="<?php echo $coin->id ?>"><?php echo $coin->id ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td><button type="submit" class="btn btn-outline-primary w-100" form="CoinCategory"><i class="fas fa-plus"></i></button></td>
                    </tr>
                    <?php
                    $statement = $db->query("SELECT ca.category_id, c.name, ca.coin_id FROM `coin_categories` as `ca` JOIN `category` as `c` ON c.id = ca.category_id ORDER BY `category_id`");

                    $coin_categories = $statement->fetchAll(PDO::FETCH_OBJ);

                    foreach ($coin_categories as $coin_category) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $coin_category->category_id.' | '.$coin_category->name ?></th>
                            <td>
                                <?php echo $coin_category->coin_id; ?>
                            </td>
                            <td><a href="/resources/php/_delete_coin_category.php?cat_id=<?php echo $coin_category->category_id; ?>&coin_id=<?php echo $coin_category->coin_id; ?>"><i class="fas fa-trash-alt"></i></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>