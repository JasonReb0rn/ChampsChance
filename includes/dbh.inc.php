<?php

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

$serverName = "champschancedb.c7i33b1nzkaa.us-east-2.rds.amazonaws.com";
$dBUsername = "admin";
$dBPassword = $_ENV['CC_RDS_PW'] ?? null;
$dBName = "champschance";
$dBPort = 3306;

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName, $dBPort);

if (!$conn) {
    die("Connection to DB failed: " . mysqli_connect());
}
