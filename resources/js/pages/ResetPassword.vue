<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <!-- Loading Spinner -->
    <LoadingSpinner :isVisible="isLoading" :loadingText="$t('auth.resettingPassword')" />

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-4 py-12">
      <div class="w-full max-w-md">
        <!-- Card -->
        <div :class="['border rounded-2xl p-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-dark-700/50 shadow-black/20' : 'bg-white border-gray-200/50 shadow-black/5']">
          <!-- Header -->
          <div class="text-center mb-8">
            <h1 :class="['text-3xl font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">{{ $t('auth.resetPassword') || 'Passwort zurücksetzen' }}</h1>
            <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('auth.resetPasswordSubtitle') || 'Gib dein neues Passwort ein' }}</p>
          </div>

          <!-- Form -->
          <form @submit.prevent="handleResetPassword" class="space-y-5 mb-6">
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
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.newPassword') }}</label>
              <div class="relative">
                <input
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  :disabled="isLoading"
                  :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm pr-12', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10', isLoading ? 'opacity-50 cursor-not-allowed' : '']"
                  :placeholder="$t('auth.newPassword')"
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
              {{ $t('auth.resetPasswordButton') || 'Passwort zurücksetzen' }}
            </button>
          </form>

          <!-- Back to Login Link -->
          <p :class="['text-center text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">
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
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import LoadingSpinner from '../components/LoadingSpinner.vue'

const router = useRouter()
const route = useRoute()
const { t: $t } = useI18n()
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)

const form = ref({
  email: '',
  password: '',
  confirmPassword: '',
  token: '',
})

const errorMessage = ref('')
const successMessage = ref('')
const isLoading = ref(false)
const showPassword = ref(false)
const showConfirmPassword = ref(false)

onMounted(() => {
  // Get token from URL
  form.value.token = route.params.token || ''
})

const handleResetPassword = async () => {
  errorMessage.value = ''
  successMessage.value = ''

  // Validate form
  if (!form.value.email) {
    errorMessage.value = $t('auth.enterEmail')
    return
  }

  if (!form.value.password) {
    errorMessage.value = $t('auth.enterNewPassword')
    return
  }

  if (form.value.password.length < 8) {
    errorMessage.value = $t('auth.passwordMinLength')
    return
  }

  if (form.value.password !== form.value.confirmPassword) {
    errorMessage.value = $t('auth.passwordMismatch')
    return
  }

  isLoading.value = true

  try {
    const response = await fetch('/api/password/reset', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
      },
      body: JSON.stringify({
        email: form.value.email,
        password: form.value.password,
        password_confirmation: form.value.confirmPassword,
        token: form.value.token,
      }),
    })

    const data = await response.json()

    if (response.ok) {
      successMessage.value = data.message || $t('auth.passwordResetSuccess')
      // Redirect to login after 1.5 seconds
      setTimeout(() => {
        router.push('/login')
      }, 1500)
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
</script>

