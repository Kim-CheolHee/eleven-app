import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
  server: {
    proxy: {
      '/api': 'http://localhost:8000',
    },
  },
  build: {
    outDir: 'public/build',
    manifest: true,
    rollupOptions: {
      output: {
        entryFileNames: 'assets/[name]-[hash].js',
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash][extname]',
      },
    },
  },
  plugins: [
    laravel({
      input: 'resources/js/app.js',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    VitePWA({
      registerType: 'autoUpdate',
      includeAssets: [
        'favicon.svg',
        'robots.txt',
        'images/safe_koica/icon-192x192.png',
        'images/safe_koica/icon-512x512.png',
      ],
      manifest: {
        name: 'Safe KOICA',
        short_name: 'SafeKOICA',
        start_url: '/safe-koica',
        scope: '/',
        display: 'standalone',
        background_color: '#ffffff',
        theme_color: '#ffffff',
        description: 'KOICA 단원을 위한 오프라인 안전정보 제공 앱',
        icons: [
          {
            src: '/images/safe_koica/icon-192x192.png',
            sizes: '192x192',
            type: 'image/png',
          },
          {
            src: '/images/safe_koica/icon-512x512.png',
            sizes: '512x512',
            type: 'image/png',
          }
        ]
      },
      workbox: {
        globDirectory: 'public',
        globPatterns: [
          'build/assets/*.js',
          'build/assets/*.css',
          'build/.vite/manifest.json',
        ],
        navigateFallback: '/safe-koica',
        navigateFallbackDenylist: [/^\/api/, /^\/images/],
        runtimeCaching: [
          {
            urlPattern: /^https:\/\/ipapi\.co\/.*/,
            handler: 'NetworkFirst',
            options: {
              cacheName: 'ipapi-cache',
              expiration: {
                maxEntries: 5,
                maxAgeSeconds: 3600,
              }
            }
          },
          {
            urlPattern: /^https:\/\/mica92\.com\/api\/safe-koica\/.*/,
            handler: 'NetworkFirst',
            options: {
              cacheName: 'api-cache',
              expiration: {
                maxEntries: 10,
                maxAgeSeconds: 3600,
              },
              networkTimeoutSeconds: 3,
              plugins: [
                {
                  cacheWillUpdate: async ({ response }) => {
                    return response && response.status === 200 ? response : null
                  }
                }
              ]
            }
          }
        ]
      }
    })
  ],
})
