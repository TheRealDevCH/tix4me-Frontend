<template>
  <Transition name="slide-down">
    <div v-if="showNotice" :class="['border-b transition-colors duration-200 mt-20', isDark ? 'bg-yellow-900/20 border-yellow-700/50' : 'bg-yellow-50 border-yellow-200']">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between gap-4">
          <!-- Icon and Message -->
          <div class="flex items-center gap-3 flex-1">
            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div class="flex-1">
              <p :class="['text-sm font-medium', isDark ? 'text-yellow-200' : 'text-yellow-800']">
                {{ $t('emailVerification.noticeTitle') }}
              </p>
              <p :class="['text-xs mt-0.5', isDark ? 'text-yellow-300' : 'text-yellow-700']">
                {{ $t('emailVerification.noticeMessage') }}
              </p>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex items-center gap-2">
            <button
              @click="resendEmail"
              :disabled="isResending || cooldownRemaining > 0"
              :class="[
                'px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200',
                isDark 
                  ? 'bg-yellow-600 hover:bg-yellow-700 text-white disabled:bg-yellow-800 disabled:text-yellow-400' 
                  : 'bg-yellow-600 hover:bg-yellow-700 text-white disabled:bg-yellow-300 disabled:text-yellow-600',
                'disabled:cursor-not-allowed'
              ]"
            >
              <span v-if="isResending" class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ $t('emailVerification.sending') }}
              </span>
              <span v-else-if="cooldownRemaining > 0">
                {{ $t('emailVerification.resendIn', { seconds: cooldownRemaining }) }}
              </span>
              <span v-else>
                {{ $t('emailVerification.resendButton') }}
              </span>
            </button>

            <button
              @click="dismissNotice"
              :class="[
                'p-2 rounded-lg transition-colors duration-200',
                isDark 
                  ? 'text-yellow-400 hover:bg-yellow-800' 
                  : 'text-yellow-600 hover:bg-yellow-100'
              ]"
              :title="$t('emailVerification.dismiss')"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useAuthStore } from '../stores/authStore'
import { useThemeStore } from '../stores/themeStore'

const authStore = useAuthStore()
const themeStore = useThemeStore()

const isDark = computed(() => themeStore.isDark)
const showNotice = ref(true)
const isResending = ref(false)
const cooldownRemaining = ref(0)
let cooldownInterval = null

const dismissNotice = () => {
  showNotice.value = false
  // Store dismissal in session storage (not persistent across sessions)
  sessionStorage.setItem('emailVerificationNoticeDismissed', 'true')
}

const resendEmail = async () => {
  if (isResending.value || cooldownRemaining.value > 0) return

  isResending.value = true
  const result = await authStore.resendVerificationEmail()
  isResending.value = false

  if (result.success) {
    // Start cooldown (60 seconds)
    cooldownRemaining.value = 60
    cooldownInterval = setInterval(() => {
      cooldownRemaining.value--
      if (cooldownRemaining.value <= 0) {
        clearInterval(cooldownInterval)
        cooldownInterval = null
      }
    }, 1000)
  }
}

onMounted(() => {
  // Check if notice was dismissed in this session
  const dismissed = sessionStorage.getItem('emailVerificationNoticeDismissed')
  if (dismissed === 'true') {
    showNotice.value = false
  }
})

onUnmounted(() => {
  if (cooldownInterval) {
    clearInterval(cooldownInterval)
  }
})
</script>

<style scoped>
.slide-down-enter-active,
.slide-down-leave-active {
  transition: all 0.3s ease;
}

.slide-down-enter-from {
  transform: translateY(-100%);
  opacity: 0;
}

.slide-down-leave-to {
  transform: translateY(-100%);
  opacity: 0;
}
</style>

