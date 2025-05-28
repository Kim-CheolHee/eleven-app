import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa'

export default defineConfig({
    server: {
        proxy: {
        '/api': 'http://localhost:8000'
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
          includeAssets: ['favicon.svg', 'robots.txt'],
          manifest: {
            name: 'Safe KOICA',
            short_name: '/safe-koica/',
            start_url: '/safe-koica/',
            scope: '/safe-koica/',
            description: 'KOICA 단원을 위한 오프라인 안전정보 제공 앱',
            theme_color: '#ffffff',
            background_color: '#ffffff',
            display: 'standalone',
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
            globPatterns: ['**/*.{js,css,html,png,svg,woff2}'],
            navigateFallback: '/index.html',
            runtimeCaching: [
              {
                urlPattern: /^https:\/\/ipapi\.co\/.*/,
                handler: 'NetworkFirst',
                options: {
                  cacheName: 'ipapi-cache',
                  expiration: {
                    maxEntries: 10,
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
                  }
                }
              }
            ]
          }
        })
    ],
});
