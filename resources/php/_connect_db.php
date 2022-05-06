<?php
require $_SERVER['DOCUMENT_ROOT'] . '/connect_info.php';

// Create connection
$db = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password, array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
));

unset($servername, $dbname, $username, $password);