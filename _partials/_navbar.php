<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand bg-primary" href="#">Navbar</a>
        <button class="navbar-toggler w-100" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="position-absolute end-0 top-0 m-3">
                <?php
                if (isset($_SESSION["id"])) {?>
                    <div class="dropdown">
                        <button class="btn text-secondary dropdown-toggle" type="button" id="navbar_account_dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Session
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbar_account_dropdown">
                            <li><a class="dropdown-item text-secondary" href="/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item text-secondary" href="/resources/php/_logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <?php
                } else {
                    echo '<a class="text-decoration-none" href="/resources/php/_login.php">Login</a>';
                }
                ?>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="crypto-price-line" class="p-2">
    <div class="owl-carousel">
    <!--        --><?php //get_prices() ?>
    </div>
</div>