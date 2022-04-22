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

$stmt = $conn->prepare("SELECT `icon_src` FROM `coins` WHERE id = '$id'");
$stmt->execute();
$stmt->bind_result($db_image_src);
while (mysqli_stmt_fetch($stmt)) {
    $old_img_src = $db_image_src;
}

$file_pointer = $old_img_src;
if (!unlink($file_pointer)) {
    echo 'File deletion error';
    return false;
}

$stmt2 = $conn->prepare("DELETE FROM `coins` WHERE id = ?");
$stmt2->bind_param("s", $id);
$stmt2->execute();
$stmt2->close();

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Coin successfully removed.';
header("Location: /dashboard.php");