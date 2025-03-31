<?php
include 'db_init.php';

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

// Generate a new unique conversation ID
$newConversationId = uniqid('conv_', true);
$_SESSION['conversation_id'] = $newConversationId;

// Redirect back to the chat interface with the new conversation ID
header("Location: chat.php?conversation_id=" . urlencode($newConversationId));
exit;
