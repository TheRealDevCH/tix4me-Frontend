<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <!-- Header -->
    <section :class="['py-8 px-4 sm:px-6 lg:px-8 border-b transition-colors duration-200', isDark ? 'bg-dark-900 border-dark-700/50' : 'bg-white border-gray-200/50']">
      <div class="max-w-4xl mx-auto">
        <h1 :class="['text-3xl font-bold mb-1', isDark ? 'text-white' : 'text-gray-900']">{{ $t('account.title') || 'Mein Konto' }}</h1>
        <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('account.subtitle') || 'Verwalte deine Kontoeinstellungen' }}</p>
      </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Profile Picture Section -->
      <div :class="['border rounded-2xl p-6 mb-6 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-dark-700/50 shadow-black/20' : 'bg-white border-gray-200/50 shadow-black/5']">
        <h2 :class="['text-xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">{{ $t('account.profilePicture') || 'Profilbild' }}</h2>

        <div class="flex flex-col sm:flex-row items-center gap-6">
          <!-- Current Avatar -->
          <div class="flex flex-col items-center">
            <img
              v-if="authStore.user?.profileImage"
              :src="authStore.user.profileImage"
              :alt="authStore.getUserFullName"
              class="w-24 h-24 rounded-full object-cover mb-3 border-2 border-primary-600"
            />
            <div v-else class="w-24 h-24 rounded-full bg-primary-600 flex items-center justify-center text-white text-3xl font-bold mb-3 border-2 border-primary-600">
              {{ getInitials(authStore.getUserFullName) }}
            </div>
            <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">{{ authStore.getUserFullName }}</p>
          </div>

          <!-- Profile Info -->
          <div class="flex-1">
            <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">
              {{ $t('account.profileImageInfo') }}
            </p>
          </div>
        </div>
      </div>

      <!-- Personal Information Section -->
      <div :class="['border rounded-2xl p-6 mb-6 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-dark-700/50 shadow-black/20' : 'bg-white border-gray-200/50 shadow-black/5']">
        <h2 :class="['text-xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">{{ $t('account.personalInformation') || 'Persönliche Informationen' }}</h2>

        <form @submit.prevent="savePersonalInfo" class="space-y-5">
          <div>
            <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.name') || 'Name' }}</label>
            <input
              v-model="profileForm.name"
              type="text"
              required
              :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
            />
          </div>

          <div>
            <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.email') }}</label>
            <input
              v-model="profileForm.email"
              type="email"
              required
              :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
            />
            <p :class="['text-xs mt-1', isDark ? 'text-gray-400' : 'text-gray-600']">
              {{ $t('account.emailChangeWarning') || 'Wenn Sie Ihre E-Mail-Adresse ändern, müssen Sie diese erneut bestätigen.' }}
            </p>
          </div>

          <!-- Messages -->
          <div v-if="profileError" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-red-50 border-red-200 text-red-700']">
            {{ profileError }}
          </div>
          <div v-if="profileSuccess" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-green-50 border-green-200 text-green-700']">
            {{ profileSuccess }}
          </div>

          <button
            type="submit"
            class="group px-8 py-4 bg-gradient-to-r from-primary-600 to-purple-600 text-white rounded-xl font-bold text-lg transition-all duration-500 shadow-xl hover:shadow-2xl hover:scale-105 relative overflow-hidden"
          >
            <span class="relative z-10 flex items-center justify-center gap-3">
              <svg class="w-6 h-6 transition-transform duration-500 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="transition-all duration-500 group-hover:tracking-wider">{{ $t('account.saveChanges') || 'Änderungen speichern' }}</span>
            </span>
            <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
          </button>
        </form>
      </div>

      <!-- Change Password Section -->
      <div :class="['border rounded-2xl p-6 mb-6 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-dark-700/50 shadow-black/20' : 'bg-white border-gray-200/50 shadow-black/5']">
        <h2 :class="['text-xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">{{ $t('account.changePassword') || 'Passwort ändern' }}</h2>

        <form @submit.prevent="changePassword" class="space-y-5">
          <div>
            <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('account.currentPassword') || 'Aktuelles Passwort' }}</label>
            <div class="relative">
              <input
                v-model="passwordForm.currentPassword"
                :type="showCurrentPassword ? 'text' : 'password'"
                :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm pr-12', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <button
                type="button"
                @click="showCurrentPassword = !showCurrentPassword"
                :class="['absolute right-3 top-1/2 -translate-y-1/2 transition-all duration-300', 'cursor-pointer']"
                :title="showCurrentPassword ? 'Passwort verbergen' : 'Passwort anzeigen'"
              >
                <div :class="['flex gap-1 transition-all duration-300', showCurrentPassword ? 'scale-110' : 'scale-100']">
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showCurrentPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showCurrentPassword ? 'bg-primary-600' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showCurrentPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                </div>
              </button>
            </div>
          </div>

          <div>
            <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('account.newPassword') || 'Neues Passwort' }}</label>
            <div class="relative">
              <input
                v-model="passwordForm.newPassword"
                :type="showNewPassword ? 'text' : 'password'"
                :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm pr-12', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <button
                type="button"
                @click="showNewPassword = !showNewPassword"
                :class="['absolute right-3 top-1/2 -translate-y-1/2 transition-all duration-300', 'cursor-pointer']"
                :title="showNewPassword ? 'Passwort verbergen' : 'Passwort anzeigen'"
              >
                <div :class="['flex gap-1 transition-all duration-300', showNewPassword ? 'scale-110' : 'scale-100']">
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showNewPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showNewPassword ? 'bg-primary-600' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showNewPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                </div>
              </button>
            </div>
          </div>

          <div>
            <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('account.confirmPassword') || 'Passwort bestätigen' }}</label>
            <div class="relative">
              <input
                v-model="passwordForm.confirmPassword"
                :type="showConfirmPassword ? 'text' : 'password'"
                :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm pr-12', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <button
                type="button"
                @click="showConfirmPassword = !showConfirmPassword"
                :class="['absolute right-3 top-1/2 -translate-y-1/2 transition-all duration-300', 'cursor-pointer']"
                :title="showConfirmPassword ? 'Passwort verbergen' : 'Passwort anzeigen'"
              >
                <div :class="['flex gap-1 transition-all duration-300', showConfirmPassword ? 'scale-110' : 'scale-100']">
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showConfirmPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showConfirmPassword ? 'bg-primary-600' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                  <div :class="['w-1.5 h-1.5 rounded-full transition-all duration-300', showConfirmPassword ? 'bg-primary-600 scale-125' : (isDark ? 'bg-gray-500' : 'bg-gray-400')]" />
                </div>
              </button>
            </div>
          </div>

          <!-- Messages -->
          <div v-if="passwordError" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-red-500/10 border-red-500/30 text-red-400' : 'bg-red-50 border-red-200 text-red-700']">
            {{ passwordError }}
          </div>
          <div v-if="passwordSuccess" :class="['p-4 border rounded-lg text-sm', isDark ? 'bg-green-500/10 border-green-500/30 text-green-400' : 'bg-green-50 border-green-200 text-green-700']">
            {{ passwordSuccess }}
          </div>

          <button
            type="submit"
            class="px-4 py-2.5 bg-primary-600 text-white rounded-lg font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:bg-primary-700"
          >
            {{ $t('account.changePassword') || 'Passwort ändern' }}
          </button>
        </form>
      </div>

      <!-- Delete Account Section -->
      <div :class="['border rounded-2xl p-6 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border-red-500/30 shadow-black/20' : 'bg-white border-red-200/50 shadow-black/5']">
        <h2 :class="['text-xl font-bold mb-3', isDark ? 'text-red-400' : 'text-red-600']">{{ $t('account.deleteAccount') || 'Konto löschen' }}</h2>
        <p :class="['text-sm mb-4', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('account.deleteWarning') || 'Diese Aktion kann nicht rückgängig gemacht werden. Alle deine Daten werden gelöscht.' }}</p>

        <button
          @click="confirmDeleteAccount"
          class="px-4 py-2.5 bg-red-600 text-white rounded-lg font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:bg-red-700"
        >
          {{ $t('account.deleteAccount') || 'Konto löschen' }}
        </button>
      </div>
    </main>

    <!-- Delete Account Confirmation Modal -->
    <div v-if="showDeleteConfirm" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div :class="['rounded-2xl p-6 max-w-md w-full transition-all duration-200 shadow-2xl', isDark ? 'bg-dark-800 border border-dark-700' : 'bg-white border border-gray-200']">
        <!-- Title -->
        <h3 :class="['text-xl font-bold mb-3', isDark ? 'text-red-400' : 'text-red-600']">
          {{ $t('account.deleteAccountConfirmTitle') || 'Konto löschen?' }}
        </h3>

        <!-- Message -->
        <p :class="['text-sm mb-4', isDark ? 'text-gray-400' : 'text-gray-600']">
          {{ $t('account.deleteAccountConfirmMessage') || 'Diese Aktion kann nicht rückgängig gemacht werden. Bitte geben Sie Ihr Passwort ein, um fortzufahren.' }}
        </p>

        <!-- Password Input -->
        <div class="mb-6">
          <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('auth.password') || 'Passwort' }}
          </label>
          <input
            v-model="deletePasswordInput"
            type="password"
            required
            :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500']"
            :placeholder="$t('auth.password') || 'Passwort'"
          />
          <p v-if="deleteAccountError" :class="['text-xs mt-2', isDark ? 'text-red-400' : 'text-red-600']">
            {{ deleteAccountError }}
          </p>
        </div>

        <!-- Buttons -->
        <div class="flex gap-4">
          <button
            @click="cancelDeleteAccount"
            :class="['group/cancel flex-1 px-6 py-4 rounded-xl font-bold text-lg transition-all duration-500 shadow-lg hover:scale-105 relative overflow-hidden backdrop-blur-md', isDark ? 'bg-gray-700/50 text-gray-300 hover:bg-gray-600/50' : 'bg-gray-200 text-gray-900 hover:bg-gray-300']"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5 transition-transform duration-500 group-hover/cancel:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="transition-all duration-500 group-hover/cancel:tracking-wide">{{ $t('account.cancelButton') }}</span>
            </span>
            <div :class="['absolute inset-0 transform scale-x-0 group-hover/cancel:scale-x-100 transition-transform duration-500 origin-left', isDark ? 'bg-gray-600/30' : 'bg-gray-300/50']"></div>
          </button>
          <button
            @click="deleteAccountConfirmed"
            class="group/delete flex-1 px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl font-bold text-lg transition-all duration-500 shadow-xl hover:shadow-2xl hover:scale-105 relative overflow-hidden"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5 transition-transform duration-500 group-hover/delete:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
              <span class="transition-all duration-500 group-hover/delete:tracking-wider">{{ $t('account.deleteAccountConfirmButton') }}</span>
            </span>
            <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover/delete:scale-x-100 transition-transform duration-500 origin-left"></div>
          </button>
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

const router = useRouter()
useI18n()
const themeStore = useThemeStore()
const authStore = useAuthStore()
const isDark = computed(() => themeStore.isDark)

// Redirect if not authenticated
onMounted(() => {
  if (!authStore.isAuthenticated) {
    router.push('/login')
  }
})

// Profile Image - Standard image is used for all users

// Personal Info
const profileForm = ref({
  name: '',
  email: '',
})
const profileError = ref('')
const profileSuccess = ref('')

onMounted(() => {
  if (authStore.user) {
    profileForm.value = {
      name: authStore.user.name,
      email: authStore.user.email,
    }
  }
})

const savePersonalInfo = async () => {
  profileError.value = ''
  profileSuccess.value = ''

  const result = await authStore.updateProfile(
    profileForm.value.name,
    profileForm.value.email
  )

  if (result.success) {
    profileSuccess.value = result.message

    // If email changed, show additional message
    if (result.emailChanged) {
      profileSuccess.value += ' Sie müssen Ihre neue E-Mail-Adresse bestätigen.'
    }

    // Auto-hide success message after 5 seconds
    setTimeout(() => {
      profileSuccess.value = ''
    }, 5000)
  } else {
    profileError.value = result.message

    // Auto-hide error message after 5 seconds
    setTimeout(() => {
      profileError.value = ''
    }, 5000)
  }
}

// Password
const passwordForm = ref({
  currentPassword: '',
  newPassword: '',
  confirmPassword: '',
})
const passwordError = ref('')
const passwordSuccess = ref('')
const showCurrentPassword = ref(false)
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)

const changePassword = async () => {
  passwordError.value = ''
  passwordSuccess.value = ''

  const result = await authStore.updatePassword(
    passwordForm.value.currentPassword,
    passwordForm.value.newPassword,
    passwordForm.value.confirmPassword
  )

  if (result.success) {
    passwordSuccess.value = result.message
    passwordForm.value = { currentPassword: '', newPassword: '', confirmPassword: '' }

    // Auto-hide success message after 3 seconds
    setTimeout(() => {
      passwordSuccess.value = ''
    }, 3000)
  } else {
    passwordError.value = result.message

    // Auto-hide error message after 5 seconds
    setTimeout(() => {
      passwordError.value = ''
    }, 5000)
  }
}

// Delete Account
const showDeleteConfirm = ref(false)
const deletePasswordInput = ref('')
const deleteAccountError = ref('')

const confirmDeleteAccount = () => {
  showDeleteConfirm.value = true
  deletePasswordInput.value = ''
  deleteAccountError.value = ''
}

const cancelDeleteAccount = () => {
  showDeleteConfirm.value = false
  deletePasswordInput.value = ''
  deleteAccountError.value = ''
}

const deleteAccountConfirmed = async () => {
  deleteAccountError.value = ''

  if (!deletePasswordInput.value) {
    deleteAccountError.value = 'Passwort ist erforderlich'
    return
  }

  const result = await authStore.deleteAccount(deletePasswordInput.value)

  if (result.success) {
    showDeleteConfirm.value = false
    // Redirect to home after 1 second
    setTimeout(() => {
      router.push('/')
    }, 1000)
  } else {
    deleteAccountError.value = result.message
  }
}

const getInitials = (fullName) => {
  if (!fullName) return '?'
  const names = fullName.split(' ')
  return names.map(n => n[0]).join('').toUpperCase().slice(0, 2)
}
</script>

