<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <!-- Loading Spinner -->
    <LoadingSpinner :isVisible="isLoading" :loadingText="$t('auth.sendingResetLink')" />

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md">
        <!-- Card -->
        <div :class="['border rounded-2xl p-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-dark-700/50 shadow-black/20' : 'bg-white border-gray-200/50 shadow-black/5']">
          <!-- Header -->
          <div class="text-center mb-8">
            <h1 :class="['text-3xl font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">{{ $t('auth.forgotPassword') }}</h1>
            <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('auth.forgotPasswordSubtitle') || 'Gib deine E-Mail-Adresse ein, um einen Reset-Link zu erhalten' }}</p>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleForgotPassword" class="space-y-5 mb-6">
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

            <!-- Error Message -->
            <div v-if="errorMessage" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-red-50 border-red-200 text-red-700']">
              {{ errorMessage }}
            </div>

            <!-- Success Message -->
            <div v-if="successMessage" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-green-50 border-green-200 text-green-700']">
              {{ successMessage }}
            </div>

            <button
              type="submit"
              :disabled="isLoading"
              :class="['w-full py-2.5 bg-primary-600 text-white rounded-lg font-medium text-sm transition-all duration-200 mt-6 shadow-sm hover:shadow-md', isLoading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary-700']"
            >
              {{ $t('auth.sendResetLink') || 'Reset-Link senden' }}
            </button>
          </form>

          <!-- Back to Login Link -->
          <p :class="['text-center text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">
            {{ $t('auth.rememberPassword') || 'Passwort erinnert?' }}
            <router-link to="/login" :class="['font-medium transition-all duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
              {{ $t('auth.backToLogin') || 'Zurück zum Login' }}
            </router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
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

