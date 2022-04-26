<?php
session_start();
include_once 'resources/php/_connect_db.php';
include_once 'resources/php/_functions.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact</title>
    <meta name="title" content="Contact">
    <?php include_once '_partials/_head.php' ?>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>

<div class="container p-5">
    <?php
    if(isset($_SESSION['contact_status_type']) && isset($_SESSION['contact_status'])){
        if ($_SESSION['contact_status_type'] === 'success') {
            ?>
                <div class="alert alert-success mt-3 text-center alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['contact_status'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
        } elseif ($_SESSION['contact_status_type'] === 'error') {
            ?>
                <div class="alert alert-danger mt-3 text-center alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['contact_status'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
        }
        unset($_SESSION["contact_status"]);
        unset($_SESSION["contact_status_type"]);
    }
    ?>
    <form id="contact_form" action="resources/php/_form_script.php" method="post">
        <div class="row">
            <div class="col">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <div id="nameErr" class="text-danger"></div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <div id="emailErr" class="text-danger"></div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone number</label>
            <input type="tel" class="form-control" id="phone" name="tel">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message"></textarea>
            <div id="commentErr" class="text-danger"></div>
        </div>
    </form>
    <button id="form-button" type="submit" class="btn btn-primary">Submit</button>
</div>

<?php include_once '_partials/_footer.php' ?>
</body>
</html>