<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-300 relative overflow-hidden', isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-50']">
    <!-- Animated Background Gradient -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div :class="['absolute -top-40 -right-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-primary-600' : 'bg-primary-400']"></div>
      <div :class="['absolute -bottom-40 -left-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-purple-600' : 'bg-purple-400']" style="animation-delay: 1s;"></div>
    </div>

    <!-- Loading Spinner -->
    <LoadingSpinner :isVisible="isLoading" loadingText="Anmeldung wird verarbeitet..." />

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-4 py-12 relative z-10 pt-32">
      <div
        class="w-full max-w-md transition-all duration-1000 ease-out"
        :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      >
        <!-- Card -->
        <div :class="['rounded-2xl p-10 transition-all duration-300 backdrop-blur-md', isDark ? 'bg-gray-800/50 border border-gray-700/50 shadow-2xl' : 'bg-white/90 border border-gray-200/50 shadow-2xl']">
          <!-- Header -->
          <div class="text-center mb-10">
            <h1 :class="['text-4xl font-extrabold mb-3 bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent']">{{ $t('auth.login') }}</h1>
            <p :class="['text-base', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.haveAccount') }}</p>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleLogin" class="space-y-6 mb-8">
            <div>
              <label :class="['block text-sm font-semibold mb-3', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.email') }}</label>
              <input
                v-model="form.email"
                type="email"
                :disabled="isLoading"
                :class="['w-full px-5 py-4 border rounded-xl text-base focus:outline-none transition-all duration-300 backdrop-blur-sm', isDark ? 'bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-primary-500 focus:shadow-lg focus:shadow-primary-600/20' : 'bg-white/80 border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:shadow-xl focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                :placeholder="$t('auth.email')"
              />
            </div>

            <div>
              <label :class="['block text-sm font-semibold mb-3', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.password') }}</label>
              <div class="relative">
                <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  :disabled="isLoading"
                  :class="['w-full px-5 py-4 border rounded-xl text-base focus:outline-none transition-all duration-300 backdrop-blur-sm pr-14', isDark ? 'bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-primary-500 focus:shadow-lg focus:shadow-primary-600/20' : 'bg-white/80 border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:shadow-xl focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.password')"
                />
                <!-- Custom Password Toggle Button -->
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  :disabled="isLoading"
                  :class="['absolute right-3 top-1/2 -translate-y-1/2 transition-all duration-300 group', isLoading ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer']"
                  :title="showPassword ? 'Passwort verbergen' : 'Passwort anzeigen'"
                >
                  <!-- Dot Pattern Toggle -->
                  <div :class="['flex gap-1 transition-all duration-300', showPassword ? 'scale-110' : 'scale-100']">
                    <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                    <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showPassword ? 'bg-primary-600' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                    <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  </div>
                </button>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <label class="flex items-center gap-3 cursor-pointer group">
                <input
                  v-model="form.rememberMe"
                  type="checkbox"
                  :disabled="isLoading"
                  :class="['w-5 h-5 rounded-lg cursor-pointer accent-primary-600 transition-all duration-300', isDark ? 'bg-gray-700 border-gray-600' : 'bg-white border-gray-300', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                />
                <span :class="['text-sm font-semibold transition-colors duration-300', isDark ? 'text-gray-300 group-hover:text-white' : 'text-gray-700 group-hover:text-gray-900']">{{ $t('auth.rememberMe') }}</span>
              </label>
              <router-link to="/forgot-password" :class="['text-sm font-semibold transition-all duration-300', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
                {{ $t('auth.forgotPassword') }}
              </router-link>
            </div>

            <!-- Error Message -->
            <div v-if="errorMessage" :class="['p-5 border rounded-xl text-sm font-medium backdrop-blur-sm', isDark ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-red-50 border-red-200 text-red-700']">
              {{ errorMessage }}
            </div>

            <button
              type="submit"
              :disabled="isLoading"
              :class="['group w-full py-4 rounded-xl font-bold text-lg transition-all duration-500 relative overflow-hidden', isLoading ? 'opacity-50 cursor-not-allowed bg-gray-400 text-gray-200' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl hover:shadow-2xl hover:scale-105']"
            >
              <span class="relative z-10 flex items-center justify-center gap-3">
                <svg v-if="!isLoading" class="w-6 h-6 transition-transform duration-500 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span class="transition-all duration-500 group-hover:tracking-wider">{{ $t('auth.signIn') }}</span>
              </span>
              <div v-if="!isLoading" class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </button>
          </form>

          <!-- Sign Up Link -->
          <p :class="['text-center text-base', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('auth.noAccount') }}
            <router-link to="/register" :class="['font-semibold transition-colors duration-300', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
              {{ $t('auth.signUp') }}
            </router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import { useAuthStore } from '../stores/authStore'
import LoadingSpinner from '../components/LoadingSpinner.vue'

const router = useRouter()
useI18n()
const themeStore = useThemeStore()
const authStore = useAuthStore()
const isDark = computed(() => themeStore.isDark)

const form = ref({
  email: '',
  password: '',
  rememberMe: false,
})

const errorMessage = ref('')
const isLoading = ref(false)
const showPassword = ref(false)
const isLoaded = ref(false)

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)
})

const handleLogin = async () => {
  errorMessage.value = ''
  isLoading.value = true

  try {
    const response = await fetch('/api/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        email: form.value.email,
        password: form.value.password,
      }),
    })

    if (!response.ok) {
      const error = await response.json()
      isLoading.value = false
      errorMessage.value = error.message || 'Login fehlgeschlagen'
      return
    }

    const data = await response.json()

    // Store token and user data
    localStorage.setItem('sessionToken', data.token)
    localStorage.setItem('currentUser', JSON.stringify(data.user))
    if (form.value.rememberMe) {
      localStorage.setItem('rememberMe', 'true')
    }

    // Update auth store
    authStore.user = data.user

    // Show loading animation for 1.5 seconds
    setTimeout(() => {
      isLoading.value = false
      // Check if there's a redirect parameter
      const redirect = router.currentRoute.value.query.redirect
      router.push(redirect || '/')
    }, 1500)
  } catch (error) {
    isLoading.value = false
    errorMessage.value = 'Fehler beim Login: ' + error.message
  }
}
</script>

