<?php
session_start(); // Start session to check for errors

$pageTitle = "Login";
// Basic header without needing full authentication check yet
?>
<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - AI Writer' : 'AI Writer'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles/custom.css"> <!-- Assuming your custom styles -->
    <script>
        // Handle theme switching (optional, keep if you use it)
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-xl w-full max-w-md text-center">
        <h1 class="text-3xl font-bold mb-6 text-cyan-400">Login or Sign Up</h1>
        <p class="text-gray-400 mb-8">Use your preferred method to access the AI Writer.</p>

        <?php
        // Display login errors if any
        if (isset($_SESSION['login_error'])) {
            echo '<div class="bg-red-500/30 border border-red-600 text-red-200 px-4 py-3 rounded relative mb-6" role="alert">';
            echo '<strong class="font-bold">Error:</strong>';
            echo '<span class="block sm:inline"> ' . htmlspecialchars($_SESSION['login_error']) . '</span>';
            echo '</div>';
            unset($_SESSION['login_error']); // Clear error after displaying
        }
        ?>

        <a href="auth0_action.php?action=login"
           class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-bold py-3 px-4 rounded-lg inline-flex items-center justify-center transition duration-300 ease-in-out transform hover:scale-105 glow">
            <i class="fas fa-sign-in-alt mr-2"></i> Login / Sign Up with Auth0
        </a>
         <p class="text-sm text-gray-500 mt-4">You will be redirected to Auth0 to choose your login method (Email/Password, Google, or Microsoft).</p>
    </div>

    <script src="scripts/script.js"></script> <!-- Include if needed for theme toggle -->
</body>
</html>