<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure this path is correct relative to db_test.php
require_once __DIR__ . '/db_init.php';

echo "Attempting connection with DSN: " . htmlspecialchars($dsn) . "<br>";
echo "User: " . htmlspecialchars($dbUser) . "<br>";
// Do NOT echo the password in production or leave this file accessible!
// echo "Password: " . htmlspecialchars($dbPass) . "<br>";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h1>Database connection successful!</h1>";

    // Optional: Check if the users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "Table 'users' found.<br>";
    } else {
        echo "<strong style='color:red;'>Table 'users' NOT found.</strong> Import your SQL schema.<br>";
    }

} catch (PDOException $e) {
    echo "<h1 style='color:red;'>Database Connection Failed:</h1>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p>Check db_init.php credentials, database/user existence, permissions, and MySQL server status.</p>";
}
?>