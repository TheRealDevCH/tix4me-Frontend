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
        <div class="flex gap-4 pt-8 border-t" :class="isDark ? 'border-dark-700/50' : 'border-gray-200/50'">
          <button
            v-if="store.currentStep > 1"
            type="button"
            @click="store.previousStep"
            :class="['flex-1 px-6 py-3 rounded-lg font-medium transition-all duration-200',
              isDark
                ? 'bg-dark-800 text-gray-300 hover:bg-dark-700'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
          >
            {{ $t('createEvent.back') }}
          </button>

          <button
            v-if="store.currentStep < 5"
            type="button"
            @click="nextStep"
            :class="['flex-1 px-6 py-3 rounded-lg font-medium transition-all duration-200 text-white',
              'bg-primary-600 hover:bg-primary-700 shadow-lg hover:shadow-xl']"
          >
            {{ $t('createEvent.next') }}
          </button>

          <button
            v-if="store.currentStep === 5"
            type="button"
            @click="submitForm"
            :class="['flex-1 px-6 py-3 rounded-lg font-medium transition-all duration-200 text-white',
              'bg-primary-600 hover:bg-primary-700 shadow-lg hover:shadow-xl']"
          >
            {{ $t('createEvent.publishButton') }}
          </button>

          <button
            type="button"
            @click="cancelForm"
            :class="['flex-1 px-6 py-3 rounded-lg font-medium transition-all duration-200',
              isDark
                ? 'bg-dark-800 text-gray-300 hover:bg-dark-700'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
          >
            {{ $t('createEvent.cancel') }}
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

