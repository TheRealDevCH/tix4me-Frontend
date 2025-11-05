<template>
  <header class="absolute top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20 gap-4">
        <!-- Logo -->
        <router-link to="/" class="flex items-center transition-transform duration-300 hover:scale-105">
          <img src="/images/tix4melogooriginallogo.png" alt="Tix4me" class="h-10 w-auto drop-shadow-lg" />
        </router-link>

        <!-- Right Section -->
        <div class="flex items-center gap-4">
          <!-- Theme Toggle -->
          <button
            @click="themeStore.toggleTheme"
            :class="['p-2.5 rounded-xl transition-all duration-300 backdrop-blur-md', isDark ? 'text-gray-300 hover:text-white bg-gray-800/50 hover:bg-gray-700/50' : 'text-gray-700 hover:text-gray-900 bg-white/50 hover:bg-white/80 shadow-lg']"
            :title="isDark ? 'Light Mode' : 'Dark Mode'"
          >
            <!-- Moon Icon (Dark Mode) -->
            <svg v-if="isDark" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
            <!-- Sun Icon (Light Mode) -->
            <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="1" y1="12" x2="3" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
            </svg>
          </button>

          <!-- Language Selector -->
          <div class="relative group">
            <button :class="['text-sm font-semibold px-4 py-2.5 rounded-xl transition-all duration-300 backdrop-blur-md', isDark ? 'text-gray-300 hover:text-white bg-gray-800/50 hover:bg-gray-700/50' : 'text-gray-700 hover:text-gray-900 bg-white/50 hover:bg-white/80 shadow-lg']">
              {{ currentLanguage.toUpperCase() }}
            </button>
            <div :class="['absolute right-0 mt-2 w-32 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 py-2 backdrop-blur-md', isDark ? 'bg-gray-800/95 border border-gray-700/50' : 'bg-white/95 border border-gray-200/50']">
              <button
                v-for="lang in ['de', 'en', 'fr']"
                :key="lang"
                @click="changeLanguage(lang)"
                :class="[
                  'w-full text-left px-3 py-2 text-sm transition-all duration-200 mx-1 rounded',
                  currentLanguage === lang ? 'bg-primary-600 text-white font-medium' : isDark ? 'text-gray-300 hover:bg-dark-700' : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                {{ lang === 'de' ? 'Deutsch' : lang === 'en' ? 'English' : 'Français' }}
              </button>
            </div>
          </div>

          <!-- Create Event Button -->
          <router-link
            to="/create-event"
            :class="['px-6 py-2.5 text-sm font-semibold rounded-xl transition-all duration-300 backdrop-blur-md hover:scale-105', isDark ? 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-lg hover:shadow-xl' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl hover:shadow-2xl']"
          >
            {{ $t('nav.createEvent') }}
          </router-link>

          <!-- Cart Icon -->
          <router-link to="/cart" :class="['relative p-2.5 rounded-xl transition-all duration-300 backdrop-blur-md', isDark ? 'bg-gray-800/50 hover:bg-gray-700/50' : 'bg-white/50 hover:bg-white/80 shadow-lg']">
            <svg :class="['w-6 h-6 transition-colors duration-300', isDark ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-gray-900']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-gradient-to-r from-primary-600 to-purple-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg">
              {{ cartCount }}
            </span>
          </router-link>

          <!-- Auth Buttons / User Menu -->
          <div v-if="!authStore.isAuthenticated" class="flex items-center gap-4">
            <router-link to="/login" :class="['group/login text-sm font-bold px-6 py-3 rounded-xl transition-all duration-500 backdrop-blur-md relative overflow-hidden hover:scale-105', isDark ? 'text-gray-300 hover:text-white bg-gray-800/50 hover:bg-gray-700/50' : 'text-gray-700 hover:text-gray-900 bg-white/50 hover:bg-white/80 shadow-lg']">
              <span class="relative z-10 flex items-center gap-2">
                <svg class="w-4 h-4 transition-transform duration-500 group-hover/login:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span class="transition-all duration-500 group-hover/login:tracking-wide">{{ $t('nav.login') }}</span>
              </span>
              <div :class="['absolute inset-0 transform scale-x-0 group-hover/login:scale-x-100 transition-transform duration-500 origin-left', isDark ? 'bg-gray-600/30' : 'bg-gray-200/50']"></div>
            </router-link>
            <router-link to="/register" :class="['group/register px-7 py-3 text-sm font-bold rounded-xl transition-all duration-500 backdrop-blur-md hover:scale-110 relative overflow-hidden', isDark ? 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-lg hover:shadow-xl' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl hover:shadow-2xl']">
              <span class="relative z-10 flex items-center gap-2">
                <svg class="w-4 h-4 transition-transform duration-500 group-hover/register:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="transition-all duration-500 group-hover/register:tracking-wider">{{ $t('nav.register') }}</span>
              </span>
              <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover/register:scale-x-100 transition-transform duration-500 origin-left"></div>
            </router-link>
          </div>

          <!-- User Menu (when authenticated) -->
          <div v-else class="relative group">
            <button :class="['text-sm font-semibold px-5 py-2.5 rounded-xl transition-all duration-300 backdrop-blur-md', isDark ? 'text-gray-300 hover:text-white bg-gray-800/50 hover:bg-gray-700/50' : 'text-gray-700 hover:text-gray-900 bg-white/50 hover:bg-white/80 shadow-lg']">
              {{ authStore.getUserFullName }}
            </button>
            <div :class="['absolute right-0 mt-2 w-52 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 py-2 z-50 backdrop-blur-md', isDark ? 'bg-gray-800/95 border border-gray-700/50' : 'bg-white/95 border border-gray-200/50']">
              <!-- User Info Header -->
              <div :class="['px-4 py-3 border-b', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
                <p class="text-sm font-medium" :class="isDark ? 'text-gray-200' : 'text-gray-900'">{{ authStore.getUserFullName }}</p>
                <p class="text-xs mt-1" :class="isDark ? 'text-gray-500' : 'text-gray-600'">{{ authStore.user?.email }}</p>
              </div>

              <!-- Menu Items -->
              <router-link
                to="/account"
                :class="[
                  'block w-full text-left px-4 py-2.5 text-sm transition-all duration-200 mx-1 rounded',
                  isDark ? 'text-gray-300 hover:bg-dark-700' : 'text-gray-700 hover:bg-gray-100'
                ]"
              >
                {{ $t('nav.myAccount') || 'Mein Konto' }}
              </router-link>
              <button
                @click="handleLogout"
                :class="[
                  'w-full text-left px-4 py-2.5 text-sm transition-all duration-200 mx-1 rounded text-primary-600 hover:bg-primary-600/10',
                  isDark ? 'hover:bg-primary-600/20' : ''
                ]"
              >
                {{ $t('nav.logout') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useCartStore } from '../stores/cartStore'
import { useThemeStore } from '../stores/themeStore'
import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const { locale } = useI18n()
const cartStore = useCartStore()
const themeStore = useThemeStore()
const authStore = useAuthStore()

const currentLanguage = computed(() => locale.value)
const cartCount = computed(() => cartStore.itemCount)
const isDark = computed(() => themeStore.isDark)

const changeLanguage = (lang) => {
  locale.value = lang
  localStorage.setItem('locale', lang)
}

const handleLogout = () => {
  authStore.logout()
  router.push('/')
}

const getInitials = (fullName) => {
  if (!fullName) return '?'
  const names = fullName.split(' ')
  return names.map(n => n[0]).join('').toUpperCase().slice(0, 2)
}
</script>

