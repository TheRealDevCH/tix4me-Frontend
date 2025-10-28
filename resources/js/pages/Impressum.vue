<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <!-- Header -->
    <section :class="['relative py-12 px-4 sm:px-6 lg:px-8 overflow-hidden', isDark ? 'bg-dark-900' : 'bg-gray-50']">
      <div :class="['absolute inset-0', isDark ? 'bg-gradient-to-r from-primary-900/20 to-transparent' : 'bg-gradient-to-r from-primary-600/10 to-transparent']"></div>
      <div class="max-w-4xl mx-auto relative z-10">
        <router-link
          to="/"
          :class="['inline-flex items-center gap-2 transition-colors duration-200 mb-6 animate-fade-in', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          {{ $t('ticket.backToHome') }}
        </router-link>
        <h1 :class="['text-4xl md:text-5xl font-bold mb-4 animate-fade-in', isDark ? 'text-white' : 'text-gray-900']">
          {{ $t('footer.impressum') }}
        </h1>
      </div>
    </section>

    <!-- Content -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pb-20">
      <div :class="['rounded-2xl p-8 animate-slide-up transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
        <!-- Unternehmen -->
        <div class="mb-12">
          <h2 :class="['text-2xl font-bold mb-6 flex items-center gap-3', isDark ? 'text-white' : 'text-gray-900']">
            <span class="w-1 h-8 bg-primary-600 rounded"></span>
            {{ $t('impressum.company') }}
          </h2>
          <div :class="['space-y-3', isDark ? 'text-gray-400' : 'text-gray-600']">
            <p :class="['font-semibold', isDark ? 'text-white' : 'text-gray-900']">4me GmbH</p>
            <p>Rainstr. 19</p>
            <p>2540 Grenchen</p>
            <p>{{ $t('impressum.country') }}</p>
          </div>
        </div>

        <!-- Kontakt -->
        <div class="mb-12">
          <h2 :class="['text-2xl font-bold mb-6 flex items-center gap-3', isDark ? 'text-white' : 'text-gray-900']">
            <span class="w-1 h-8 bg-primary-600 rounded"></span>
            {{ $t('impressum.contact') }}
          </h2>
          <div :class="['space-y-3', isDark ? 'text-gray-400' : 'text-gray-600']">
            <p>
              <span :class="[isDark ? 'text-gray-500' : 'text-gray-500']">{{ $t('impressum.phone') }}:</span>
              <a href="tel:+41326522038" :class="['transition-colors duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
                +41 32 652 20 38
              </a>
            </p>
            <p>
              <span class="text-gray-400">{{ $t('impressum.email') }}:</span>
              <a href="mailto:info@tix4me.ch" class="text-primary-400 hover:text-primary-300 transition-colors">
                info@tix4me.ch
              </a>
            </p>
          </div>
        </div>

        <!-- Registereintrag -->
        <div class="mb-12">
          <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            {{ $t('impressum.registration') }}
          </h2>
          <div class="space-y-3 text-gray-300">
            <p>
              <span class="text-gray-400">{{ $t('impressum.registrationEntry') }}:</span>
              <span class="text-white">{{ $t('impressum.handelsregister') }}</span>
            </p>
            <p>
              <span class="text-gray-400">{{ $t('impressum.company') }}:</span>
              <span class="text-white">4me GmbH</span>
            </p>
            <p>
              <span class="text-gray-400">{{ $t('impressum.registrationNumber') }}:</span>
              <span class="text-white">CHE-330.064.762</span>
            </p>
            <p>
              <span class="text-gray-400">{{ $t('impressum.vatNumber') }}:</span>
              <span class="text-white">MwSt-330.064.762</span>
            </p>
          </div>
        </div>

        <!-- Rechtliche Hinweise -->
        <div class="border-t border-dark-700 pt-8">
          <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            {{ $t('impressum.legalNotice') }}
          </h2>
          <div class="space-y-4 text-gray-300">
            <p>
              {{ $t('impressum.disclaimer') }}
            </p>
            <p>
              {{ $t('impressum.liabilityNotice') }}
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'

useI18n()
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)
</script>

<style scoped>
</style>

