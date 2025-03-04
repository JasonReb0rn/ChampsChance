<?php

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

$serverName = $_ENV['MYSQL_HOST'] ?? 'db';
$dBUsername = "admin";
$dBPassword = $_ENV['MYSQL_PASSWORD'] ?? null;
$dBName = "champschance";
$dBPort = 3306;

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, $dBPort);

if (!$conn) {
    die("Connection to DB failed: " . mysqli_connect());
}
