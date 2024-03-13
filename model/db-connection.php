<?php

try {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $dbuser = getenv('DB_USER');
    $dbpass = getenv('DB_PASS');
    $db_url = "mysql:host={$host};dbname={$dbname}";
    $PDO = new PDO($db_url, $dbuser, $dbpass);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
