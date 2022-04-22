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
<div id="crypto-price-line" class="pt-2 pb-2 bg-light">
    <div class="owl-carousel">
        <?php
            $stmt = $conn->prepare("SELECT `icon_src`, `naam`, `prijs` FROM `coins` WHERE `zichtbaar` = 1");
            $stmt->execute();
            $result = $stmt->get_result();

            $coins[] = '';
            while ($record = mysqli_fetch_assoc($result)) {
                $coins[] .= '<div class="row slider_div">
                                <div class="col-2">
                                    <img src="'.$record['icon_src'].'" height="20" alt="'.$record['naam'].'">
                                </div>
                                <div class="col">
                                    <span class="fw-bold">$'.$record['prijs'].'</span>
                                </div>
                            </div>';
                        }
            $stmt->close();

            unset($coins[0]);
            foreach ($coins as $coin) {
                echo $coin;
            }
            unset($coins);
        ?>
    </div>
</div>