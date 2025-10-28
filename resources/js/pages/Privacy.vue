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
          {{ $t('footer.privacy') }}
        </h1>
      </div>
    </section>

    <!-- Content -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pb-20">
      <div :class="['rounded-2xl p-8 animate-slide-up space-y-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
        <!-- §1 PRÄAMBEL -->
        <div>
          <h2 :class="['text-2xl font-bold mb-4 flex items-center gap-3', isDark ? 'text-white' : 'text-gray-900']">
            <span class="w-1 h-8 bg-primary-600 rounded"></span>
            §1 {{ $t('privacy.preamble') }}
          </h2>
          <div :class="['space-y-3 text-sm leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">
            <p>{{ $t('privacy.preambleText1') }}</p>
            <p>{{ $t('privacy.preambleText2') }}</p>
          </div>
        </div>

        <!-- §2 VERANTWORTLICHE STELLE -->
        <div>
          <h2 :class="['text-2xl font-bold mb-4 flex items-center gap-3', isDark ? 'text-white' : 'text-gray-900']">
            <span class="w-1 h-8 bg-primary-600 rounded"></span>
            §2 {{ $t('privacy.responsible') }}
          </h2>
          <div :class="['space-y-2 text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">
            <p :class="['font-semibold', isDark ? 'text-white' : 'text-gray-900']">4me GmbH</p>
            <p>Rainstrasse 19</p>
            <p>CH-2540 Grenchen</p>
            <p>E-Mail: <a href="mailto:info@tix4me.ch" :class="['transition-colors duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">info@tix4me.ch</a></p>
            <p>Internet: <a href="https://www.tix4me.ch" :class="['transition-colors duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">www.tix4me.ch</a></p>
          </div>
        </div>

        <!-- §3 ANSPRECHPARTNER FÜR DATENSCHUTZ -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §3 {{ $t('privacy.dataProtectionContact') }}
          </h2>
          <div class="space-y-2 text-gray-300 text-sm">
            <p>{{ $t('privacy.dataProtectionContactText') }}</p>
            <p class="font-semibold text-white mt-4">4me GmbH</p>
            <p>Rainstrasse 19</p>
            <p>CH-2540 Grenchen</p>
            <p>E-Mail: <a href="mailto:info@tix4me.ch" class="text-primary-400 hover:text-primary-300">info@tix4me.ch</a></p>
          </div>
        </div>

        <!-- §4 GELTUNGSBEREICH -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §4 {{ $t('privacy.scope') }}
          </h2>
          <p class="text-gray-300 text-sm leading-relaxed">{{ $t('privacy.scopeText') }}</p>
        </div>

        <!-- §5 ERHEBUNG UND NUTZUNG -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §5 {{ $t('privacy.dataCollection') }}
          </h2>
          <div class="space-y-3 text-gray-300 text-sm leading-relaxed">
            <p>{{ $t('privacy.dataCollectionText1') }}</p>
            <p>{{ $t('privacy.dataCollectionText2') }}</p>
            <p>{{ $t('privacy.dataCollectionText3') }}</p>
          </div>
        </div>

        <!-- §6 VERANSTALTERDATENSPEICHERUNG -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §6 {{ $t('privacy.eventDataStorage') }}
          </h2>
          <p class="text-gray-300 text-sm leading-relaxed">{{ $t('privacy.eventDataStorageText') }}</p>
        </div>

        <!-- §7 BESTELLUNG UND ANMELDUNG -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §7 {{ $t('privacy.orderProcess') }}
          </h2>
          <div class="space-y-3 text-gray-300 text-sm leading-relaxed">
            <p>{{ $t('privacy.orderProcessText1') }}</p>
            <p>{{ $t('privacy.orderProcessText2') }}</p>
            <p>{{ $t('privacy.orderProcessText3') }}</p>
            <p>{{ $t('privacy.orderProcessText4') }}</p>
          </div>
        </div>

        <!-- §8 SUPPORT -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §8 {{ $t('privacy.support') }}
          </h2>
          <p class="text-gray-300 text-sm leading-relaxed">{{ $t('privacy.supportText') }}</p>
        </div>

        <!-- §9 DATENSICHERHEIT -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §9 {{ $t('privacy.dataSecurity') }}
          </h2>
          <div class="space-y-3 text-gray-300 text-sm leading-relaxed">
            <p>{{ $t('privacy.dataSecurityText1') }}</p>
            <p>{{ $t('privacy.dataSecurityText2') }}</p>
          </div>
        </div>

        <!-- §10 COOKIES -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §10 {{ $t('privacy.cookies') }}
          </h2>
          <div class="space-y-3 text-gray-300 text-sm leading-relaxed">
            <p>{{ $t('privacy.cookiesText1') }}</p>
            <p>{{ $t('privacy.cookiesText2') }}</p>
          </div>
        </div>

        <!-- §11 TRACKING -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §11 {{ $t('privacy.tracking') }}
          </h2>
          <div class="space-y-3 text-gray-300 text-sm leading-relaxed">
            <p>{{ $t('privacy.trackingText1') }}</p>
            <p>{{ $t('privacy.trackingText2') }}</p>
          </div>
        </div>

        <!-- §12 USA HINWEISE -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §12 {{ $t('privacy.usaNotice') }}
          </h2>
          <div class="space-y-3 text-gray-300 text-sm leading-relaxed">
            <p>{{ $t('privacy.usaNoticeText1') }}</p>
            <p>{{ $t('privacy.usaNoticeText2') }}</p>
          </div>
        </div>

        <!-- §13 AUSKUNFTSRECHT -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §13 {{ $t('privacy.rights') }}
          </h2>
          <p class="text-gray-300 text-sm leading-relaxed">{{ $t('privacy.rightsText') }}</p>
        </div>

        <!-- §14 DATENSICHERHEIT -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §14 {{ $t('privacy.securityMeasures') }}
          </h2>
          <p class="text-gray-300 text-sm leading-relaxed">{{ $t('privacy.securityMeasuresText') }}</p>
        </div>

        <!-- §15 AUFBEWAHRUNG -->
        <div>
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            §15 {{ $t('privacy.retention') }}
          </h2>
          <p class="text-gray-300 text-sm leading-relaxed">{{ $t('privacy.retentionText') }}</p>
        </div>

        <!-- AKTUALITÄT -->
        <div class="border-t border-dark-700 pt-8">
          <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
            <span class="w-1 h-8 bg-primary-500 rounded"></span>
            {{ $t('privacy.updates') }}
          </h2>
          <p :class="['text-sm leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('privacy.updatesText') }}</p>
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

