<?php
date_default_timezone_set('Europe/Amsterdam');

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

function get_db_slide_info($db) {
    $statement = $db->query("SELECT `id`, `image_src`, `visibility`, `title`, `description` FROM `slider-images` ORDER BY `visibility` DESC");

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_db_coin_info($db) {
    $statement = $db->query("SELECT `id`, `icon_src`, `name`, `price`, `visibility`, `last_updated` FROM `coins` ORDER BY `visibility` DESC");

    return $coins = $statement->fetchAll(PDO::FETCH_ASSOC);
}

function now(): string
{
    $date = new DateTime();
    return $date->format('Y-m-d H:i:s');
}

function update_prices($db) {
    $statement = $db->query("SELECT `id`, `icon_src`, `name`, `price`, `visibility`, `last_updated` FROM `coins` WHERE `visibility` = '1'");

    $coins = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($coins as $coin) {
        $data = json_decode(file_get_contents("https://api.binance.com/api/v3/avgPrice?symbol=".$coin['id']), TRUE);

        $statement = "UPDATE `coins` SET `price` = :price, `last_updated` = :last_update WHERE `coins`.`id` = :id;";
        $sth = $db->prepare($statement, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $sth->execute(array('price' => $data['price'], 'id' => $coin['id'], 'last_update' => now()));
    }
}

function crypto_calculator_prices($db) {
    $statement = $db->query("SELECT `icon_src`, `name`, `price` FROM `coins` WHERE `visibility` = '1'");

    return $coins = $statement->fetchAll(PDO::FETCH_ASSOC);
}