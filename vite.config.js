import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import copy from 'rollup-plugin-copy'

const path = require("path");

export default defineConfig({
  plugins:
    [
      vue(),
      copy({
        targets: [
          { src: 'src/assets/static/*', dest: 'assets/' },
        ]
      })
    ],

  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
        @import "@/assets/css/_variables";
        `
      }
    }
  },

  build: {
    outDir: 'public',
    assetsDir: 'assetsDIR',
    // publicDir: 'public',
    emptyOutDir: false, // delete the contents of the output directory before each build

    // https://rollupjs.org/guide/en/#big-list-of-options
    rollupOptions: {
      input: [
        'src/main.js',
        // 'src/style.scss',
        // 'src/assets'
      ],
      output: {
        chunkFileNames: 'js/[name].js',
        entryFileNames: 'js/[name].js',

        assetFileNames: ({name}) => {
          if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')){
              return 'img/[name][extname]';
          }

          if (/\.css$/.test(name ?? '')) {
            return 'css/main.css';
          }

          // default value
          // ref: https://rollupjs.org/guide/en/#outputassetfilenames
          return '[name][extname]';
        },
      },
    },
  },

  resolve: {
    alias: {
      'vue': 'vue/dist/vue.esm-bundler.js',
      '@': path.resolve(__dirname, "src"),
    },
  },

  server: {
    port: 3000,
    strictPort: true,
    hmr: {
      port: 3000,
      host: 'localhost',
      protocol: 'ws',
    }
  }
})