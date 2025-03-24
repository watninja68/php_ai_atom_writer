<?php
include 'db_init.php';
require_once 'vendor/autoload.php';
session_start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourApiKey = $_ENV['QWEN_API'];
$google_oauth_client_id = $_ENV['GOOGLE_CLIENT_ID'];
$google_oauth_client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];

echo $yourApiKey;
echo $google_oauth_client_id;
echo $google_oauth_client_secret;
?>