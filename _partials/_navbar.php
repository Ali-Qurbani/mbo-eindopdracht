<div class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="text-center w-100">
            <a class="bg-primary text-dark" href="/">
                <img src="https://via.placeholder.com/100x100" class="img-fluid" alt="Placeholder, please replace!">
            </a>
        </div>
        <div class="container-fluid">
            <button class="navbar-toggler w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="coins.php"><i class="fab fa-bitcoin"></i> Coins</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php"><i class="fas fa-envelope"></i> Contact</a>
                    </li>
                </ul>
            </div>
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