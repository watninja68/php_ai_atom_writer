<template>
    <section class="relative py-16 px-6 md:px-12 lg:px-24">
          <!-- Animated Gradient Overlay -->
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_rgba(255,255,255,0.1),_transparent)]"></div>
      <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        <!-- Left Side -->
        <div class="fade-in">
          <span class="inline-block bg-gray-500/10 text-gray-200 px-4 py-1 rounded-full text-sm font-medium mb-4 backdrop-blur-md shadow-md">
            Advanced SEO Tools
          </span>
          <h2 class="text-4xl font-extrabold text-white leading-tight">
            A powerful <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500">SEO-enhancing</span> platform
          </h2>
          <p class="text-gray-400 mt-4">
            Streamline your content strategy with tools designed to analyze, suggest, and optimize keywords specifically for Google search engines.
          </p>
        </div>
        
        <!-- Right Side -->
        <div class="space-y-6">
          <div class="flex items-start space-x-4 hover:bg-gray-700 p-4 rounded-lg transition-colors duration-300">
            <div class="bg-gray-200 dark:bg-gray-800 px-3 py-1 rounded-xl">
              <img src="/icons/chart.svg" alt="Quality scores" class="w-10 h-10" />
            </div>
            <div>
              <h3 class="text-lg font-semibold text-white">Quality scores</h3>
              <p class="text-gray-400">
                Earn higher content scores and optimize your SEO efforts with precise planning and advanced features.
              </p>
            </div>
          </div>
          
          <div class="flex items-start space-x-4 hover:bg-gray-700 p-4 rounded-lg transition-colors duration-300">
            <div class="bg-gray-200 dark:bg-gray-800 px-3 py-1 rounded-xl">
              <img src="/icons/clock.svg" alt="Time saving" class="w-10 h-10" />
            </div>
            <div>
              <h3 class="text-lg font-semibold text-white">Time saving</h3>
              <p class="text-gray-400">
                Save time on content creation with AI by defining key stages and focusing on what truly matters.
              </p>
            </div>
          </div>
          
          <div class="flex items-start space-x-4 hover:bg-gray-700 p-4 rounded-lg transition-colors duration-300">
            <div class="bg-gray-200 dark:bg-gray-800 px-3 py-1 rounded-xl">
              <img src="/icons/team.svg" alt="Management help" class="w-10 h-10" />
            </div>
            <div>
              <h3 class="text-lg font-semibold text-white">Management help</h3>
              <p class="text-gray-400">
                Plan, coordinate, and monitor teamwork to achieve goals faster and more effectively.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  // No script logic needed for this component
  </script>
  
  <style scoped>
  /* Animations */
  .fade-in {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.8s ease-out forwards;
  }
  
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  </style>
  