<?php
// auth0_callback.php
// This file acts solely as the entry point for the Auth0 redirect.

// Include the handler - it now contains ONLY definitions and session start.
// The handler itself will NOT output "Invalid Auth Action".
require_once __DIR__ . '/auth0_handler.php';

// Establish PDO connection for the callback handler
$pdo = null;
try {
    // Make sure $dsn, $dbUser, $dbPass are defined from db_init.php via the included handler
    global $dsn, $dbUser, $dbPass;
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    error_log("Database connection failed in auth0_callback.php: " . $e->getMessage());
    redirectToLoginWithError('Database connection error during login.');
    exit;
}

// Explicitly call the callback handling function defined in the handler
handleCallback($auth0, $pdo);

?>