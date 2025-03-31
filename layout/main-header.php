<?php
// Ensure the handler is included if not already done by the parent page
// If the parent page *always* includes the auth check block from Step 4.5,
// you might not need this require_once here, but it's safer to include it.
require_once __DIR__ . '/../auth0_handler.php';

// Ensure session is started if not already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$isAuthenticated = isAuthenticated(); // Check authentication status
$user = $isAuthenticated ? getUser() : null; // Get user info if authenticated

// Define $userName and $userPicture safely
$userName = $user['name'] ?? ($user['nickname'] ?? 'User');
$userPicture = $user['picture'] ?? 'assets/images/user.png'; // Default picture

?>
<header class="bg-gray-800/80 dark:bg-gray-100/80 backdrop-blur-md text-white shadow-md sticky top-0 z-40">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <!-- Left Side: Toggle and potentially breadcrumbs/title if moved here -->
        <div class="flex items-center">
             <!-- Sidebar Toggle for Mobile -->
             <button id="sidebarToggle" class="md:hidden text-white dark:text-black mr-4 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
             <!-- Optional: Page Title or Logo -->
             <span class="text-lg font-semibold text-white dark:text-black hidden md:block">AI Writer</span>
        </div>


        <!-- Right Side: Search, Notifications, Profile -->
        <div class="flex items-center space-x-4">
            <!-- Theme Toggle -->
            <button id="theme-toggle" type="button"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 transition-colors duration-200">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                        fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>

            <!-- Profile Dropdown -->
            <?php if ($isAuthenticated): ?>
                <div class="relative">
                    <button id="profileDropdownToggle"
                        class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                        <img class="h-8 w-8 rounded-full object-cover"
                             src="<?php echo htmlspecialchars($userPicture); ?>"
                             alt="<?php echo htmlspecialchars($userName); ?>">
                        <span class="hidden md:inline ml-2 text-white dark:text-black"><?php echo htmlspecialchars($userName); ?></span>
                        <svg class="hidden md:block ml-1 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="profileDropdownMenu"
                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                        role="menu" aria-orientation="vertical" aria-labelledby="profileDropdownToggle">
                        <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                            role="menuitem">Your Profile</a>
                        <a href="settings.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                            role="menuitem">Settings</a> <!-- Add settings page if you have one -->
                        <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                            role="menuitem">Sign out</a>
                    </div>
                </div>
            <?php else: ?>
                 <!-- Show Login Button if not authenticated -->
                 <a href="login.php" class="bg-cyan-500 hover:bg-cyan-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                    Login
                </a>
            <?php endif; ?>

        </div>
    </div>
     <!-- Mobile Menu (if you have one separate from sidebar) -->
     <!-- <div id="mobileMenu" class="md:hidden hidden bg-gray-800 dark:bg-gray-100 p-4 space-y-2"> -->
         <!-- Mobile nav links -->
     <!-- </div> -->
</header>

<script>
    // Basic Dropdown Toggle
    const profileToggle = document.getElementById('profileDropdownToggle');
    const profileMenu = document.getElementById('profileDropdownMenu');
    const sidebarToggle = document.getElementById('sidebarToggle'); // Added for mobile sidebar
    const mainContent = document.getElementById('mainContent'); // Target main content
    const sidebar = document.getElementById('sidebar'); // Target sidebar

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicking outside
        document.addEventListener('click', (event) => {
            if (!profileToggle.contains(event.target) && !profileMenu.contains(event.target)) {
                profileMenu.classList.add('hidden');
            }
        });
    }

     // Mobile Sidebar Toggle Logic
    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation(); // Prevent click from bubbling up to document listener
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0'); // Ensure it comes into view

             // Optional: Add overlay or dim main content when sidebar is open on mobile
             // Example: mainContent.classList.toggle('opacity-50');
        });
    }

     // Optional: Close mobile sidebar when clicking outside of it
     document.addEventListener('click', (event) => {
        if (sidebar && !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
             // Only close if it's currently open (not fully translated-x)
            if (!sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                // Example: mainContent.classList.remove('opacity-50');
            }
        }
    });


    // Theme Toggle Logic (keep existing)
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon?.classList.remove('hidden');
    } else {
        themeToggleDarkIcon?.classList.remove('hidden');
    }

    const themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn?.addEventListener('click', function () {
        // toggle icons inside button
        themeToggleDarkIcon?.classList.toggle('hidden');
        themeToggleLightIcon?.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
</script>