<template>
    <section class="relative py-16 px-6 text-white">
      <div class="max-w-5xl mx-auto text-center md:text-left">
        <!-- Heading and Description -->
         <div class="md:flex justify-center">
             <h2 class="text-3xl flex-1 font-bold leading-tight">
               Set Your Content Marketing <br class="hidden md:block"> on Autopilot
             </h2>
             <p class="text-gray-400 flex-1 ">
               Let technology handle the routine so you can turn your attention to the ideas and strategies that drive success.
               AI makes it easier to focus on what matters most.
             </p>
         </div>
  
        <!-- Stats Section -->
        <div class="mt-12 flex flex-col md:flex-row justify-between items-center gap-8 md:gap-0">
          <div class="text-center md:text-left">
            <h3 class="text-5xl font-bold text-green-400 animate-glow">10x</h3>
            <p class="text-gray-400 mt-2">Faster content creation</p>
          </div>
  
          <div class="w-px border h-14 bg-gray-600 hidden md:block"></div>
  
          <div class="text-center md:text-left">
            <h3 class="text-5xl font-bold text-green-400 animate-glow">70%</h3>
            <p class="text-gray-400 mt-2">Higher productivity</p>
          </div>
  
          <div class="w-px border h-14 bg-gray-600 hidden md:block"></div>
  
          <div class="text-center md:text-left">
            <h3 class="text-5xl font-bold text-green-400 animate-glow">3x</h3>
            <p class="text-gray-400 mt-2">Organic traffic increase</p>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <style scoped>
  /* Subtle Glow Effect for Futuristic Look */
  @keyframes glow {
  0% { text-shadow: 0 0 3px #22c55e, 0 0 6px rgba(34, 197, 94, 0.5); }
  50% { text-shadow: 0 0 5px #22c55e, 0 0 8px rgba(34, 197, 94, 0.3); }
  100% { text-shadow: 0 0 3px #22c55e, 0 0 6px rgba(34, 197, 94, 0.5); }
}
  
  .animate-glow {
    animation: glow 2s infinite alternate;
  }
  </style>
  