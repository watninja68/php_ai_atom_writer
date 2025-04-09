<template>
  <section id="hero" class="flex flex-col md:flex-row items-center justify-center px-6 md:px-12 lg:px-20">
    <div class="flex-1 text-center md:text-left">
      <h1 class="text-3xl sm:text-4xl md:text-5xl text-white font-extrabold mb-6 md:h-36 h-32">
        <span v-html="typewriterText"></span>
        <span class="cursor">|</span>
      </h1>
      <p id="hero-subtitle" class="text-sm sm:text-base text-white mb-6 sm:mb-8 opacity-0">
        {{ heroText }}
      </p>
      <!--  rounded-full glow-button transition-all -->
      <div class=" flex md:justify-start justify-center">
        <NuxtLink id="hero-btn" class="px-6 sm:px-8 py-2 sm:py-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-lg opacity-0 flex items-center justify-center space-x-2 glow-button transition-all" to="/register">
          <span>Start Writing</span>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
              clip-rule="evenodd" />
          </svg>
        </NuxtLink>
      </div>
    </div>
    <div class="flex-1 flex justify-center md:justify-end mt-8 sm:mt-10 md:mt-0">
      <NuxtImg src="/images/aihero.png" alt="AI"  class="w-64 h-64 sm:w-80 sm:h-80 md:w-[450px] md:h-[450px] lg:w-[500px] lg:h-[500px]" />
     
    </div>
  </section>
</template>

<script setup>
import { useTypewriter } from '~/composables/useTypewriter';
import { onMounted, ref } from 'vue';
import { gsap } from 'gsap';

const heroText = `Elevate your brand's content strategy with AI-driven solutions.
                  By automating tasks such as keyword analysis, article research, creation, and evaluation, 
                  Creaitor enables you to produce tailored content, boost website traffic, and captivate your 
                  audience more effectively. This automation frees up your time, allowing you to concentrate on 
                  the strategic aspects of your brand's marketing efforts.`;

// Typewriter setup
const text = "Accelerate the creation of Brand-consistent Content.";
const cyanWord = "Brand-consistent";
const { typewriterText } = useTypewriter(text, cyanWord);

onMounted(() => {
  gsap.fromTo("#hero-btn",
    { opacity: 0, scale: 0.8 },
    { opacity: 1, scale: 1, duration: 1.5, delay: 0.9 }
  );
  gsap.fromTo("#hero-subtitle",
    { opacity: 0, y: -30 },
    { opacity: 1, y: 0, duration: 1.5, delay: 0.6 }
  );
});
</script>