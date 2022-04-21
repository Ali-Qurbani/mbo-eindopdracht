<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /_login.php");
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<?php include_once '_partials/_navbar.php' ?>

</body>
<?php include_once '_partials/_footer.php' ?>
</html>