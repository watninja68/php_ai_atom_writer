<?php
session_start();

if (!isset($_SESSION['google_loggedin'])) {
    header('Location: login.php');
    exit;
}

?>
<?php $pageTitle = "Contact Us"; ?>
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
            <!-- Header -->
            <div class="p-6 mb-8">
                <h1 class="text-2xl font-bold"> Contact Us</h1>
                <p class="mt-2 text-gray-300 dark:text-black">We'd love to hear from you! Reach out to us for any
                    inquiries or feedback.
                </p>
            </div>
            <!-- Main Page -->
            <div
                class="grid grid-cols-1 gap-8 md:grid-cols-2 bg-white/10 dark:from-gray-400/10 dark:to-transparent w-full p-5 text-white">


                <!-- Contact Form -->
                <div class=" bg-white/10 dark:from-gray-400/10 dark:to-transparent rounded-lg p-6 shadow-md"
                    style="animation: glow 1.5s infinite alternate;">

                    <form class="space-y-6">
                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 dark:text-black">
                                Name</label>
                            <input type="text" id="name" name="name" required
                                class="mt-1 w-full bg-gray-700 dark:bg-gray-600 border dark:text-white border-gray-600 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400 "
                                placeholder="John Doe">
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 dark:text-black">
                                Email</label>
                            <input type="email" id="email" name="email" required
                                class="mt-1 w-full p-3 bg-gray-700 dark:bg-gray-600 border dark:text-white border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"
                                placeholder="johndoe@example.com">
                        </div>

                        <!-- Message Input -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 dark:text-black">
                                Message</label>
                            <textarea id="message" name="message" rows="5" required
                                class="mt-1 w-full p-3 bg-gray-700 dark:bg-gray-600 border dark:text-white border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400"
                                placeholder="Write your message here..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit"
                                class="bg-cyan-500/80 w-full px-4 py-2 dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
                                Send Message</button>
                        </div>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-5 flex flex-col items-center">
                    <!-- Email -->
                    <div class=" rounded-lg  text-center transition duration-200 ease-in-out transform hover:scale-105">
                        <i class="fas fa-envelope text-xl text-cyan-400"></i>
                        <h3 class="mt-2 text-lg font-semibold dark:text-black">Email</h3>
                        <p class="mt-1 text-gray-300 dark:text-black">support@example.com</p>
                    </div>
                    <hr class="dark:border-black w-1/2 " />
                    <!-- Phone -->
                    <div class=" rounded-lg text-center transition duration-200 ease-in-out transform hover:scale-105">
                        <i class="fas fa-phone text-xl text-cyan-400"></i>
                        <h3 class="mt-2 text-lg font-semibold dark:text-black">Phone</h3>
                        <p class="mt-1 text-gray-300 dark:text-black">+1 (123) 456-7890</p>
                    </div>
                    <hr class="dark:border-black w-1/2 " />
                    <!-- Address -->
                    <div class=" rounded-lg text-center transition duration-200 ease-in-out transform hover:scale-105">
                        <i class="fas fa-map-marker-alt text-xl text-cyan-400"></i>
                        <h3 class="mt-2 text-lg font-semibold dark:text-black">Address</h3>
                        <p class="mt-1 text-base text-gray-300 dark:text-black">123 Futuristic St, Tech City, World</p>
                    </div>
                </div>
            </div>


        </main>
    </div>
    <?php require_once 'layout/footer.php'; ?>