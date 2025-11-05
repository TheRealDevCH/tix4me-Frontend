<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 px-4">
    <div class="max-w-md w-full">
      <!-- Loading State -->
      <div v-if="isVerifying" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
        <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600 mx-auto mb-4"></div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
          {{ $t('emailVerification.verifying') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400">
          {{ $t('emailVerification.pleaseWait') }}
        </p>
      </div>

      <!-- Success State -->
      <div v-else-if="verificationSuccess" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
          {{ $t('emailVerification.success') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400 mb-4">
          {{ $t('emailVerification.successMessage') }}
        </p>
        <p class="text-indigo-600 dark:text-indigo-400 font-semibold mb-6">
          {{ $t('emailVerification.redirecting') }}
        </p>
        <button
          @click="goToHome"
          class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
        >
          {{ $t('emailVerification.goToHome') }}
        </button>
      </div>

      <!-- Error State -->
      <div v-else class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
        <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
          {{ $t('emailVerification.error') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
          {{ errorMessage }}
        </p>
        <button
          @click="goToHome"
          class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200"
        >
          {{ $t('emailVerification.goToHome') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useAuthStore } from '../stores/authStore'

const router = useRouter()
const route = useRoute()
const { t } = useI18n()
const authStore = useAuthStore()

const isVerifying = ref(true)
const verificationSuccess = ref(false)
const errorMessage = ref('')

const verifyEmail = async () => {
  try {
    const verifyUrl = route.query.verify_url

    if (!verifyUrl) {
      throw new Error('Ungültiger Verifizierungslink')
    }

    const response = await fetch(verifyUrl, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    })

    const data = await response.json()

    if (response.ok) {
      verificationSuccess.value = true

      if (data.token && data.user) {
        localStorage.setItem('session_token', data.token)
        authStore.user = data.user
        authStore.isAuthenticated = true
        authStore.emailVerified = true

        setTimeout(() => {
          router.push('/')
        }, 2000)
      }
    } else {
      throw new Error(data.message || 'Verifizierung fehlgeschlagen')
    }
  } catch (error) {
    console.error('Verification error:', error)
    errorMessage.value = error.message || t('emailVerification.errorMessage')
  } finally {
    isVerifying.value = false
  }
}

const goToHome = () => {
  router.push('/')
}

onMounted(() => {
  verifyEmail()
})
</script>

