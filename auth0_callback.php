<?php
// This file acts solely as the entry point for the Auth0 redirect.
// All logic is handled within auth0_handler.php.

require_once __DIR__ . '/auth0_handler.php';

// The routing logic within auth0_handler.php checks for '?action=callback'
// which is implicitly handled because this file is the redirect target.
// If you didn't use '?action=callback' in the handler's routing,
// you would explicitly call handleCallback() here.
echo "wwfasdfas";
$pdo = null;
try {
    // Make sure $dsn, $dbUser, $dbPass are defined from db_init.php via the included handler
    global $dsn, $dbUser, $dbPass;
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    echo "db not working da"''
/*    error_log("Database connection failed in auth0_callback.php: " . $e->getMessage());*/
    /*redirectToLoginWithError('Database connection error during login.');*/
    /*exit;*/
}

// Explicitly call the callback handling function defined in the handler
handleCallback($auth0, $pdo);

?>
