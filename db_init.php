<?php
$host = "127.0.0.1"; // Change to "localhost" if needed
$dbname = "chat_db";
$port = 3306; // Default MySQL port
$dbUser = "root"; 
$dbPass = "password";

$dsn = "mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
