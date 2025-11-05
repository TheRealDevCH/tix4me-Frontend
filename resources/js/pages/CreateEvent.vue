<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-gray-50']">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Page Header -->
      <div class="mb-8">
        <h1 class="text-4xl font-bold mb-2" :class="isDark ? 'text-white' : 'text-gray-900'">
          {{ $t('createEvent.title') }}
        </h1>
        <p class="text-lg" :class="isDark ? 'text-gray-400' : 'text-gray-600'">
          {{ $t('createEvent.step') }} {{ store.currentStep }} {{ $t('createEvent.of') }} 5
        </p>
      </div>

      <!-- Progress Bar -->
      <div class="mb-8">
        <div :class="['w-full h-2 rounded-full overflow-hidden', isDark ? 'bg-dark-800' : 'bg-gray-200']">
          <div
            class="h-full bg-gradient-to-r from-primary-600 to-primary-700 transition-all duration-300"
            :style="{ width: store.stepProgress + '%' }"
          />
        </div>
      </div>

      <!-- Form Card -->
      <div :class="['rounded-2xl shadow-lg backdrop-blur-sm p-8 transition-colors duration-200', isDark ? 'bg-dark-900/50 border border-dark-700/50' : 'bg-white/95 border border-gray-200/50']">
        <!-- Step 1: Basic Information -->
        <div v-if="store.currentStep === 1">
          <CreateEventStep1 />
        </div>

        <!-- Step 2: Date & Location -->
        <div v-if="store.currentStep === 2">
          <CreateEventStep2 />
        </div>

        <!-- Step 3: Tickets & Prices -->
        <div v-if="store.currentStep === 3">
          <CreateEventStep3 />
        </div>

        <!-- Step 4: Seating Plan -->
        <div v-if="store.currentStep === 4">
          <CreateEventStep4 />
        </div>

        <!-- Step 5: Preview & Publish -->
        <div v-if="store.currentStep === 5">
          <CreateEventStep5 />
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-5 pt-8 border-t-2" :class="isDark ? 'border-dark-700/50' : 'border-gray-200/50'">
          <button
            v-if="store.currentStep > 1"
            type="button"
            @click="store.previousStep"
            :class="['group/back flex-1 px-7 py-4 rounded-2xl font-bold text-lg transition-all duration-500 hover:scale-105 relative overflow-hidden backdrop-blur-md shadow-lg',
              isDark
                ? 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5 transition-transform duration-500 group-hover/back:-translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
              </svg>
              <span class="transition-all duration-500 group-hover/back:tracking-wide">{{ $t('createEvent.back') }}</span>
            </span>
            <div :class="['absolute inset-0 transform scale-x-0 group-hover/back:scale-x-100 transition-transform duration-500 origin-left', isDark ? 'bg-gray-700/30' : 'bg-gray-300/50']"></div>
          </button>

          <button
            v-if="store.currentStep < 5"
            type="button"
            @click="nextStep"
            :class="['group/next flex-1 px-7 py-4 rounded-2xl font-bold text-lg transition-all duration-500 text-white bg-gradient-to-r from-primary-600 to-purple-600 shadow-xl hover:shadow-2xl hover:scale-105 relative overflow-hidden']"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <span class="transition-all duration-500 group-hover/next:tracking-wider">{{ $t('createEvent.next') }}</span>
              <svg class="w-5 h-5 transition-transform duration-500 group-hover/next:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
              </svg>
            </span>
            <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover/next:scale-x-100 transition-transform duration-500 origin-left"></div>
          </button>

          <button
            v-if="store.currentStep === 5"
            type="button"
            @click="submitForm"
            :class="['group/publish flex-1 px-7 py-4 rounded-2xl font-bold text-lg transition-all duration-500 text-white bg-gradient-to-r from-primary-600 to-purple-600 shadow-xl hover:shadow-2xl hover:scale-105 relative overflow-hidden']"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-6 h-6 transition-transform duration-500 group-hover/publish:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="transition-all duration-500 group-hover/publish:tracking-wider">{{ $t('createEvent.publishButton') }}</span>
            </span>
            <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover/publish:scale-x-100 transition-transform duration-500 origin-left"></div>
          </button>

          <button
            type="button"
            @click="cancelForm"
            :class="['group/cancel flex-1 px-7 py-4 rounded-2xl font-bold text-lg transition-all duration-500 hover:scale-105 relative overflow-hidden backdrop-blur-md shadow-lg',
              isDark
                ? 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
          >
            <span class="relative z-10 flex items-center justify-center gap-2">
              <svg class="w-5 h-5 transition-transform duration-500 group-hover/cancel:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="transition-all duration-500 group-hover/cancel:tracking-wide">{{ $t('createEvent.cancel') }}</span>
            </span>
            <div :class="['absolute inset-0 transform scale-x-0 group-hover/cancel:scale-x-100 transition-transform duration-500 origin-left', isDark ? 'bg-gray-700/30' : 'bg-gray-300/50']"></div>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import { useAuthStore } from '../stores/authStore'
import { useEventCreationStore } from '../stores/eventCreationStore'
import CreateEventStep1 from './CreateEventStep1.vue'
import CreateEventStep2 from './CreateEventStep2.vue'
import CreateEventStep3 from './CreateEventStep3.vue'
import CreateEventStep4 from './CreateEventStep4.vue'
import CreateEventStep5 from './CreateEventStep5.vue'

const router = useRouter()
const { t: $t } = useI18n()
const themeStore = useThemeStore()
const authStore = useAuthStore()
const store = useEventCreationStore()

const isDark = computed(() => themeStore.isDark)

// Check if user is authenticated
onMounted(() => {
  if (!authStore.isAuthenticated) {
    router.push({ path: '/login', query: { redirect: '/create-event' } })
  }
  // Reset store on mount
  store.reset()
})

// Validate current step
const validateStep = () => {
  const errors = {}

  if (store.currentStep === 1) {
    if (!store.eventData.title) errors.title = $t('createEvent.errorTitleRequired')
    if (!store.eventData.description) errors.description = $t('createEvent.errorDescriptionRequired')
    if (!store.eventData.category) errors.category = $t('createEvent.errorCategoryRequired')
  } else if (store.currentStep === 2) {
    if (!store.eventData.date) errors.date = $t('createEvent.errorDateRequired')
    if (!store.eventData.time) errors.time = $t('createEvent.errorTimeRequired')
    if (!store.eventData.location) errors.location = $t('createEvent.errorLocationRequired')
  } else if (store.currentStep === 3) {
    if (!store.eventData.ticketPrice) errors.ticketPrice = $t('createEvent.errorPriceRequired')
    if (!store.eventData.availableTickets) errors.availableTickets = $t('createEvent.errorAvailableTicketsRequired')
  }

  store.setErrors(errors)
  return Object.keys(errors).length === 0
}

// Go to next step
const nextStep = () => {
  if (validateStep()) {
    store.nextStep()
  }
}

// Submit form
const submitForm = async () => {
  try {
    const token = localStorage.getItem('sessionToken')
    if (!token) {
      alert('Authentifizierungstoken nicht gefunden. Bitte melden Sie sich erneut an.')
      router.push('/login')
      return
    }

    const response = await fetch('/api/events', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
      body: JSON.stringify(store.eventData),
    })

    if (!response.ok) {
      const error = await response.json()
      console.error('Error creating event:', error)
      alert('Fehler beim Erstellen des Events: ' + (error.message || 'Unbekannter Fehler'))
      return
    }

    const event = await response.json()
    console.log('Event created successfully:', event)
    alert($t('createEvent.successMessage'))
    store.reset()
    router.push('/')
  } catch (error) {
    console.error('Error:', error)
    alert('Fehler beim Erstellen des Events: ' + error.message)
  }
}

// Cancel form
const cancelForm = () => {
  store.reset()
  router.push('/')
}
</script>

