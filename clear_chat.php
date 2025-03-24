<?php
session_start();

// Database connection (use the same parameters as in index.php)
$dsn  = "mysql:host=localhost;dbname=chat_db;charset=utf8mb4";
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
