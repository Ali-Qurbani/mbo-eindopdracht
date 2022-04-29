<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
unset($_SESSION["dashboard-alert-type"]);
unset($_SESSION["dashboard-message"]);

include("_connect_db.php");
$id = $_GET["id"];

$statement = 'SELECT `image_src` FROM `slider-images` WHERE id = :id';
$sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth->execute(array('id' => $id));
$img_src = $sth->fetch();

$file_pointer = $img_src['image_src'];
if (!unlink($file_pointer)) {
    $_SESSION['dashboard-alert-type'] = 'error';
    $_SESSION['dashboard-message'] = 'File deletion error.';
    header("Location: /admin_sliders.php");
    return false;
}

$statement2 = "DELETE FROM `slider-images` WHERE id = :id";
$sth2 = $db->prepare($statement2, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
$sth2->execute(array('id' => $id));

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Slider successfully removed.';
header("Location: /admin_sliders.php");