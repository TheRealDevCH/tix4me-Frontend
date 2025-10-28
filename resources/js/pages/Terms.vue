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
          {{ $t('footer.terms') }}
        </h1>
      </div>
    </section>

    <!-- Content -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pb-20">
      <div :class="['rounded-2xl p-8 animate-slide-up space-y-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
        <!-- Intro -->
        <div :class="['border-b pb-8', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
          <h2 :class="['text-2xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">{{ $t('terms.title') }}</h2>
          <p :class="['text-sm leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('terms.intro') }}</p>
        </div>

        <!-- For Customers -->
        <div>
          <h2 class="text-3xl font-bold text-white mb-6 text-primary-400">{{ $t('terms.forCustomers') }}</h2>
          
          <!-- §1 -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §1 {{ $t('terms.section1Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.section1Text1') }}</p>
              <p>{{ $t('terms.section1Text2') }}</p>
            </div>
          </div>

          <!-- §2 -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §2 {{ $t('terms.section2Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.section2Text1') }}</p>
              <p>{{ $t('terms.section2Text2') }}</p>
            </div>
          </div>

          <!-- §3 -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §3 {{ $t('terms.section3Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.section3Text') }}</p>
          </div>

          <!-- §4 -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §4 {{ $t('terms.section4Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.section4Text') }}</p>
          </div>

          <!-- §5 -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §5 {{ $t('terms.section5Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.section5Text1') }}</p>
              <p>{{ $t('terms.section5Text2') }}</p>
              <p>{{ $t('terms.section5Text3') }}</p>
            </div>
          </div>

          <!-- §6 -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §6 {{ $t('terms.section6Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.section6Text') }}</p>
          </div>
        </div>

        <!-- For Organizers -->
        <div class="border-t border-dark-700 pt-8">
          <h2 class="text-3xl font-bold text-white mb-6 text-primary-400">{{ $t('terms.forOrganizers') }}</h2>
          
          <!-- §1 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §1 {{ $t('terms.orgSection1Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.orgSection1Text') }}</p>
          </div>

          <!-- §2 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §2 {{ $t('terms.orgSection2Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.orgSection2Text1') }}</p>
              <p>{{ $t('terms.orgSection2Text2') }}</p>
            </div>
          </div>

          <!-- §3 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §3 {{ $t('terms.orgSection3Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.orgSection3Text1') }}</p>
              <p>{{ $t('terms.orgSection3Text2') }}</p>
            </div>
          </div>

          <!-- §4 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §4 {{ $t('terms.orgSection4Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.orgSection4Text') }}</p>
          </div>

          <!-- §5 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §5 {{ $t('terms.orgSection5Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.orgSection5Text1') }}</p>
              <p>{{ $t('terms.orgSection5Text2') }}</p>
            </div>
          </div>

          <!-- §6 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §6 {{ $t('terms.orgSection6Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.orgSection6Text') }}</p>
          </div>

          <!-- §7 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §7 {{ $t('terms.orgSection7Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.orgSection7Text1') }}</p>
              <p>{{ $t('terms.orgSection7Text2') }}</p>
            </div>
          </div>

          <!-- §8 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §8 {{ $t('terms.orgSection8Title') }}
            </h3>
            <div class="space-y-3 text-gray-300 text-sm leading-relaxed ml-4">
              <p>{{ $t('terms.orgSection8Text1') }}</p>
              <p>{{ $t('terms.orgSection8Text2') }}</p>
            </div>
          </div>

          <!-- §9 Organizers -->
          <div class="mb-8">
            <h3 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
              <span class="w-1 h-6 bg-primary-500 rounded"></span>
              §9 {{ $t('terms.orgSection9Title') }}
            </h3>
            <p class="text-gray-300 text-sm leading-relaxed ml-4">{{ $t('terms.orgSection9Text') }}</p>
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

