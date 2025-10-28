<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <!-- Loading Spinner -->
    <LoadingSpinner :isVisible="isLoading" :loadingText="$t('auth.processing')" />

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md">
        <!-- Card -->
        <div :class="['border rounded-2xl p-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-dark-700/50 shadow-black/20' : 'bg-white border-gray-200/50 shadow-black/5']">
          <!-- Header -->
          <div class="text-center mb-8">
            <h1 :class="['text-3xl font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">{{ $t('auth.register') }}</h1>
            <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('auth.haveAccount') }}</p>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleRegister" class="space-y-5 mb-6">
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.firstName') }}</label>
                <input
                  v-model="form.firstName"
                  type="text"
                  :disabled="isLoading"
                  :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.firstName')"
                />
              </div>
              <div>
                <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.lastName') }}</label>
                <input
                  v-model="form.lastName"
                  type="text"
                  :disabled="isLoading"
                  :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.lastName')"
                />
              </div>
            </div>

            <div>
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.email') }}</label>
              <input
                v-model="form.email"
                type="email"
                :disabled="isLoading"
                :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
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
              :class="['w-full py-2.5 bg-primary-600 text-white rounded-lg font-medium text-sm transition-all duration-200 mt-6 shadow-sm hover:shadow-md', isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary-700']"
            >
              {{ $t('auth.signUp') }}
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
import { ref, computed } from 'vue'
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

    // Store token and user data
    localStorage.setItem('sessionToken', data.token)
    localStorage.setItem('currentUser', JSON.stringify(data.user))
    localStorage.setItem('rememberMe', 'true')

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
    errorMessage.value = 'Fehler bei der Registrierung: ' + error.message
  }
}
</script>

