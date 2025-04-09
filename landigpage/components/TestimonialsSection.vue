<template>
  <section class="py-16">
    <div class="max-w-5xl mx-auto px-6 text-center">
      <h2 class="text-4xl font-extrabold text-gray-100  animate-gradient">
        Logo Testimonials
      </h2>
      <p class="mt-4 text-gray-400">
        Discover what our customers are saying about us.
      </p>
    </div>
    <div class="mt-10 flex flex-wrap justify-center gap-6">
      <div
        v-for="(testimonial, index) in testimonials"
        :key="index"
        class="max-w-md p-8 bg-gray-800/50 backdrop-blur-md rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-500 hover:scale-105 border border-gray-700/30 relative overflow-hidden"
      >
        <!-- Glowing Border Effect -->
        <div class="absolute inset-0 rounded-2xl border-2 border-transparent hover:border-green-400/50 transition-all duration-500"></div>
        
        <!-- Star Rating -->
        <div class="flex items-center mb-4">
          <div class="flex space-x-1 text-yellow-400">
            <span v-for="n in 5" :key="n">★</span>
          </div>
        </div>

        <!-- Testimonial Text -->
        <p class="text-lg text-gray-300">
          {{ testimonial.text }}
        </p>

        <!-- Author Details -->
        <div class="mt-6 flex items-center">
          <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-400 to-blue-500 p-1">
            <div class="w-full h-full bg-gray-900 rounded-full"></div>
          </div>
          <div class="ml-4 text-left">
            <p class="font-semibold text-white">{{ testimonial.name }}</p>
            <p class="text-sm text-gray-400">{{ testimonial.role }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const testimonials = [
  {
    text: "Our experience with Creatior.ai has been nothing short of amazing. The AI tools and SEO suite have revolutionized our content creation process.",
    name: "Tina van Bommel",
    role: "SEO Consultant",
  },
  {
    text: "Using Creatior.ai has significantly improved our search engine rankings and boosted our organic traffic. Highly recommended!",
    name: "Urs Stadelmann",
    role: "Sales Representative",
  },
];
</script>

<style scoped>
/* Animated Gradient Text */
.animate-gradient {
  background-size: 150% 150%;
  animation: gradient 5s ease infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

/* Glowing Hover Effect */
.hover\:shadow-3xl:hover {
  box-shadow: 0 0 1px rgba(74, 222, 128, 0.3), 0 0 80px rgba(96, 165, 250, 0.2);
}
</style>