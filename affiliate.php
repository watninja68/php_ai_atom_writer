<?php
// Include the Auth0 handler - this also handles session_start() safely
require_once __DIR__ . '/auth0_handler.php';

// Use the function from the handler to check authentication
if (!isAuthenticated()) {
    // Optional: Store the intended destination
    // $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI']; // Uncomment if you want redirect back after login
    header('Location: login.php');
    exit;
}

// If authenticated, the script continues...
// Example: Get user info if needed
$userName = $_SESSION['user_name'] ?? 'User';
$userEmail = $_SESSION['user_email'] ?? '';
$userId = $_SESSION['user_id'] ?? null; // Your internal DB user ID

?>
<?php $pageTitle = "Affiliate"; ?>
<?php require_once 'layout/header.php'; ?>

  <div class="flex flex-col md:flex-row">

   <!-- Sidebar -->
        <?php require_once 'layout/sidebar.php'; ?>

    <!-- Main Content -->
    <main id="mainContent" class="main-content flex-1 md:ml-64 md:p-6">
      <!-- Header -->
      <?php require_once 'layout/main-header.php'; ?> 

      <!-- Breadcrumb -->
      <nav class="flex justify-between px-2" aria-label="Breadcrumb">
        <ol class="inline-flex self-start items-center space-x-1 md:space-x-2">
          <li>
            <div class="flex items-center">
              <i class="fas fa-chevron-right dark:text-black text-gray-400"></i>
              <a href="#" class="ml-2 text-sm font-medium dark:text-black text-gray-300 hover:text-white">
                Affiliate</a>
            </div>
          </li>
        </ol>
        <!-- Withdrawal Button -->
        <div class="text-center">
          <button
                    class="bg-cyan-500/80 px-4 py-2 cursor-pointer dark:text-white rounded-lg hover:bg-cyan-400/80 transition-all duration-300 glow">
                    Request Withdrawal</button>
        </div>
      </nav>

      <!-- Main Section -->
      <div class=" p-6 ">
        <!-- Header -->
        <div class=" mb-8">
          <h1 class="text-2xl font-bold">
            Affiliate Dashboard
          </h1>
          <p class="text-gray-400 dark:text-black">Track your affiliate performance and earnings in real-time.</p>
        </div>

        <!-- Unique Referral Link -->
        <div class="flex justify-end">
          <div class="mb-8 md:w-1/2">
            <label for="referral-link" class="block text-sm font-medium text-gray-300 dark:text-black ">Your Unique
              Referral Link</label>
            <div class="mt-1 flex rounded-lg shadow-sm">
              <input type="text" id="referral-link" value="https://ourtogloom.com/ef-username" readonly
                class="flex-1 p-3 rounded-l-lg bg-gray-800/50 dark:text-white border border-gray-700/50 focus:outline-none focus:ring-2 focus:ring-cyan-400 transition-all duration-300 placeholder:text-gray-400">
              
                <button onclick="copyReferralLink()"
                class="bg-cyan-500/80 px-4 py-3 cursor-pointer rounded-r-lg text-white dark:text-white hover:bg-cyan-400/80  ">
                Copy Link
              </button>

            </div>
          </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

          <!-- Affiliate Sales -->
          <div class="card bg-gray-800 p-6 text-center rounded-lg shadow">
            <i class="fas fa-chart-line text-2xl text-cyan-400"></i>
            <h3 class="mt-4 text-base font-semibold">Affiliate Sales</h3>
            <p class="mt-2 text-xl font-bold">1,234</p>
          </div>
          <!-- Refunds -->
          <div class="card bg-gray-800 p-6 text-center rounded-lg shadow">
            <i class="fas fa-undo text-2xl text-cyan-400"></i>
            <h3 class="mt-4 text-base font-semibold">Refunds</h3>
            <p class="mt-2 text-xl font-bold">56</p>
          </div>

          <!-- Total Earnings -->
          <div class="card bg-gray-800 p-6 text-center rounded-lg shadow">
            <i class="fas fa-wallet text-2xl text-cyan-400"></i>
            <h3 class="mt-4 text-base font-semibold">Total Earnings</h3>
            <p class="mt-2 text-xl font-bold">$12,345</p>
          </div>

          <!-- Available for Withdrawal -->
          <div class="card bg-gray-800 p-6 text-center rounded-lg shadow">
            <i class="fas fa-hand-holding-usd text-2xl text-cyan-400"></i>
            <h3 class="mt-4 text-base font-semibold">Available for Withdrawal</h3>
            <p class="mt-2 text-xl font-bold">$8,765</p>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="p-6 rounded-lg">
          <h2 class="text-xl font-semibold mb-4">Recent Activity</h2>
          <div class="space-y-4">
            <!-- Activity Item -->
            <div class="flex items-center justify-between dark:bg-white p-4 bg-gray-800/50 rounded-lg">
              <div class="flex items-center space-x-4">
                <i class="fas fa-shopping-cart text-cyan-400"></i>
                <div>
                  <p class="text-sm">New sale via referral link</p>
                  <p class="text-xs dark:text-black text-gray-400">2 hours ago</p>
                </div>
              </div>
              <p class="text-sm font-semibold">+$50</p>
            </div>

            <!-- Activity Item -->
            <div class="flex items-center justify-between dark:bg-white p-4 bg-gray-800/50 rounded-lg">
              <div class="flex items-center space-x-4">
                <i class="fas fa-undo text-cyan-400"></i>
                <div>
                  <p class="text-sm">Refund processed</p>
                  <p class="text-xs dark:text-black text-gray-400">1 day ago</p>
                </div>
              </div>
              <p class="text-sm font-semibold text-red-400">-$25</p>
            </div>

            <!-- Activity Item -->
            <div class="flex items-center justify-between dark:bg-white p-4 bg-gray-800/50 rounded-lg">
              <div class="flex items-center space-x-4">
                <i class="fas fa-hand-holding-usd text-cyan-400"></i>
                <div>
                  <p class="text-sm">Withdrawal request processed</p>
                  <p class="text-xs dark:text-black text-gray-400">3 days ago</p>
                </div>
              </div>
              <p class="text-sm font-semibold">-$1,000</p>
            </div>
          </div>
        </div>


      </div>


    </main>
  </div>

  <?php require_once 'layout/footer.php'; ?>