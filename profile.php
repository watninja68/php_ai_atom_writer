<?php
// Include the Auth0 handler - this also handles session_start() safely
require_once __DIR__ . '/auth0_handler.php';

// Use the function from the handler to check authentication
if (!isAuthenticated()) {
    // Optional: Store the intended destination
    $_SESSION['redirect_url_pending'] = $_SERVER['REQUEST_URI']; // Use temporary key
    header('Location: login.php');
    exit;
}

// If authenticated, the script continues...
// --- Get user info reliably from session variables set in auth0_handler ---
$userName = $_SESSION['user_name'] ?? 'User'; // Default to 'User'
$userEmail = $_SESSION['user_email'] ?? 'No email provided'; // Default text
$userId = $_SESSION['user_id'] ?? null; // Your internal DB user ID (should always be set if authenticated)
$userPicture = $_SESSION['user_picture'] ?? 'assets/images/user.png'; // Default placeholder image

// --- Optional: Fetch additional data from your database if needed ---
/*
$pdo = null;
$additionalUserData = null;
if ($userId) {
    try {
        // Ensure db_init.php is included via auth0_handler.php or include it here
        // require_once __DIR__ . '/db_init.php';
        global $dsn, $dbUser, $dbPass; // Use globals defined in db_init.php
        $pdo = new PDO($dsn, $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id"); // Fetch all data or specific columns
        $stmt->execute([':user_id' => $userId]);
        $additionalUserData = $stmt->fetch(PDO::FETCH_ASSOC);

        // You could potentially override session data if DB is more up-to-date, or merge data
        // if ($additionalUserData && isset($additionalUserData['name'])) {
        //     $userName = $additionalUserData['name'];
        // }

    } catch (PDOException $e) {
        error_log("Database error fetching user data in profile.php: " . $e->getMessage());
        // Handle error appropriately, maybe show a message, but don't crash
    }
}
*/
// --- End Optional DB Fetch ---

?>
<?php $pageTitle = "User Profile"; ?>
<?php require_once 'layout/header.php'; ?>

<div class="flex flex-col md:flex-row">

   <!-- Sidebar -->
   <?php require_once 'layout/sidebar.php'; ?>

    <!-- Main Content -->
    <main id="mainContent" class="main-content flex-1 md:ml-64 md:p-6">
      <!-- Header -->
      <?php require_once 'layout/main-header.php'; ?>

      <!-- Breadcrumb -->
        <nav class="flex pb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                <a href="dashboard.php" class="inline-flex items-center text-sm font-medium text-gray-300 hover:text-white dark:text-gray-400 dark:hover:text-cyan-500">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Dashboard
                </a>
                </li>
                <li aria-current="page">
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">Profile</span>
                </div>
                </li>
            </ol>
        </nav>


      <!-- Profile Section -->
        <div class="glass-card p-6 md:p-8 rounded-lg shadow-lg border border-gray-700 dark:border-gray-200 max-w-2xl mx-auto">
            <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center text-white dark:text-gray-800">Your Profile</h1>

            <div class="flex flex-col items-center space-y-6">
                <!-- Profile Picture -->
                <div class="relative">
                    <img src="<?php echo htmlspecialchars($userPicture); ?>" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover border-4 border-cyan-500 shadow-md">
                    <!-- Optional: Edit Icon -->
                    <!-- <button class="absolute bottom-0 right-0 bg-gray-700 p-2 rounded-full hover:bg-cyan-600 transition duration-300">
                        <i class="fas fa-pencil-alt text-white text-sm"></i>
                    </button> -->
                </div>

                <!-- User Information -->
                <div class="text-center space-y-2 w-full">
                    <h2 class="text-xl font-semibold text-white dark:text-gray-900"><?php echo htmlspecialchars($userName); ?></h2>
                    <p class="text-gray-400 dark:text-gray-600"><?php echo htmlspecialchars($userEmail); ?></p>
                    <!-- Add more profile fields if needed -->
                    <!-- Example: <p class="text-gray-500 dark:text-gray-500">Joined: [Join Date]</p> -->
                    <?php if ($userId): ?>
                         <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">User ID: <?php echo htmlspecialchars($userId); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-4 w-full justify-center">
                    <button class="bg-cyan-500/80 px-6 py-2 cursor-pointer text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow w-full sm:w-auto">
                        Edit Profile
                    </button>
                    <button class="bg-gray-600/50 px-6 py-2 cursor-pointer text-gray-300 dark:text-gray-700 rounded-lg hover:bg-gray-500/50 transition-all duration-300 w-full sm:w-auto">
                        Change Password
                    </button>
                     <a href="auth0_action.php?action=logout" class="bg-red-600/80 text-center px-6 py-2 cursor-pointer text-white rounded-lg hover:bg-red-500/80 transition-all duration-300 w-full sm:w-auto">
                        Logout
                     </a>
                </div>
                 <!-- Optional: Display additional data fetched from DB -->
                 <?php /* if ($additionalUserData): ?>
                 <div class="mt-6 border-t border-gray-600 dark:border-gray-300 pt-6 w-full text-sm text-gray-400 dark:text-gray-600">
                    <h3 class="font-semibold text-lg mb-2 text-white dark:text-gray-800">Additional Info</h3>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($additionalUserData['status'] ?? 'N/A'); ?></p>
                    <p><strong>Plan:</strong> <?php echo htmlspecialchars($additionalUserData['plan_id'] ?? 'N/A'); ?> </p>
                    <p><strong>Created:</strong> <?php echo htmlspecialchars($additionalUserData['created_at'] ?? 'N/A'); ?></p>
                     <!-- Add more fields as needed -->
                 </div>
                 <?php endif; */ ?>
            </div>
        </div>

    </main>
</div>

<?php require_once 'layout/footer.php'; ?>