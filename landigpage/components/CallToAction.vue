<template>
    <section class="relative flex justify-center items-center py-16 px-6">
      <!-- Background Grid Pattern -->
      <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
  
      <!-- Content Card -->
      <div class="relative bg-white/10 backdrop-blur-xl border border-white/20 shadow-lg rounded-2xl p-10 w-full max-w-5xl text-center">
        <p class="text-sm font-semibold tracking-wider text-blue-400 uppercase">Boost Your Writing Productivity</p>
        <h1 class="text-4xl font-bold text-white mt-3">End writer’s block today</h1>
        <p class="text-gray-300 mt-3">
          It’s like having access to a team of copywriting experts writing powerful copy for you in 1-click.
        </p>
  
        <!-- CTA Button -->
        <NuxtLink class="mt-6 inline-block bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 px-6 rounded-lg text-lg font-semibold shadow-lg transition-transform transform hover:scale-105" to="/register">
            Start writing for free →
        </NuxtLink>
  
        <!-- Features List -->
        <div class="flex flex-col md:flex-row justify-center md:items-center pl-4 md:pl-0 gap-4 mt-6 text-gray-400 text-sm">
          <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-400"></i> No credit card required</span>
          <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-400"></i> Cancel anytime</span>
          <span class="flex items-center gap-2"><i class="fas fa-check-circle text-green-400"></i> 10+ tools to explore</span>
        </div>
      </div>
    </section>
  </template>
  <script setup>
</script>
  <style scoped>
  /* Background Grid Pattern */
  .bg-grid-pattern {
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 1px, transparent 1px);
    background-size: 20px 20px;
  }
  </style>
  