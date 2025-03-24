<?php $pageTitle = "Support"; ?>
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
      <div class="p-6">
        <div class=" mb-8">
          <h1 class="text-2xl font-bold">
            Support Ticket System
          </h1>
          <p class="text-gray-400 dark:text-black">You can reach out to us through our Support system.</p>
        </div>

        <div class="flex flex-col gap-3 md:gap-0 md:flex-row md:justify-between">


          <!-- Ticket Creation Form -->
          <div
            class=" bg-white/10 dark:from-gray-400/10 dark:to-transparent p-6 rounded-lg shadow-lg transform hover:scale-105 transition duration-300 ease-in-out"
            style="animation: glow 1.5s infinite alternate;">
            <h2 class="text-xl font-semibold mb-4">Create a New Ticket</h2>
            <form class="space-y-4">
              <input type="text" placeholder="Title"
                class="w-full p-2 bg-gray-700 dark:bg-gray-600 border dark:text-white border-gray-600 rounded-md focus:ring-2 focus:ring-cyan-400 focus:outline-none">
              <textarea placeholder="Describe your issue"
                class="w-full p-2 bg-gray-700 dark:bg-gray-600 border dark:text-white border-gray-600 rounded-md focus:ring-2 focus:ring-cyan-400 focus:outline-none"></textarea>
              <button type="submit"
                class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2 rounded-lg font-bold">Submit Ticket</button>
            </form>
          </div>

          <!-- Previously Created Tickets -->
          <div class=" bg-white/10 dark:from-gray-400/10 dark:to-transparent rounded-lg p-6 shadow-md"
            style="animation: glow 1.5s infinite alternate;">
            <h2 class="text-xl font-semibold mb-4">Your Tickets</h2>
            <div class="space-y-3">
              <div
                class="flex items-center gap-x-4 justify-between dark:bg-white p-4 bg-gray-800/50 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                <div class="flex items-center space-x-4">
                  <i class="fas fa-ticket-alt text-green-400 text-lg"></i>
                  <div>
                    <p class="text-lg">Issue with Login</p>
                    <p class="text-sm dark:text-black text-gray-400">Submitted on: 2025-02-19</p>
                  </div>
                </div>
                <p class="text-sm font-semibold text-green-400">open</p>
              </div>

              <div
                class="flex items-center gap-x-4 justify-between dark:bg-white p-4 bg-gray-800/50 rounded-lg transition duration-200 ease-in-out transform hover:scale-105">
                <div class="flex items-center space-x-4">
                  <i class="fas fa-times-circle text-red-400 text-lg"></i>  
                  <div>
                    <p class="text-lg">Payment Not Processing</p>
                    <p class="text-sm dark:text-black text-gray-400">Submitted on: 2025-02-18</p>
                  </div>
                </div>
                <p class="text-sm font-semibold text-red-400">Close</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </main>
  </div>
  <?php require_once 'layout/footer.php'; ?>
