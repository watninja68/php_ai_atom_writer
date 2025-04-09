export default defineNuxtConfig({
  modules: ['@nuxtjs/tailwindcss', '@nuxt/image'],
  css: ['~/assets/css/main.css', '@fortawesome/fontawesome-free/css/all.min.css'],

  app: {
    head: {
      viewport: 'width=device-width, initial-scale=1',
      title: 'AI Content Landing Page',
      script: [
        { src: 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js' },
        { src: 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollToPlugin.min.js' }
      ],
      link: [
        {
          rel: "stylesheet",
          href: "https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Sofadi+One&family=Source+Code+Pro:ital,wght@0,200..900;1,200..900&family=Teko:wght@300..700&display=swap",
        },
      ],
    }
  },

  compatibilityDate: '2025-02-24'
});