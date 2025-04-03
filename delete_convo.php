<?php
// delete_convo.php
require_once __DIR__ . '/auth0_handler.php';
include_once __DIR__ . '/db_init.php'; // Include DB config

// Check authentication
if (!isAuthenticated()) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$conversationIdToDelete = $_GET['conversation_id'] ?? null;
$currentConversationId = $_GET['current_id'] ?? null; // ID user was viewing

if (!$conversationIdToDelete) {
    // No ID provided, redirect back
    header('Location: aichat.php');
    exit;
}

// Establish PDO connection (ensure db_init.php defines $dsn, $dbUser, $dbPass)
try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute deletion
    $stmt = $pdo->prepare("DELETE FROM chat_messages WHERE conversation_id = :conv_id AND user_id = :user_id");
    $stmt->execute([
        ':conv_id' => $conversationIdToDelete,
        ':user_id' => $userId
    ]);

    // Redirect: If user deleted the conversation they were currently viewing,
    // redirect to the base aichat.php so it picks a new one or shows 'new'.
    // Otherwise, redirect back to the conversation they were on.
    if ($conversationIdToDelete === $currentConversationId) {
         header('Location: aichat.php'); // Go to default view
         exit;
    } else {
         // Redirect back to the conversation they were previously viewing (if any)
         if ($currentConversationId) {
              header('Location: aichat.php?conversation_id=' . urlencode($currentConversationId));
         } else {
              header('Location: aichat.php'); // Fallback to default
         }
         exit;
    }

} catch (PDOException $e) {
    // Log the error
    error_log("Error deleting conversation {$conversationIdToDelete} for user {$userId}: " . $e->getMessage());
    // Redirect with an error flag maybe, or just back to chat
    // For simplicity, just redirect back:
    header('Location: aichat.php' . ($currentConversationId ? '?conversation_id=' . urlencode($currentConversationId) : ''));
    exit;
}
?>