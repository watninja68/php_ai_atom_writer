 <!-- Header Section -->
 <header class="sticky top-0 z-40 w-full bg-[rgba(30,41,59,0.7)] backdrop-blur-md border-b border-[rgba(255,255,255,0.1)] p-4 rounded-xl mb-6 flex justify-between items-center dark:bg-[rgba(255,255,255,0.7)] dark:border-b dark:border-[rgba(0,0,0,0.1)]">
    <!-- Hamburger Menu for Mobile -->
    <button id="menu-button" onclick="toggleSidebar()" class="md:hidden bg-cyan-500 px-4 py-2 rounded glow">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Greeting -->
    <div
        class="flex flex-col md:flex-row md:items-center md:gap-2 justify-center">
        <p class="text-gray-300 text-xs md:text-sm dark:text-black ">Remaining characters credits</p>
        <p class="text-lg font-bold">Unlimited</p>
    </div>

    <!-- Right Side: Toggle and Profile -->
    <div class="flex items-center space-x-4">
        <!-- Dark/Light Mode Toggle -->
        <div class="relative inline-block w-10 mr-2 align-middle select-none">
            <input type="checkbox" name="toggle" id="toggle"
                class="absolute block w-6 h-6 peer checked:right-0 rounded-full bg-white dark:bg-cyan-500 border-4 border-gray-300 appearance-none cursor-pointer"
                onclick="toggleDarkMode()" />
            <label for="toggle"
                class="toggle-label block overflow-hidden peer-checked:text-bg-900 h-6 rounded-full bg-gray-300 cursor-pointer"></label>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button id="profile-button" onclick="toggleProfileDropdown()"
                class="bg-cyan-500 px-4 py-2 rounded-full glow">
                <i class="fas fa-user"></i>
            </button>
            <div id="profile-dropdown"
                class="profile-dropdown hidden absolute right-0 mt-2 w-48 rounded-lg shadow-lg">
                <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700"><i
                        class="fas fa-user mr-2"></i>Profile</a>
                <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700"><i
                        class="fas fa-cog mr-2"></i>Settings</a>
                <a href="#" class="block px-4 py-2 text-gray-300 hover:bg-gray-700"><i
                        class="fas fa-sign-out-alt mr-2"></i>Logout</a>
            </div>
        </div>
    </div>
</header>