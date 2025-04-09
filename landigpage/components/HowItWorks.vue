<template>
    <section class="bg-gray-800 text-white py-16 px-8">
      <div class="text-center">
        <button class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm hover:shadow-lg transition-all">
          How it works
        </button>
        <h2 class="text-4xl font-bold mt-6">
          Effective step-by-step optimization
        </h2>
        <p class="text-gray-400 mt-4 max-w-2xl mx-auto">
          Optimize your content quickly and efficiently with clear tips, a clear content index, a practical checklist, and keyword analysis. Step-by-step suggestions for improving them will help you achieve better results and higher rankings in search results.
        </p>
      </div>
  
      <!-- Connected Cards -->
      <div class="flex flex-col md:flex-row justify-center items-center mt-12 gap-0 relative">
        <!-- Step 1 -->
        <div class="bg-gray-800/50 backdrop-blur-md p-8 rounded-l-xl w-full md:w-1/3 shadow-lg border border-gray-700/30 hover:border-blue-500/50 transition-all">
          <h3 class="text-xl font-semibold">
            Create your account <span class="ml-2 px-3 py-1 text-sm bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full">STEP 1</span>
          </h3>
          <p class="text-gray-400 mt-4">Sign up and start using our platform today. Enjoy full access for 7 days with a free trial.</p>
          <div class="flex justify-end mt-6">
            <i class="fas fa-chevron-right text-blue-500 text-2xl"></i>
          </div>
        </div>
  
        <!-- Step 2 -->
        <div class="bg-gray-800/50 backdrop-blur-md p-8 w-full md:w-1/3 shadow-lg border border-gray-700/30 hover:border-blue-500/50 transition-all">
          <h3 class="text-xl font-semibold">
            Analyze keywords <span class="ml-2 px-3 py-1 text-sm bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full">STEP 2</span>
          </h3>
          <p class="text-gray-400 mt-4">Submit your target keyword and quickly uncover your competitors’ strengths.</p>
          <div class="flex justify-end mt-6">
            <i class="fas fa-chevron-right text-blue-500 text-2xl"></i>
          </div>
        </div>
  
        <!-- Step 3 -->
        <div class="bg-gray-800/50 backdrop-blur-md p-8 rounded-r-xl w-full md:w-1/3 shadow-lg border border-gray-700/30 hover:border-blue-500/50 transition-all">
          <h3 class="text-xl font-semibold">
            Build your content <span class="ml-2 px-3 py-1 text-sm bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full">STEP 3</span>
          </h3>
          <p class="text-gray-400 mt-4">Use the suggested keywords to build your content, optimizing it for search engines to achieve top rankings!</p>
          <div class="flex justify-end mt-6">
            <i class="fas fa-chevron-right text-blue-500 text-2xl"></i>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  // No script changes needed for FontAwesome icons in <i> tag format
  </script>
  
  <style scoped>
  /* Glowing hover effect */
  .bg-gray-800\/50:hover {
    box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
  }
  
  /* Gradient text */
  .text-gradient {
    background: linear-gradient(45deg, #3b82f6, #9333ea);
    -webkit-text-fill-color: transparent;
  }
  
  /* Smooth transitions */
  .transition-all {
    transition: all 0.3s ease-in-out;
  }
  </style>