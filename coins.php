<?php
session_start();
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

<div class="container p-5">
    <div class="row coin-row">
        <?php

        $statement = $db->query("SELECT * FROM `coins` WHERE `visibility` = '1'");

        $coins = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($coins as $coin) {
            ?>
            <a class="col-md-6 mt-2 text-decoration-none" href="https://www.binance.com/en/trade/<?php echo $coin['id'] ?>" target="_blank">
                <div class="row border m-0 p-2 coin-card" id="<?php echo $coin['name'] ?>">
                    <div class="col-3">
                        <img src="<?php echo $coin['icon_src'] ?>" class="img-thumbnail" width="40" alt="<?php echo $coin['name'] ?> icon">
                    </div>
                    <div class="col">
                        <span class="text-secondary fw-bolder"><?php echo $coin['name'] . '<br>'; ?></span>
                        <span>$<?php echo $coin['price'] ?></span><br>
                    </div>
                </div>
            </a>
            <?php
        }
        ?>
    </div>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>