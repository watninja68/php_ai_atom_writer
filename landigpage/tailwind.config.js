module.exports = {
    content: [
      "./components/**/*.{js,vue,ts}",
      "./layouts/**/*.vue",
      "./pages/**/*.vue",
      "./plugins/**/*.{js,ts}",
      "./nuxt.config.{js,ts}",
    ],
    theme: {
      extend: {
        colors: {
          cyan: {
            500: '#06b6d4',
            600: '#0891b2',
          },
          gray: {
            700: '#374151',
            800: '#1f2937',
            900: '#111827',
          }
        }
      },
    },
    plugins: [],
  }