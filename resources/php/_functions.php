<?php

function sanitize($raw_data): string
{
    global $conn;
    $data = htmlspecialchars($raw_data);
    $data = mysqli_real_escape_string($conn, $data);
    return trim($data);
}

function use_template($name, $email, $tel, $comment) {
    $mail_template = file_get_contents("../../mail_template.html");
    $template_vars = ['<!!!---][ name ][---!!!>', '<!!!---][ mail ][---!!!>', '<!!!---][ tel ][---!!!>', '<!!!---][ message ][---!!!>'];
    $vars = [$name, $email, $tel, $comment];
    return str_replace($template_vars, $vars, $mail_template);
}

function use_pw_reset_template($url) {
    $mail_template = file_get_contents("../../pw_reset_mail_template.html");
    return str_replace('<!!!---][ url ][---!!!>', $url, $mail_template);
}

function mk_password_hash_from_microtime(): array
{
    $mut = microtime();
    $time = explode(" ", $mut);
    $password = $time[1] * $time[0] * 1000000;
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $one_hour = mktime(1, 0,0, 1, 1, 1970);
    $date_formatted = date("d-m-y", ($time[1] + $one_hour));
    $time_formatted = date("h:i:s", ($time[1] + $one_hour));
    return array("password_hash" => $password_hash,
        "date"          => $date_formatted,
        "time"          => $time_formatted);
}