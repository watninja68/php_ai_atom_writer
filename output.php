<?php
require_once __DIR__ . '/auth0_handler.php';

// Use the function from the handler to check authentication
if (!isAuthenticated()) {
    // Store the intended destination BEFORE redirecting to login
    $_SESSION['redirect_url_pending'] = $_SERVER['REQUEST_URI']; // Use a temporary key
    header('Location: login.php'); // Redirect to login page
    exit;
}

// If authenticated, the script continues...
// Use the centrally stored session variables
$userName = $_SESSION['user_name'] ?? 'User'; // Use session var set in callback
$userEmail = $_SESSION['user_email'] ?? ''; // Use session var set in callback
$userId = $_SESSION['user_id']; 

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

?>

<?php $pageTitle = "Output"; ?>
<?php require_once 'layout/header.php'; ?>

    <div class="flex flex-col md:flex-row">

        <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main id="mainContent" class="main-content flex-1 md:ml-64 md:p-6">
            <!-- Header -->
            <?php require_once 'layout/main-header.php'; ?> 

            <!-- Breadcrumb -->
            <?php include 'breadcrumb.php'; ?>

            <!-- Main Page -->
            <div class=" p-6">
                <h1 class="text-2xl font-bold mb-2">AI Output</h1>
                <p class="text-gray-400  dark:text-black mb-6">Find all the AI outputs you have created.</p>

                <!-- Search Bar -->
                <div
                    class="flex gap-4 bg-white/10 dark:from-gray-400/10 dark:to-transparent border border-gray-700 dark:border-gray-200 p-4 rounded-lg shadow-lg">
                    <div class="relative w-full ">
                        <input type="text" placeholder="Search"
                            class="w-full p-3 bg-white/10 border border-gray-500 dark:border-black  dark:text-black rounded-lg text-white placeholder-gray-400 focus:ring-1 dark:focus:ring-black focus:ring-cyan-500 focus:outline-none">
                    </div>
                    <select
                        class="p-3 bg-white/10 border border-gray-500 dark:border-black rounded-lg text-white dark:text-black focus:ring-1 focus:ring-cyan-500 dark:focus:ring-black focus:outline-none">
                        <option class="bg-gray-800">Category</option>
                        <option class="bg-gray-800">Text</option>
                        <option class="bg-gray-800">Image</option>
                        <option class="bg-gray-800">Audio</option>
                    </select>
                </div>
                <div class="flex justify-end mt-4 gap-2">
                    <button class="p-3 bg-blue-600 hover:bg-blue-500 rounded-lg transition-all shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="white">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="p-3 bg-gray-600 hover:bg-gray-500 rounded-lg transition-all shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="white">
                            <path d="M10 3H3V10H10V3ZM21 3H14V10H21V3ZM21 14H14V21H21V14ZM10 14H3V21H10V14Z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </div>
                <!-- AI Output Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 p-5">
                    <!-- Card 1 -->
                    <div
                        class="relative bg-white/10 dark:from-gray-400/10 dark:to-transparent border-gray-300 p-5 rounded-2xl shadow-lg border hover:border-cyan-400 hover:shadow-cyan-400/50 transition-all duration-300 transform hover:scale-105 hover:rotate-0 ">
                        <!-- Head Section -->
                        <div class="mb-4">
                            <div class="flex justify-end space-x-3">
                                <!-- Star Icon -->
                                <button class="text-gray-400 hover:text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <!-- Copy Icon -->
                                <button class="text-gray-400 hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <!-- Delete Icon -->
                                <button class="text-gray-400 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <h2 class="text-lg font-bold text-white dark:text-black mt-6 ">AI Writing Tool</h2>

                        </div>

                        <!-- Body Section -->
                        <div
                            class="overflow-hidden mt-2 mb-5 h-52 dark:border-t overflow-y-auto dark:border-b border-gray-200 dark:border-gray-700 py-3">
                            <p class="text-sm text-white dark:text-black">
                                A Warm Welcome: Exploring the Power of Greetings
                                A Warm Welcome: Exploring the Power of Greetings A Warm Welcome: Exploring the Power of
                                Greetings A Warm Welcome: Exploring the Power of Greetings A Warm Welcome: Exploring the
                                Power of Greetings A Warm Welcome: Exploring the Power of Greetings A Warm Welcome:
                                Exploring the Power of Greetings A Warm Welcome: Exploring the Power of Greetings A Warm
                                Welcome: Exploring the Power of Greetings A Warm Welcome: Exploring the Power of
                                Greetings
                            </p>
                        </div>

                        <!-- Footer Section -->
                        <div class="mt-4 text-white dark:text-black text-xs flex justify-between">
                            <span>Characters: 48</span>
                            <span>Created: 02/16/2025</span>
                        </div>
                    </div>
                    <!-- Card 2 -->
                    <div
                        class="relative bg-white/10 dark:from-gray-400/10 dark:to-transparent border border-gray-300 p-5 rounded-2xl shadow-lg hover:border-cyan-400 hover:shadow-cyan-400/50 transition-all duration-300 transform hover:scale-105 hover:rotate-0 ">
                        <!-- Head Section -->
                        <div class="mb-4">
                            <div class="flex justify-end space-x-3">
                                <!-- Star Icon -->
                                <button class="text-gray-400 hover:text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <!-- Copy Icon -->
                                <button class="text-gray-400 hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <!-- Delete Icon -->
                                <button class="text-gray-400 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <h2 class="text-lg font-bold text-white dark:text-black mt-6 ">Text Generator</h2>

                        </div>

                        <!-- Body Section -->
                        <div
                            class="overflow-hidden mt-2 mb-5 h-52 dark:border-t overflow-y-auto dark:border-b border-gray-200 dark:border-gray-700 py-3">
                            <p class="text-sm text-white dark:text-black">
                                Generate high-quality text content effortlessly. </p>
                        </div>

                        <!-- Footer Section -->
                        <div class="mt-4 text-white dark:text-black text-xs flex justify-between">
                            <span>Words: 200</span>
                            <span>Updated: 02/15/2025</span>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="relative bg-white/10 dark:from-gray-400/10 dark:to-transparent border border-gray-300 p-5 rounded-2xl shadow-lg hover:border-cyan-400 hover:shadow-cyan-400/50 transition-all duration-300 transform hover:scale-105 hover:rotate-0 ">
                        <!-- Head Section -->
                        <div class="mb-4">
                            <div class="flex justify-end space-x-3">
                                <!-- Star Icon -->
                                <button class="text-gray-400 hover:text-yellow-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </button>
                                <!-- Copy Icon -->
                                <button class="text-gray-400 hover:text-blue-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <!-- Delete Icon -->
                                <button class="text-gray-400 hover:text-red-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <h2 class="text-lg font-bold text-white dark:text-black mt-6 ">Story Creator</h2>

                        </div>

                        <!-- Body Section -->
                        <div
                            class="overflow-hidden mt-2 mb-5 h-52 dark:border-t overflow-y-auto dark:border-b border-gray-200 dark:border-gray-700 py-3">
                            <p class="text-sm text-white dark:text-black">
                                Craft compelling stories with AI-powered tools. </p>
                        </div>

                        <!-- Footer Section -->
                        <div class="mt-4 text-white dark:text-black text-xs flex justify-between">
                            <span>Pages: 10</span>
                            <span>Saved: 02/14/2025</span>
                        </div>
                    </div>
                </div>
            </div>


        </main>
    </div>
    <?php require_once 'layout/footer.php'; ?>