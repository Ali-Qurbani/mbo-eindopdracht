<?php
session_start();
include '_functions.php';

// Form input
$name =     $_POST['name'];
$email =    $_POST['email'];
$tel =      $_POST['tel'];
$comment =  $_POST['message'];

$receiver = "info@website.com";
unset($_SESSION["contact_status"]);
unset($_SESSION["contact_status_type"]);

if (empty($name) || empty($email) || empty($comment) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["contact_status"] = 'error';
} else {

    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=UTF-8';

    $headers[] = 'Contact form';
    $headers[] .= 'From: Contact form <' . $email . '>' . "\r\n";

    $to      = $receiver;
    $subject = 'Contact form';

    $message = use_template($name, $email, $tel, $comment);

    if (mail($to, $subject, $message, implode("\r\n", $headers))) {
        $_SESSION["contact_status_type"] = 'success';
        $_SESSION["contact_status"] = 'Mail successfully sent';
    } else {
        $_SESSION["contact_status_type"] = 'error';
        $_SESSION["contact_status"] = 'Something went wrong please try again later';
    }
}
header("Location: ../../contact.php");