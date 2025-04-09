<template>
  <section class="text-white -mt-9">
    <div class="text-center py-12">
      <h1 class="text-4xl font-extrabold text-white mt-2">AI Generates Content in Seconds</h1>
      <p class="text-gray-400 mt-3 max-w-xl mx-auto">
        Give our AI a few descriptions, and we'll automatically create blog articles, product descriptions, and more for you within seconds.
      </p>
    </div>

    <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto px-6">
      <div 
        v-for="(card, index) in cards" 
        :key="index" 
        class="modern-card p-6 rounded-xl text-center border border-gray-700 relative"
      >
        <div class="border-animation"></div>
        <div class="flex justify-center items-center mb-4">
          <div :class="['p-3 rounded-xl', card.bgColor]">
            <i :class="[card.icon, ' text-2xl']"></i>
          </div>
        </div>
        <h3 class="text-xl font-bold">{{ card.title }}</h3>
        <p class="text-gray-400 mt-2">{{ card.description }}</p>
      </div>
    </div>

    <!-- Additional Box for 60+ More Features -->
    <div class="max-w-5xl mx-auto px-6 mt-8">
      <div class="modern-card p-6 rounded-xl text-center border border-gray-700 relative">
        <div class="border-animation -z-10"></div>
        <h3 class="text-xl font-bold">60+ More Features Await You</h3>
        <p class="text-gray-400 mt-2">Explore all the powerful tools and features our AI offers to supercharge your content creation.</p>
        <NuxtLink class="mt-4 px-6 inline-block py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors" to="/register">
          Get Started
        </NuxtLink>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue';

const cards = ref([
  { title: "Blog Post & Articles", description: "Generate optimized blog posts and articles to get organic traffic – making you visible to the world.", icon: "fas fa-book-reader", bgColor: "bg-blue-500" },
  { title: "Product Description", description: "Create a perfect description for your products to engage your customers to click and buy.", icon: "fas fa-th-list", bgColor: "bg-purple-500" },
  { title: "Social Media Ads", description: "Create ad copies for your social media – make an impact with your online marketing campaigns.", icon: "fab fa-facebook text-blue-400", bgColor: "bg-white " },
  { title: "Product Benefits", description: "Create a bullet point list of your product benefits that appeal to your customers to purchase.", icon: "fas fa-th-large", bgColor: "bg-blue-500" },
  { title: "Landing Page Content", description: "Write very attractive headlines, slogans or paragraph for your landing page of your website.", icon: "fas fa-columns", bgColor: "bg-purple-500" },
  { title: "Suggest Improvements", description: "Need to improve your existing content? Our AI will rewrite and improve the content for you.", icon: "fas fa-spinner", bgColor: "bg-pink-500" }
]);
</script>

<style scoped>
/* Card Style */
.modern-card {
  background: rgba(255, 255, 255, 0.02);
  border-radius: 12px;
  transition: transform 0.3s ease-in-out;
  position: relative;
  overflow: hidden;
}

/* Scaling Effect */
.modern-card:hover {
  transform: scale(1.05);
}

/* Border Animation Effect */
.border-animation {
  position: absolute;
  top: 0;
  left: 0;
  width: 0;
  height: 0;
  border: 2px solid transparent;
  border-radius: 12px;
  transition: all 0.5s ease-in-out;
}

.modern-card:hover .border-animation {
  width: 100%;
  height: 100%;
  border-color: #60a5fa;
  top: 0;
  left: 0;
  position: absolute;
}
</style>