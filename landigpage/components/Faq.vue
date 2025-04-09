<template>
    <div class="max-w-4xl mx-auto p-8">
      <h2 class="text-4xl text-gray-200 font-bold text-center mb-8">Frequently Asked Questions</h2>
  
      <div v-for="(faq, index) in faqs" :key="index" class="border-b border-gray-300">
        <button
          @click="toggleFaq(index)"
          class="w-full flex justify-between items-center py-5 text-left text-white font-semibold focus:outline-none"
        >
          <span class="text-gray-100 text-lg">{{ faq.question }}</span>
          <span
            class="text-blue-600 font-bold transform transition-transform duration-300"
            :class="{ 'rotate-45': activeIndex === index }"
          >
            +
          </span>
        </button>
  
        <div
          ref="faqContent"
          class="overflow-hidden transition-[max-height] duration-300 ease-in-out"
          :style="{ maxHeight: activeIndex === index ? faqHeights[index] + 'px' : '0px' }"
        >
          <p class="text-gray-200 pb-4">{{ faq.answer }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, nextTick, defineProps, watch } from 'vue';
  
  const props = defineProps({
    faqs: {
      type: Array,
      required: true
    }
  });
  
  const activeIndex = ref(null);
  const faqHeights = ref([]);
  const faqContent = ref([]);
  
  const toggleFaq = async (index) => {
    if (activeIndex.value === index) {
      activeIndex.value = null;
    } else {
      activeIndex.value = index;
      await nextTick();
      faqHeights.value[index] = faqContent.value[index]?.scrollHeight || 0;
    }
  };
  
  // Reset heights if new FAQ data is provided
  watch(() => props.faqs, (newFaqs) => {
    faqHeights.value = Array(newFaqs.length).fill(0);
  }, { immediate: true });
  
  onMounted(() => {
    faqHeights.value = Array(props.faqs.length).fill(0);
  });
  </script>
  
  <style>
  .rotate-45 {
    transform: rotate(45deg);
  }
  </style>
  