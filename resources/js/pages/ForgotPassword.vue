<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-300 relative overflow-hidden', isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-50']">
    <!-- Animated Background Gradient -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div :class="['absolute -top-40 -right-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-primary-600' : 'bg-primary-400']"></div>
      <div :class="['absolute -bottom-40 -left-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-purple-600' : 'bg-purple-400']" style="animation-delay: 1s;"></div>
    </div>

    <!-- Loading Spinner -->
    <LoadingSpinner :isVisible="isLoading" :loadingText="$t('auth.sendingResetLink')" />

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
            <h1 :class="['text-4xl font-extrabold mb-3 bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent']">{{ $t('auth.forgotPassword') }}</h1>
            <p :class="['text-base', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.forgotPasswordSubtitle') || 'Gib deine E-Mail-Adresse ein, um einen Reset-Link zu erhalten' }}</p>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleForgotPassword" class="space-y-6 mb-8">
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

            <!-- Error Message -->
            <div v-if="errorMessage" :class="['p-5 border rounded-xl text-sm font-medium backdrop-blur-sm', isDark ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-red-50 border-red-200 text-red-700']">
              {{ errorMessage }}
            </div>

            <!-- Success Message -->
            <div v-if="successMessage" :class="['p-5 border rounded-xl text-sm font-medium backdrop-blur-sm', isDark ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-green-50 border-green-200 text-green-700']">
              {{ successMessage }}
            </div>

            <button
              type="submit"
              :disabled="isLoading"
              :class="['group w-full py-4 rounded-xl font-bold text-lg transition-all duration-500 relative overflow-hidden', isLoading ? 'opacity-50 cursor-not-allowed bg-gray-400 text-gray-200' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl hover:shadow-2xl hover:scale-105']"
            >
              <span class="relative z-10 flex items-center justify-center gap-3">
                <svg v-if="!isLoading" class="w-6 h-6 transition-transform duration-500 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="transition-all duration-500 group-hover:tracking-wider">{{ $t('auth.sendResetLink') || 'Reset-Link senden' }}</span>
              </span>
              <div v-if="!isLoading" class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </button>
          </form>

          <!-- Back to Login Link -->
          <p :class="['text-center text-base', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('auth.rememberPassword') || 'Passwort erinnert?' }}
            <router-link to="/login" :class="['font-semibold transition-colors duration-300', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
              {{ $t('auth.backToLogin') || 'Zurück zum Login' }}
            </router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import LoadingSpinner from '../components/LoadingSpinner.vue'

const { t: $t } = useI18n()
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)

const form = ref({
  email: '',
})

const errorMessage = ref('')
const successMessage = ref('')
const isLoading = ref(false)
const isLoaded = ref(false)

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)
})

const handleForgotPassword = async () => {
  errorMessage.value = ''
  successMessage.value = ''

  // Validate email
  if (!form.value.email) {
    errorMessage.value = $t('auth.enterEmail')
    return
  }

  if (!isValidEmail(form.value.email)) {
    errorMessage.value = $t('auth.validEmail')
    return
  }

  isLoading.value = true

  try {
    const response = await fetch('/api/password/email', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
      },
      body: JSON.stringify({
        email: form.value.email,
      }),
    })

    const data = await response.json()

    if (response.ok) {
      successMessage.value = data.message || $t('auth.resetLinkSent')
      form.value.email = ''
    } else {
      errorMessage.value = data.message || 'Ein Fehler ist aufgetreten. Bitte versuche es später erneut.'
    }
  } catch (error) {
    errorMessage.value = 'Ein Fehler ist aufgetreten. Bitte versuche es später erneut.'
    console.error('Error:', error)
  } finally {
    isLoading.value = false
  }
}

const isValidEmail = (email) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(email)
}
</script>

