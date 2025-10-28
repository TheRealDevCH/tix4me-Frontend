<template>
  <footer :class="['border-t transition-colors duration-200 mt-16 backdrop-blur-sm', isDark ? 'bg-dark-950/95 border-dark-700/50' : 'bg-white/95 border-gray-200/50']">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Links -->
      <div class="flex flex-col md:flex-row justify-center items-center gap-8 mb-8">
        <router-link to="/privacy" :class="['text-sm font-medium transition-all duration-200 px-3 py-2 rounded-lg', isDark ? 'text-gray-500 hover:text-gray-300 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']">
          {{ $t('footer.privacy') }}
        </router-link>
        <div :class="['w-px h-5', isDark ? 'bg-dark-700/50' : 'bg-gray-300/50']"></div>
        <router-link to="/terms" :class="['text-sm font-medium transition-all duration-200 px-3 py-2 rounded-lg', isDark ? 'text-gray-500 hover:text-gray-300 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']">
          {{ $t('footer.terms') }}
        </router-link>
        <div :class="['w-px h-5', isDark ? 'bg-dark-700/50' : 'bg-gray-300/50']"></div>
        <router-link to="/impressum" :class="['text-sm font-medium transition-all duration-200 px-3 py-2 rounded-lg', isDark ? 'text-gray-500 hover:text-gray-300 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']">
          {{ $t('footer.impressum') }}
        </router-link>
      </div>

      <!-- Copyright -->
      <div :class="['border-t pt-8 text-center transition-colors duration-200', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
        <p :class="['text-xs font-medium', isDark ? 'text-gray-600' : 'text-gray-500']">{{ $t('footer.copyright') }}</p>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'

useI18n()
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)
</script>

