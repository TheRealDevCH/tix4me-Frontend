<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-300 relative overflow-hidden', isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-50']">
    <!-- Animated Background Gradient -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div :class="['absolute -top-40 -right-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-primary-600' : 'bg-primary-400']"></div>
      <div :class="['absolute -bottom-40 -left-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-purple-600' : 'bg-purple-400']" style="animation-delay: 1s;"></div>
    </div>

    <!-- Loading Spinner -->
    <LoadingSpinner :isVisible="isLoading" :loadingText="$t('auth.processing')" />

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
            <h1 :class="['text-4xl font-extrabold bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent']">{{ $t('auth.register') }}</h1>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleRegister" class="space-y-6 mb-8">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label :class="['block text-sm font-semibold mb-3', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.firstName') }}</label>
                <input
                  v-model="form.firstName"
                  type="text"
                  :disabled="isLoading"
                  :class="['w-full px-5 py-4 border rounded-xl text-base focus:outline-none transition-all duration-300 backdrop-blur-sm', isDark ? 'bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-primary-500 focus:shadow-lg focus:shadow-primary-600/20' : 'bg-white/80 border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:shadow-xl focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.firstName')"
                />
              </div>
              <div>
                <label :class="['block text-sm font-semibold mb-3', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.lastName') }}</label>
                <input
                  v-model="form.lastName"
                  type="text"
                  :disabled="isLoading"
                  :class="['w-full px-5 py-4 border rounded-xl text-base focus:outline-none transition-all duration-300 backdrop-blur-sm', isDark ? 'bg-gray-700/50 border-gray-600 text-white placeholder-gray-400 focus:border-primary-500 focus:shadow-lg focus:shadow-primary-600/20' : 'bg-white/80 border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:shadow-xl focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.lastName')"
                />
              </div>
            </div>

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
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.password') }}</label>
              <div class="relative">
                <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  :disabled="isLoading"
                  :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm pr-12', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
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

            <div>
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.confirmPassword') }}</label>
              <div class="relative">
                <input
                  v-model="form.confirmPassword"
                  :type="showConfirmPassword ? 'text' : 'password'"
                  :disabled="isLoading"
                  :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm pr-12', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.confirmPassword')"
                />
                <!-- Custom Password Toggle Button -->
                <button
                  type="button"
                  @click="showConfirmPassword = !showConfirmPassword"
                  :disabled="isLoading"
                  :class="['absolute right-3 top-1/2 -translate-y-1/2 transition-all duration-300 group', isLoading ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer']"
                  :title="showConfirmPassword ? 'Passwort verbergen' : 'Passwort anzeigen'"
                >
                  <!-- Dot Pattern Toggle -->
                  <div :class="['flex gap-1 transition-all duration-300', showConfirmPassword ? 'scale-110' : 'scale-100']">
                    <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showConfirmPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                    <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showConfirmPassword ? 'bg-primary-600' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                    <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showConfirmPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  </div>
                </button>
              </div>
            </div>

            <label class="flex items-center gap-2 cursor-pointer">
              <input
                v-model="form.agreeTerms"
                type="checkbox"
                :disabled="isLoading"
                :class="['w-4 h-4 rounded cursor-pointer accent-primary-600', isDark ? 'bg-dark-700 border-dark-600' : 'bg-white border-gray-300', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
              />
              <span :class="['text-sm font-medium', isDark ? 'text-gray-400' : 'text-gray-600']">
                {{ $t('auth.acceptTerms') }} <router-link to="/terms" target="_blank" :class="['transition-all duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">{{ $t('auth.termsLink') }}</router-link>
              </span>
            </label>

            <!-- Error Message -->
            <div v-if="errorMessage" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-red-50 border-red-200 text-red-700']">
              {{ errorMessage }}
            </div>

            <button
              type="submit"
              :disabled="isLoading"
              :class="['group w-full py-4 rounded-xl font-bold text-lg transition-all duration-500 relative overflow-hidden mt-6', isLoading ? 'opacity-50 cursor-not-allowed bg-gray-400 text-gray-200' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl hover:shadow-2xl hover:scale-105']"
            >
              <span class="relative z-10 flex items-center justify-center gap-3">
                <svg v-if="!isLoading" class="w-6 h-6 transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="transition-all duration-500 group-hover:tracking-wider">{{ $t('auth.signUp') }}</span>
              </span>
              <div v-if="!isLoading" class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </button>
          </form>

          <!-- Sign In Link -->
          <p :class="['text-center text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">
            {{ $t('auth.haveAccount') }}
            <router-link to="/login" :class="['font-medium transition-colors duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
              {{ $t('auth.signIn') }}
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
const { t: $t } = useI18n()
const themeStore = useThemeStore()
const authStore = useAuthStore()
const isDark = computed(() => themeStore.isDark)

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  password: '',
  confirmPassword: '',
  agreeTerms: false,
})

const errorMessage = ref('')
const isLoading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)
const isLoaded = ref(false)

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)
})

const handleRegister = async () => {
  errorMessage.value = ''
  isLoading.value = false

  // Validate terms
  if (!form.value.agreeTerms) {
    errorMessage.value = $t('auth.agreeTermsRequired')
    return
  }

  isLoading.value = true

  try {
    const response = await fetch('/api/auth/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        name: `${form.value.firstName} ${form.value.lastName}`,
        email: form.value.email,
        password: form.value.password,
        password_confirmation: form.value.confirmPassword,
      }),
    })

    if (!response.ok) {
      const error = await response.json()
      isLoading.value = false
      errorMessage.value = error.message || 'Registrierung fehlgeschlagen'
      return
    }

    const data = await response.json()

    const nameParts = data.user.name.split(' ')
    const userWithNames = {
      ...data.user,
      firstName: nameParts[0] || '',
      lastName: nameParts.slice(1).join(' ') || ''
    }

    localStorage.setItem('authToken', data.token)
    localStorage.setItem('currentUser', JSON.stringify(userWithNames))
    localStorage.setItem('rememberMe', 'true')

    authStore.user = userWithNames
    authStore.token = data.token

    // Show loading animation for 1.5 seconds
    setTimeout(() => {
      isLoading.value = false
      // Check if there's a redirect parameter
      const redirect = router.currentRoute.value.query.redirect
      router.push(redirect || '/')
    }, 1500)
  } catch (error) {
    isLoading.value = false
    errorMessage.value = 'Fehler bei der Registrierung: ' + error.message
  }
}
</script>

