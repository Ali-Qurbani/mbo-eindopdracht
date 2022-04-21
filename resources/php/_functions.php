<?php

function sanitize($raw_data): string
{
    global $conn;
    $data = htmlspecialchars($raw_data);
    $data = mysqli_real_escape_string($conn, $data);
    return trim($data);
}