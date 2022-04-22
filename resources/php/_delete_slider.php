<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
include("_connect_db.php");
$id = $_GET["id"];

$stmt = $conn->prepare("SELECT `image_src` FROM `slider-images` WHERE id = '$id'");
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

$stmt2 = $conn->prepare("DELETE FROM `slider-images` WHERE id = ?");
$stmt2->bind_param("s", $id);
$stmt2->execute();
$stmt2->close();

$_SESSION['dashboard-alert-type'] = 'success';
$_SESSION['dashboard-message'] = 'Category successfully removed.';
header("Location: /dashboard.php");