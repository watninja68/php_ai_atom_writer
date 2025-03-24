<?php
include 'db_init.php';

session_start();

// Generate a new unique conversation ID
$newConversationId = uniqid('conv_', true);
$_SESSION['conversation_id'] = $newConversationId;

// Redirect back to the chat interface with the new conversation ID
header("Location: chat.php?conversation_id=" . urlencode($newConversationId));
exit;
