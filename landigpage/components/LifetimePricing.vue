<template>
    <section class="min-h-screen">
      <div class="max-w-4xl w-full mx-auto py-16 text-center">
        <h2 class="md:text-4xl text-2xl font-bold text-white mb-4">
          Get your <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-500">Lifetime</span> Deal!
        </h2>
        <p class="mt-4 text-xl text-gray-400">
          Lifetime plans offer a one-time payment for unlimited access, ensuring long-term value without recurring fees.
        </p>
      </div>
      <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-6">
        <div @mouseenter="animateList(index)"
          v-for="(plan, index) in plans"
          :key="index"
          class="bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl border border-gray-200 hover:border-blue-500 transition-all duration-300"
        >
          <!-- Plan Name -->
          <h3 class="text-2xl font-semibold text-gray-200">{{ plan.name }}</h3>
  
          <!-- Plan Description -->
          <p class="text-gray-200 text-sm mb-6">{{ plan.description }}</p>
  
          <!-- Plan Price -->
          <p class="text-4xl font-bold text-gray-200">
            ${{ plan.price }} <span class="text-sm text-gray-400">/ Lifetime</span>
          </p>
  
          <!-- Features List -->
          <ul :ref="el => listRefs[index] = el" class="mt-6 space-y-3">
            <li
              v-for="(feature, i) in plan.features"
              :key="i"
              class="flex items-center text-gray-200"
            >
              <!-- Custom Icon -->
              <svg
                class="w-5 h-5 text-blue-500 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 13l4 4L19 7"
                ></path>
              </svg>
              {{ feature }}
            </li>
          </ul>
  
          <!-- CTA Button -->
          <button 
            class="mt-8 w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 glow-button text-white font-semibold py-3 rounded-lg transition-all duration-300 hover:scale-105"
          >
            Get Started
          </button>
        </div>
      </div>
    </section>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import gsap from 'gsap';
  const plans = [
    {
      name: "Bronze Plan",
      price: 89,
      description: "For business owners improving rankings",
      features: [
        "2 projects/folders",
        "25 content writer analyses",
        "15,000 AI credits",
        "Standard AI templates",
        "Content plan",
        "Content sharing (Read only)",
      ],
    },
    {
      name: "Silver Plan",
      price: 178,
      description: "For a copywriter delivering outstanding results to clients",
      features: [
        "5 projects/folders",
        "50 content writer analyses",
        "30,000 AI credits",
        "Standard AI templates",
        "Content plan",
        "Content sharing (Read only)",
      ],
    },
    {
      name: "Diamond Plan",
      price: 445,
      description: "For a larger business working on several domains",
      features: [
        "50 projects/folders",
        "150 content writer analyses",
        "75,000 AI credits",
        "Advanced + Custom AI templates",
        "Content Designer (one-click articles)",
        "Content plan + New ideas",
        "Content sharing with unlimited team members (Create, Edit, Read)",
        "150 Plagiarism checks",
        "Integrations: GSC, WP, Shopify",
        "Content management",
        "Own OpenAI key",
        "Neuron API",
      ],
    },
  ];

  const listRefs = ref([]);

const animateList = (index) => {
    gsap.fromTo(
        listRefs.value[index].children, 
        { opacity: 0, x: -10 },
        { opacity: 1, x: 0, stagger: 0.1, duration: 0.5 }
    );
};

onMounted(() => {
    listRefs.value.forEach((list) => {
        gsap.set(list.children, { opacity: 1, x: -5 });
    });
});
  </script>
  
  <style scoped>
  /* Hover Scale Effect */
  button:hover {
    transform: scale(1.05);
  }
  </style>