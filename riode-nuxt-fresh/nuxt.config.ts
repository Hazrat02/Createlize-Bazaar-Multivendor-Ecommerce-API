// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  devtools: { enabled: true },
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8000/api/v2'
    }
  },
  app: {
    head: {
      title: 'Riode - Ultimate eCommerce Template',
      base: { href: '/' },
      meta: [
        { charset: 'utf-8' },
        { name: 'viewport', content: 'width=device-width, initial-scale=1.0, minimum-scale=1.0' },
        { name: 'keywords', content: 'HTML5 Template' },
        { name: 'description', content: 'Riode - Ultimate eCommerce Template' },
        { name: 'author', content: 'D-THEMES' }
      ],
      link: [
        { key: 'favicon', rel: 'icon', type: 'image/png', href: '/images/icons/favicon.png' },
        { rel: 'preload', href: '/fonts/riode115b.ttf', as: 'font', type: 'font/ttf', crossorigin: 'anonymous' },
        { rel: 'preload', href: '/vendor/fontawesome-free/webfonts/fa-solid-900.woff2', as: 'font', type: 'font/woff2', crossorigin: 'anonymous' },
        { rel: 'preload', href: '/vendor/fontawesome-free/webfonts/fa-brands-400.woff2', as: 'font', type: 'font/woff2', crossorigin: 'anonymous' },
        { rel: 'stylesheet', href: '/vendor/fontawesome-free/css/all.min.css' },
        { rel: 'stylesheet', href: '/vendor/animate/animate.min.css' },
        { rel: 'stylesheet', href: '/vendor/magnific-popup/magnific-popup.min.css' },
        { rel: 'stylesheet', href: '/vendor/owl-carousel/owl.carousel.min.css' },
        { rel: 'stylesheet', href: '/vendor/sticky-icon/stickyicon.css' },
        { rel: 'stylesheet', href: '/css/riode-font.css' },
        { rel: 'stylesheet', href: '/css/style.min.css' },
        { rel: 'stylesheet', href: '/css/market1.min.css' }
      ]
    }
  }
})
