<?php
$dbHost = "127.0.0.1"; // Or your DB host (e.g., localhost)
$dbPort = "3306";      // Or 8111 if that's your MariaDB port
$dbName = "write_db";   // <--- CHANGE THIS
$dbUser = "root";      // <--- CHANGE THIS (Use a dedicated user if possible)
$dbPass = "password";          // <--- CHANGE THIS (Your DB user's password)

// Construct the DSN (Data Source Name)
$dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";

// PDO options (optional but recommended)
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,               // Use native prepared statements
];

 try {
     $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
echo"Database done";
 } catch (\PDOException $e) {
echo"Database failed";
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
 }

?>
