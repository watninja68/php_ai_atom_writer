<?php
// THIS MUST BE AT THE VERY TOP BEFORE ANY HTML
require_once __DIR__ . '/auth0_handler.php'; // To get session started and functions

// If user is already logged in, redirect them to dashboard
if (isAuthenticated()) {
    header('Location: dashboard.php');
    exit;
}

$loginError = null;
if (isset($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Clear error after displaying
}

$loggedOutMessage = null;
if (isset($_GET['loggedout']) && $_GET['loggedout'] === 'true') {
    $loggedOutMessage = "You have been successfully logged out.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AI Atom Writer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles/custom.css"> <!-- Adjust path if needed -->
    <style>
        /* Add styles for error/success messages */
        .message { padding: 1rem; margin-bottom: 1rem; border-radius: 0.5rem; }
        .message-error { background-color: #fecaca; border: 1px solid #f87171; color: #b91c1c; }
        .message-success { background-color: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
    </style>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md">
        <h1 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
            AI Atom Writer Login
        </h1>

        <?php if ($loginError): ?>
            <div class="message message-error" role="alert">
                <?php echo htmlspecialchars($loginError); ?>
            </div>
        <?php endif; ?>

        <?php if ($loggedOutMessage): ?>
            <div class="message message-success" role="alert">
                <?php echo htmlspecialchars($loggedOutMessage); ?>
            </div>
        <?php endif; ?>

        <p class="text-center text-gray-400 mb-6">
            Please log in using your preferred method via our secure provider.
        </p>

        <div class="text-center">
            <a href="auth0_action.php?action=login"
               class="inline-block w-full px-6 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-cyan-400 hover:to-blue-500 transition duration-300 glow focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-opacity-75">
                Login / Sign Up
            </a>
        </div>

        <!-- Optional: Add links like "Forgot Password?" if handled by Auth0 -->
        <!-- <div class="text-center mt-4">
            <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">Forgot Password?</a>
        </div> -->
    </div>

</body>
</html>