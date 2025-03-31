
<?php

// Load environment variables (if not already loaded)
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

// Database credentials from environment variables
$dbHost = $_ENV['DB_HOST'] ?? "atomwriter_database";
$dbPort = $_ENV['DB_PORT'] ?? '3306';     // Default to 3306 if not set
$dbName = $_ENV['DB_NAME'] ?? 'write_db';   // Use a default name, but *require* it to be set
$dbUser = $_ENV['DB_USER'] ?? 'root';      // Provide a default, but strongly encourage changing it
$dbPass = $_ENV['DB_PASS'] ?? 'password';          // Important: Set a strong password in your .env file

// Construct the DSN (Data Source Name)
$dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$db_connection_status = false; // Initialize connection status

try {
    // Create a PDO instance (connect to the database)
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);

    // Optional:  Set character set after connection (some systems require this)
    $pdo->exec("SET NAMES 'utf8mb4'");

    // Set connection status to true if successful
    $db_connection_status = true;
echo "db connection done yeay";
    // For testing the connection (remove in production)
    // echo "Successfully connected to the database!";

} catch (PDOException $e) {
    // Handle connection errors
    //echo "Connection failed: " . $e->getMessage();  // Remove or comment out in production
    error_log("Database connection error: " . $e->getMessage()); // Log the error

    // Set connection status to false if there's an error
    $db_connection_status = false;

    // You might choose to *not* die() here, so other scripts can still run
    // even if the database connection fails.  This depends on your application.
    // die(); // Terminate the script - REMOVE or COMMENT OUT IN SOME CASES
}

// Now you can use the $pdo object to perform database queries
// And you can check the $db_connection_status variable in other scripts.

// Example query (replace with your actual query)
// $stmt = $pdo->query("SELECT * FROM your_table");
// while ($row = $stmt->fetch()) {
//   echo $row['column_name'];
// }

?>
