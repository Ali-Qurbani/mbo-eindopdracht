<?php
$page = $_SERVER['REQUEST_URI'];
?>
<div class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="text-center w-100">
            <a class="text-dark" href="/">
                <img src="/public/images/logo.png" width="60" class="img-fluid mb-2" alt="Placeholder, please replace!">
            </a>
        </div>
        <div class="container-fluid">
            <div class="position-absolute end-0 top-0 m-2">
                <?php
                if (isset($_SESSION["id"])) {?>
                    <div class="dropdown">
                        <button class="btn text-primary dropdown-toggle" type="button" id="navbar_account_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Session
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbar_account_dropdown">
                            <li><a class="dropdown-item text-secondary" href="/dashboard.php">Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-secondary" href="/resources/php/_logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                    <?php
                } else {
                    echo '<a class="text-decoration-none" href="login.php"><button class="btn text-primary">Login</button></a>';
                }
                ?>
            </div>
            <ul class="navbar-nav m-auto flex-row">
                <li class="nav-item mx-1">
                    <a class="nav-link <?php if ($page === '/') echo 'active' ?>" href="/"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link <?php if ($page === '/coins.php') echo 'active' ?>" href="coins.php"><i class="fab fa-bitcoin"></i> Coins</a>
                </li>
                <li class="nav-item mx-1">
                    <a class="nav-link <?php if ($page === '/contact.php') echo 'active' ?>" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="crypto-price-line">
        <div class="owl-carousel">
            <?php
                $nav_db_query = $db->query("SELECT * FROM `coins` WHERE `visibility` = '1'");

                $coins = $nav_db_query->fetchAll(PDO::FETCH_ASSOC);

                foreach ($coins as $coin) {
                    $last_updated = date_create($coin['last_updated']);
                    $now = date_create(date('Y-m-d h:i:sa'));
                    $interval = date_diff($last_updated, $now);
                    $min = $interval->days * 24 * 60;
                    $min += $interval->h * 60;
                    $min += $interval->i;
                    if ($min >= 5) {
                        update_prices($db);
                    }
                    ?>
                    <a class="text-decoration-none text-black" href="coins.php#<?php echo $coin['name'] ?>">
                        <div class="row slider_div">
                            <div class="col-3">
                                <img src="<?php echo $coin['icon_src'] ?>" width="25" height="25" alt="<?php echo $coin['name'] ?>">
                            </div>
                            <div class="col-4">
                                <span class="fw-bold">$<?php echo number_format($coin['price'], 2) ?></span>
                            </div>
                        </div>
                    </a>
                <?php
                    }
                unset($nav_db_query, $coins, $coin)
                ?>
        </div>
    </div>
</div>
<div class="nav-catcher"></div>