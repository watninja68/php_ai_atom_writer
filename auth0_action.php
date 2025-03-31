<?php
// auth_action.php

// Include the handler to get $auth0, functions, and session started
require_once __DIR__ . '/auth0_handler.php';

// --- Routing Logic ---
$action = $_GET['action'] ?? null;

// ---- NO DATABASE CONNECTION NEEDED HERE for standard login/logout ----
/*
$pdo = null;
try {
    global $dsn, $dbUser, $dbPass;
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    error_log("Database connection failed in auth_action.php: " . $e->getMessage());
    // Use function from handler. Pass a generic message.
    redirectToLoginWithError('Database service unavailable.');
    exit;
}
*/
// ---- END REMOVED DB CONNECTION ----

if ($action === 'login') {
    handleLogin($auth0); // Call function defined in the handler
}
elseif ($action === 'logout') {
    handleLogout($auth0); // Call function defined in the handler
}
else {
    // Default action: Invalid action, redirect to login or show error
    // echo "Invalid authentication action specified.";
    // header('HTTP/1.1 400 Bad Request');
    // exit('Invalid action.');
    // Or redirect:
     header('Location: login.php');
     exit;
}
?>