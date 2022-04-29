<?php
session_start();
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta name="title" content="Home">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>

<div class="home-owl-carousel owl-carousel">
    <?php
    $statement = $db->query("SELECT * FROM `slider-images` WHERE `visibility` = '1'");

    $slider_images = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($slider_images as $slide) {
        ?>
            <div class="position-relative">
                <div class="slider-text">
                    <h1 class="text-secondary"><?php echo $slide['title'] ?></h1>
                    <p><?php echo $slide['description'] ?></p>
                </div>
                <img src="<?php echo $slide['image_src'] ?>" class="img-fluid" alt="Slider image">
            </div>
        <?php
    }
    ?>
</div>
<div class="container my-5">
    <div class="bg-primary text-light p-5">
        <div class="row">
            <div class="col">
                <img src="https://via.placeholder.com/400x200" alt="Placeholder, please replace!">
            </div>
            <div class="col">
                <h2>Lorem ipsum</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo interdum massa et finibus. Vivamus eget pretium nulla, eget aliquet libero. Nulla id iaculis felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam gravida dolor dui. Fusce dignissim pretium lorem vitae euismod.
                </p>
            </div>
        </div>
    </div>
    <div class="my-5 p-5">
        <h2>Lorem ipsum</h2>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed commodo interdum massa et finibus. Vivamus eget pretium nulla, eget aliquet libero. Nulla id iaculis felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam gravida dolor dui. Fusce dignissim pretium lorem vitae euismod.
        </p>
    </div>
    <div class="text-center bg-light p-4 mx-5">
        <h2 class="text-primary fw-bold">Frequently Asked Questions</h2>
        <div class="mt-5">
            <button type="button" class="collapsible">
                How accurate are the prices on the website?
            </button>
            <div class="collapsible-content">
                <div class="pt-3">
                    <p>
                        This website sends a request every 5 minutes to the Binance api to update the prices
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <button type="button" class="collapsible">
                Lorem ipsum?
            </button>
            <div class="collapsible-content">
                <div class="pt-3">
                    <p>
                        Lorem ipsum!
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <button type="button" class="collapsible">
                Lorem ipsum?
            </button>
            <div class="collapsible-content">
                <div class="pt-3">
                    <p>
                        Lorem ipsum!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="home-2">
    <div class="container">
        <div class="p-5">

        </div>
    </div>
</div>
<div class="bg-secondary">
    <div class="container">
        <div id="crypto-calculator" class="text-center p-4 bg-light mb-5 border-top border-primary border-3">
            <h2 class="text-primary">Crypto Calculator</h2>
            <div class="row">
                <div class="col-md my-3">
                    <div class="input-group mb-3">
                    <span class="input-group-text border-secondary border-2">
                        <img id="calc-1-icon" width="25" height="25" src="" alt="Crypto icon">
                    </span>
                        <input id="calc-inp-1" type="text" class="form-control bg-white border-top border-secondary border-2" aria-label="Amount (to the nearest dollar)">
                        <select id="calc-left-select" class="form-select border-secondary border-2" aria-label="Crypto select">
                            <?php
                            $coin_options = crypto_calculator_prices($db);

                            foreach ($coin_options as $option) {
                                ?>
                                <option id="<?php echo $option['icon_src'] ?>" value="<?php echo $option['price'] ?>"><?php echo $option['name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <span id="left-help" class="text-muted"></span>
                </div>
                <div class="col-md my-3">
                    <div class="input-group mb-3">
                    <span class="input-group-text border-secondary border-2">
                        <img width="25" height="25" src="public/images/tether-usdt-logo.svg" alt="Tether icon">
                    </span>
                        <input id="calc-inp-2" type="text" class="form-control bg-white border-top border-secondary border-2" aria-label="Amount (to the nearest dollar)">
                        <select class="form-select border-secondary border-2" aria-label="USDT" disabled>
                            <option selected>Tether</option>
                        </select>
                    </div>
                    <span id="right-help" class="text-muted"></span>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div class="row">
                <div class="col text-center p-5">
                    <i class="far big-icon text-primary fa-question-circle"></i>
                </div>
                <div class="col">
                    <h2 class="text-primary">Any questions?</h2>
                    <p>Feel free to contact us</p>
                    <div class="row">
                        <div class="col-5">
                            <a href="contact.php"><button class="btn btn-outline-light py-4"><i class="fas fa-file-alt"></i> Use the contact form</button></a>
                        </div>
                        <div class="col">
                            <a href="mailto:info@website.com"><button class="btn btn-outline-light py-4"><i class="fas fa-paper-plane"></i> Send us an email</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once '_partials/_footer.php' ?>
</body>
</html>