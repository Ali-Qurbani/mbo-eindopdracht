<?php
require $_SERVER['DOCUMENT_ROOT'] . '/connect_info.php';

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
$db = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);

// Check connection
    //if ($conn->connect_error) {
    //    die("Connection failed: " . $conn->connect_error);
    //}

//try {
//    foreach($db->query('SELECT * from coins') as $row) {
//        print_r($row);
//    }
//    $db = null;
//} catch (PDOException $e) {
//    print "Error!: " . $e->getMessage() . "<br/>";
//    die();
//}

unset($servername, $dbname, $username, $password);