<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}

if (empty($_POST)) {
    header("Location: /dashboard.php");
    return false;
} else {
    unset($_SESSION["dashboard-alert-type"]);
    unset($_SESSION["dashboard-message"]);

    include_once '_connect_db.php';
    include_once '_functions.php';

    $name = $_POST['name'];
    $symbol = $_POST['symbol'];

    if (isset($_POST['visibility'])) {
        $visibility = 1;
    } else {
        $visibility = 0;
    }

    // Check if the symbol can be found and get the current price
    $data = json_decode(file_get_contents("https://api.binance.com/api/v3/avgPrice?symbol=".$symbol), TRUE);
    $price = $data['price'];
    if (!isset($price)) {
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = 'Unable to find price with given symbol.';
        header("Location: /dashboard.php");
        return false;
    }

    if (!is_uploaded_file($_FILES ['picture'] ['tmp_name'])) {
        $_SESSION['dashboard-alert-type'] = 'error';
        $_SESSION['dashboard-message'] = 'No image found.';
        header("Location: /dashboard.php");
        return false;
    } else {
        $unique_filename = time() . uniqid(rand());

        $filename = $_FILES['picture']['name'];

        $info = pathinfo($_FILES['picture']['name']);
        $ext = $info['extension'];
        $id = $unique_filename . '.' . $ext;
        $target = '../../public/images/coins/' . $unique_filename . '.' . $ext;
        move_uploaded_file($_FILES['picture']['tmp_name'], $target);
    }

    $statement = 'INSERT INTO `coins` (`id`, `icon_src`, `name`, `price`, `visibility`, `last_updated`) 
    VALUES (:symbol, :target, :name, :price, :visibility, :last_update);';
    $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array('symbol' => $symbol, 'target' => $target, 'name' => $name, 'price' => $price, 'visibility' => $visibility, 'last_update' => now()));

    $_SESSION['dashboard-alert-type'] = 'success';
    $_SESSION['dashboard-message'] = 'Coin successfully added.';
    header("Location: /dashboard.php");
}