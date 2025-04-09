<template>
    <transition name="fade">
      <div v-if="visible" class="notification" :class="type">
        <span>{{ message }}</span>
      </div>
    </transition>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const visible = ref(false);
  const message = ref("");
  const type = ref("");
  
  const showNotification = (msg, notificationType = "success") => {
    message.value = msg;
    type.value = notificationType;
    visible.value = true;
    
    setTimeout(() => {
      visible.value = false;
    }, 3000);
  };
  
  // Expose the function to the parent
  defineExpose({ showNotification });
  </script>
  
  <style scoped>
  .notification {
    position: fixed;
    bottom: 30px;
    right: 20px;
    z-index: 60;
    padding: 15px 20px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    animation: fadeInOut 3s ease-in-out;
  }
  
  .success { background-color: #4CAF50; color: white; }
  .error { background-color: #F44336; color: white; }
  
  @keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(20px); }
    10% { opacity: 1; transform: translateY(0); }
    90% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(20px); }
  }
  
  .fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
  }
  
  .fade-enter-from, .fade-leave-to {
    opacity: 0;
  }
  </style>
  