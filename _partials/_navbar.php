<nav class="navbar navbar-expand-lg navbar-light bg-light">
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
                            <li><a class="dropdown-item text-secondary" href="/resources/php/_logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <?php
                } else {
                    echo '<a class="text-decoration-none" href="login.php"><button class="btn text-primary">Login</button></a>';
                }
                ?>
            </div>
<!--            <a class="bg-primary" href="#">Navbar</a>-->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="coins.php">Coins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
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
                            <img src="<?php echo $coin['icon_src'] ?>" width="20" height="20" alt="<?php echo $coin['name'] ?>">
                        </div>
                        <div class="col-4">
                            <span class="fw-bold">$<?php echo $coin['price'] ?></span>
                        </div>
                    </div>
                </a>
            <?php
                }
            unset($nav_db_query, $coins, $coin)
            ?>
    </div>
</div>