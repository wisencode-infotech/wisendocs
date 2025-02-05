import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.jsx'], // Input files
      refresh: true, // Auto-refresh for development
    }),
    react(), // Enable React support
  ]
});
