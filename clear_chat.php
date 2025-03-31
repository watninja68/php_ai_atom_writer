<?php
require_once __DIR__ . '/auth0_handler.php';

// Use the function from the handler to check authentication
if (!isAuthenticated()) {
    // Store the intended destination BEFORE redirecting to login
    $_SESSION['redirect_url_pending'] = $_SERVER['REQUEST_URI']; // Use a temporary key
    header('Location: login.php'); // Redirect to login page
    exit;
}

// If authenticated, the script continues...
// Use the centrally stored session variables
$userName = $_SESSION['user_name'] ?? 'User'; // Use session var set in callback
$userEmail = $_SESSION['user_email'] ?? ''; // Use session var set in callback
$userId = $_SESSION['user_id']; 

// Database connection (use the same parameters as in index.php)
$dsn  = "mysql:host=localhost;dbname=write_db;charset=utf8mb4";
$dbUser = "dbuser";
$dbPass = "dbpass";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get conversation ID from GET parameter; default to "default" if missing
$conversationId = isset($_GET['conversation_id']) ? $_GET['conversation_id'] : 'default';

// Delete all messages in this conversation for the current session
$stmt = $pdo->prepare("DELETE FROM chat_messages WHERE session_id = :session_id AND conversation_id = :conversation_id");
$stmt->execute([
    ':session_id' => session_id(),
    ':conversation_id' => $conversationId
]);

echo "Chat history cleared.";
