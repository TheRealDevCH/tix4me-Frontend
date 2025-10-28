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
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.firstName') }}</label>
              <input
                v-model="profileForm.firstName"
                type="text"
                :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
            </div>
            <div>
              <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.lastName') }}</label>
              <input
                v-model="profileForm.lastName"
                type="text"
                :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
            </div>
          </div>

          <div>
            <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">{{ $t('auth.email') }}</label>
            <input
              v-model="profileForm.email"
              type="email"
              :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
            />
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
            class="px-4 py-2.5 bg-primary-600 text-white rounded-lg font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:bg-primary-700"
          >
            {{ $t('account.saveChanges') || 'Änderungen speichern' }}
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
          {{ $t('account.deleteAccountConfirmTitle') }}
        </h3>

        <!-- Message -->
        <p :class="['text-sm mb-6', isDark ? 'text-gray-400' : 'text-gray-600']">
          {{ $t('account.deleteAccountConfirmMessage') }}
        </p>

        <!-- Buttons -->
        <div class="flex gap-3">
          <button
            @click="cancelDeleteAccount"
            :class="['flex-1 px-4 py-2.5 rounded-lg font-medium text-sm transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 text-gray-300 hover:bg-dark-600' : 'bg-gray-200 text-gray-900 hover:bg-gray-300']"
          >
            {{ $t('account.cancelButton') }}
          </button>
          <button
            @click="deleteAccountConfirmed"
            class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-lg font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md hover:bg-red-700"
          >
            {{ $t('account.deleteAccountConfirmButton') }}
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
  firstName: '',
  lastName: '',
  email: '',
})
const profileError = ref('')
const profileSuccess = ref('')

onMounted(() => {
  if (authStore.user) {
    profileForm.value = {
      firstName: authStore.user.firstName,
      lastName: authStore.user.lastName,
      email: authStore.user.email,
    }
  }
})

const savePersonalInfo = () => {
  profileError.value = ''
  profileSuccess.value = ''

  const result = authStore.updateProfile(
    profileForm.value.firstName,
    profileForm.value.lastName,
    profileForm.value.email
  )

  if (result.success) {
    profileSuccess.value = result.message

    // Auto-hide success message after 3 seconds
    setTimeout(() => {
      profileSuccess.value = ''
    }, 3000)
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

const changePassword = () => {
  passwordError.value = ''
  passwordSuccess.value = ''

  const result = authStore.updatePassword(
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

const confirmDeleteAccount = () => {
  showDeleteConfirm.value = true
}

const cancelDeleteAccount = () => {
  showDeleteConfirm.value = false
}

const deleteAccountConfirmed = () => {
  const result = authStore.deleteAccount()
  if (result.success) {
    showDeleteConfirm.value = false
    // Redirect to home after 1 second
    setTimeout(() => {
      router.push('/')
    }, 1000)
  }
}

const getInitials = (fullName) => {
  if (!fullName) return '?'
  const names = fullName.split(' ')
  return names.map(n => n[0]).join('').toUpperCase().slice(0, 2)
}
</script>

