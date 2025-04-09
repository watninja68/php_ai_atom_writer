<template>
  <nav class="navbar w-11/12 bg-gray-800/50 backdrop-blur-md mx-auto flex gap-x-10 justify-between items-center rounded-full p-2 relative border border-gray-700/30 hover:border-blue-500/50 transition-all">
    <!-- Logo with Floating Animation -->
    <h2 class="text-xl mx-2 md:ml-5 font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500 animate-float">
      Logo
    </h2>

    <!-- Desktop Menu -->
    <div class="hidden md:flex items-center">
      <!-- <NuxtLink class="nav-link text-gray-300 hover:text-white transition-all relative group" to="/">
        Resources
        <span class="nav-underline"></span>
      </NuxtLink> -->
      <NuxtLink class="nav-link text-gray-300 hover:text-white transition-all relative group" to="https://atomwriter.com/paddle.php">
        Pricing
        <span class="nav-underline"></span>
      </NuxtLink>
      <NuxtLink class="nav-link text-gray-300 hover:text-white transition-all relative group" to="/contact">
        Contact us
        <span class="nav-underline"></span>
      </NuxtLink>
      <a class="mx-5 px-4 py-2 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white ml-4 transition-all" href="/login">
        Login
      </a>
      <a class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white font-semibold rounded-full glow-button transition-all"
        href="/register">
        Get Started
      </a>
    </div>

    <!-- Mobile Menu Toggle -->
    <button @click="toggleMenu" class="md:hidden text-gray-300 focus:outline-none">
      <svg v-if="!isMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
      <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Mobile Menu with Slide-In Animation -->
    <div v-if="isMenuOpen" class="mobile-menu">
      <NuxtLink v-for="link in mobileLinks" :key="link.id" class="mobile-nav-link text-lg text-gray-700 hover:text-blue-500 mb-2 transition-all"
        :to="link.target" @click="toggleMenu">
        {{ link.label }}
      </NuxtLink>
    </div>
  </nav>
</template>

<script setup>
import { ref } from "vue";

const isMenuOpen = ref(false);

const mobileLinks = [
  { id: 1, label: "Home", target: "/" },
  { id: 2, label: "Pricing", target: "/pricing" },
  { id: 3, label: "Contact", target: "/contact" },
];

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>

<style scoped>
.navbar {
  position: sticky;
  top: 0;
  left: 0;
  width: 91.666667%;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  z-index: 1000;
}

.nav-link {
  margin: 0 15px;
  cursor: pointer;
  transition: color 0.3s ease-in-out;
  position: relative;
}

.nav-link:hover {
  color: #fff;
}

/* Glowing Underline Animation */
.nav-underline {
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 0;
  height: 2px;
  background: linear-gradient(to right, #3b82f6, #9333ea);
  transition: width 0.3s ease-in-out;
}

.nav-link:hover .nav-underline {
  width: 100%;
}

.mobile-nav-link:hover {
  color: #3b82f6;
}

/* Mobile menu styles */
.mobile-menu {
  position: absolute;
  top: 60px;
  right: 0;
  left: 0;
  z-index: 50;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  padding: 10px;
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  animation: slide-in 0.3s ease-in-out;
}

.mobile-menu a {
  padding: 12px;
  text-align: left;
  display: block;
}



/* Smooth transitions */
.transition-all {
  transition: all 0.3s ease-in-out;
}

/* Floating Animation for Logo */
@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-5px);
  }
}

.animate-float {
  animation: float 3s ease-in-out infinite;
}

/* Slide-In Animation for Mobile Menu */
@keyframes slide-in {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>