<template>
    <div class="text-white pt-7 relative bg-gradient-to-br from-gray-900 to-gray-800 ">
        <Navbar />
        <div class="px-2 md:px-0 mt-20">
            <TermsAndCondition />
        </div>
      
        <Footer />
    </div>
</template>

<script setup>
// Add SEO meta tags
useHead({
  title: "AppName - Terms and condition",
  meta: [
    {
      name: "description",
      content: "Read the terms and conditions for using AI Future's website and services.",
    },
  ],
});
</script>