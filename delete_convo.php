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

include 'db_init.php';

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    die("Database connection failed: " . $e->getMessage());
}

// Get conversation ID and validate
if (!isset($_GET['conversation_id'])) {
    http_response_code(400);
    die("No conversation specified.");
}

$conversationId = $_GET['conversation_id'];
$userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

try {
    // Delete the conversation for the current user
    $stmt = $pdo->prepare("DELETE FROM chat_messages 
                          WHERE conversation_id = :conversation_id 
                          AND user_id = :user_id");
    
    $result = $stmt->execute([
        ':conversation_id' => $conversationId,
        ':user_id' => $userId
    ]);

    if ($result) {
        http_response_code(200);
        echo "Conversation deleted successfully";
    } else {
        http_response_code(500);
        echo "Failed to delete conversation";
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}