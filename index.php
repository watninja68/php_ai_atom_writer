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

$pageTitle = "Dashboard"; ?>
<?php require_once 'layout/header.php'; ?>

    <div class="flex flex-col md:flex-row">

         <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php'; ?>

        <!-- Main Content -->
        <main id="mainContent" class="main-content flex-1 md:p-6 ">
            <!-- Header -->
             <?php require_once 'layout/main-header.php'; ?> 
             <!-- Breadcrumb -->
             <?php include 'breadcrumb.php'; ?>
            

            <!-- Dashboard Cards -->
            <div class=" mb-8 px-5">
                <h1 class="text-2xl font-bold">
                    Welcome, User
                </h1>
                <p class="text-gray-400 dark:text-black">Here is what's happening today.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-[7fr_3fr] gap-5 p-5">


                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Card 1 -->


                    <!-- AI Tools -->
                    <div
                        class="p-6 bg-white/10 self-start dark:shadow-none dark:from-gray-400/10 dark:to-transparent rounded-2xl shadow-lg border border-gray-700 hover:border-cyan-400 hover:shadow-cyan-400/50 transition-all duration-300 group">
                        <div class="mb-4">
                            <h2
                                class="text-xl font-bold text-white dark:text-black dark:group-hover:text-black group-hover:text-cyan-400 transition-all duration-300">
                                AI Tools</h2>
                            <p class="text-gray-400 dark:text-black text-sm mt-1 mb-5 flex items-center gap-2">
                                <span class="w-2 h-2 bg-cyan-400  rounded-full animate-pulse"></span>
                                Most Used AI Tools
                            </p>

                        </div>
                        <div class="space-y-3">
                            <a href="./oneClickArticle.php"
                                class="flex justify-between items-center text-white dark:text-black border-b border-gray-700 pb-2 dark:hover:text-cyan-500 hover:text-cyan-400 hover:border-cyan-400 transition-all duration-300 cursor-pointer">
                                <span>One Click Article Wizard</span>
                                <span
                                    class="text-gray-500 group-hover:text-cyan-400 transition-all duration-300 transform group-hover:translate-x-1">&#x2197;</span>
                            </a>
                            <a href="/aiassistance.php"
                                class="flex justify-between items-center text-white dark:text-black border-b border-gray-700 pb-2 dark:hover:text-cyan-500 hover:text-cyan-400 hover:border-cyan-400 transition-all duration-300 cursor-pointer">
                                <span>AI Assistant</span>
                                <span
                                    class="text-gray-500 group-hover:text-cyan-400 transition-all duration-300 transform group-hover:translate-x-1">&#x2197;</span>
                            </a>
                            <a href="./chatGrammer.php"
                                class="flex justify-between items-center text-white dark:text-black border-b border-gray-700 pb-2 dark:hover:text-cyan-500 hover:text-cyan-400 hover:border-cyan-400 transition-all duration-300 cursor-pointer">
                                <span>Grammer Improvement</span>
                                <span
                                    class="text-gray-500 group-hover:text-cyan-400 transition-all duration-300 transform group-hover:translate-x-1">&#x2197;</span>
                            </a>
                        </div>
                    </div>

                    <!-- AI Assistants -->
                    <div
                        class="p-6 self-start dark:shadow-none bg-white/10 dark:from-gray-400/10 dark:to-transparent rounded-2xl shadow-lg border border-gray-700 hover:border-cyan-400 hover:shadow-cyan-400/50 transition-all duration-300 group">
                        <div class="mb-4">
                            <h2
                                class="text-xl font-bold text-white dark:text-black dark:group-hover:text-black group-hover:text-cyan-400 transition-all duration-300">
                                AI Assistants</h2>
                            <p class="text-gray-400 dark:text-black  text-sm mt-1 mb-5 flex items-center gap-2">
                                <span class="w-2 h-2 bg-cyan-400 dark:bg-cyan-400 rounded-full animate-pulse"></span>
                                Popular AI Assistants
                            </p>

                        </div>
                        <div class="space-y-3">
                            <div
                                class="flex justify-between items-center text-white dark:text-black border-b border-gray-700 pb-2 dark:hover:text-cyan-500 hover:text-cyan-400 hover:border-cyan-400 transition-all duration-300 cursor-pointer">
                                <span>Headline</span>
                                <span
                                    class="text-gray-500 group-hover:text-cyan-400 transition-all duration-300 transform group-hover:translate-x-1">&#x2197;</span>
                            </div>
                            <div
                                class="flex justify-between items-center text-white dark:text-black border-b border-gray-700 pb-2 dark:hover:text-cyan-500 hover:text-cyan-400 hover:border-cyan-400 transition-all duration-300 cursor-pointer">
                                <span>Facebook Ad Text</span>
                                <span
                                    class="text-gray-500 group-hover:text-cyan-400 transition-all duration-300 transform group-hover:translate-x-1">&#x2197;</span>
                            </div>
                            <div
                                class="flex justify-between items-center text-white dark:text-black border-b border-gray-700 pb-2 dark:hover:text-cyan-500 hover:text-cyan-400 hover:border-cyan-400 transition-all duration-300 cursor-pointer">
                                <span>Google Ad Text</span>
                                <span
                                    class="text-gray-500 group-hover:text-cyan-400 transition-all duration-300 transform group-hover:translate-x-1">&#x2197;</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Inner Grid (Article Wizard) -->
                <!-- <div
                    class="p-6 sm:h-max lg:h-full bg-white/10 dark:from-gray-400/10 dark:to-transparent rounded-2xl shadow-lg border border-gray-700 hover:border-cyan-400 hover:shadow-cyan-400/50 transition-all duration-300 flex flex-col items-center text-center"> -->

                <!-- Header -->
                <!-- <h2 class="text-lg text-white dark:text-black font-light">Have you already tried</h2>
                    <h2 class="text-xl font-bold text-cyan-400">Article Wizard?</h2> -->

                <!-- Image Section -->
                <!-- <div class="my-5 flex justify-center">
                        <img src="assets/images/23.svg" alt="Illustration"
                            class="w-32 lg:w-44 h-32 lg:h-44 object-contain">
                    </div> -->

                <!-- Button -->
                <!-- <button
                        class="lg:mt-10 mt-4 px-6 py-2 bg-cyan-500 hover:bg-cyan-400 text-white font-semibold rounded-lg shadow-md transition-all duration-300">
                        Try now
                    </button>
                </div> -->
            </div>




            <!-- Add the heading above the section -->
             <!-- AI Tool Section -->
        </main>
    </div>
    <?php require_once 'layout/footer.php'; ?>