<?php
// auth_action.php

// Include the handler to get $auth0, functions, and session started
require_once __DIR__ . '/auth0_handler.php';

// --- Routing Logic ---
$action = $_GET['action'] ?? null;
// $currentScript = basename($_SERVER['SCRIPT_FILENAME']); // Not needed here

// Establish PDO connection (ensure db_init.php is included by the handler)
$pdo = null;
try {
    // Make sure $dsn, $dbUser, $dbPass are defined from db_init.php via the included handler
    global $dsn, $dbUser, $dbPass; // Make vars from db_init.php available if not already global
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    error_log("Database connection failed in auth_action.php: " . $e->getMessage());
    redirectToLoginWithError('Database connection error during authentication.'); // Use function from handler
    exit; // Ensure script stops if DB connection fails here
}

if ($action === 'login') {
    handleLogin($auth0); // Call function defined in the handler
}
elseif ($action === 'logout') {
    handleLogout($auth0); // Call function defined in the handler
}
else {
    // Default action if no valid action is specified - maybe redirect to login?
     echo "Invalid authentication action specified.";
    // Or redirect:
    // header('Location: login.php');
    // exit;
}

// No need for the callback check here, that's handled by auth0_callback.php

?>