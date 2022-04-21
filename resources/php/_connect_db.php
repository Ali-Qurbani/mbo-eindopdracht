<?php
require $_SERVER['DOCUMENT_ROOT'] . '/connect_info.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//    $db = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}