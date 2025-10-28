<template>
  <header :class="['sticky top-0 z-50 border-b transition-colors duration-200 backdrop-blur-sm', isDark ? 'bg-dark-950/95 border-dark-700/50' : 'bg-white/95 border-gray-200/50']">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16 gap-4">
        <!-- Logo -->
        <router-link to="/" class="flex items-center">
          <img src="/tix4melogooriginallogo.png" alt="Tix4me" class="h-8 w-auto" />
        </router-link>

        <!-- Right Section -->
        <div class="flex items-center gap-6">
          <!-- Theme Toggle -->
          <button
            @click="themeStore.toggleTheme"
            :class="['p-2 rounded-lg transition-all duration-200', isDark ? 'text-gray-400 hover:text-gray-200 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']"
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
            <button :class="['text-sm font-medium px-2 py-1.5 rounded-lg transition-all duration-200', isDark ? 'text-gray-400 hover:text-gray-200 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']">
              {{ currentLanguage.toUpperCase() }}
            </button>
            <div :class="['absolute right-0 mt-2 w-28 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-1 backdrop-blur-sm', isDark ? 'bg-dark-800/95 border border-dark-700/50' : 'bg-white/95 border border-gray-200/50']">
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
            :class="['px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md', isDark ? 'bg-primary-600 text-white hover:bg-primary-700' : 'bg-primary-600 text-white hover:bg-primary-700']"
          >
            {{ $t('nav.createEvent') }}
          </router-link>

          <!-- Cart Icon -->
          <router-link to="/cart" class="relative p-2 rounded-lg transition-all duration-200" :class="isDark ? 'hover:bg-dark-800' : 'hover:bg-gray-100'">
            <svg :class="['w-5 h-5 transition-colors duration-200', isDark ? 'text-gray-400 hover:text-gray-200' : 'text-gray-600 hover:text-gray-900']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-primary-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-md">
              {{ cartCount }}
            </span>
          </router-link>

          <!-- Auth Buttons / User Menu -->
          <div v-if="!authStore.isAuthenticated" class="flex items-center gap-3">
            <router-link to="/login" :class="['text-sm font-medium px-3 py-2 rounded-lg transition-all duration-200', isDark ? 'text-gray-400 hover:text-gray-200 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']">
              {{ $t('nav.login') }}
            </router-link>
            <router-link to="/register" :class="['px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md', isDark ? 'bg-primary-600 text-white hover:bg-primary-700' : 'bg-primary-600 text-white hover:bg-primary-700']">
              {{ $t('nav.register') }}
            </router-link>
          </div>

          <!-- User Menu (when authenticated) -->
          <div v-else class="relative group">
            <button :class="['text-sm font-medium px-3 py-2 rounded-lg transition-all duration-200', isDark ? 'text-gray-400 hover:text-gray-200 hover:bg-dark-800' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100']">
              {{ authStore.getUserFullName }}
            </button>
            <div :class="['absolute right-0 mt-2 w-48 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2 z-50 backdrop-blur-sm', isDark ? 'bg-dark-800/95 border border-dark-700/50' : 'bg-white/95 border border-gray-200/50']">
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

