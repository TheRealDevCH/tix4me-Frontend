<template>
  <div class="space-y-6">
    <!-- Event Preview Card -->
    <div :class="['rounded-2xl overflow-hidden shadow-lg', isDark ? 'bg-dark-800' : 'bg-white']">
      <!-- Event Image -->
      <div v-if="store.eventData.imageUrl" class="w-full h-48 bg-gradient-to-br from-primary-600 to-primary-700 flex items-center justify-center">
        <img :src="store.eventData.imageUrl" :alt="store.eventData.title" class="w-full h-full object-cover" @error="imageError = true" />
      </div>
      <div v-else class="w-full h-48 bg-gradient-to-br from-primary-600 to-primary-700 flex items-center justify-center">
        <svg class="w-16 h-16 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
      </div>

      <!-- Event Details -->
      <div class="p-6 space-y-4">
        <div>
          <h2 :class="['text-2xl font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">
            {{ store.eventData.title }}
          </h2>
          <p :class="['text-sm font-medium', isDark ? 'text-primary-400' : 'text-primary-600']">
            {{ store.eventData.category }}
          </p>
        </div>

        <p :class="['text-base', isDark ? 'text-gray-300' : 'text-gray-700']">
          {{ store.eventData.description }}
        </p>

        <div class="grid grid-cols-2 gap-4 pt-4 border-t" :class="isDark ? 'border-dark-700' : 'border-gray-200'">
          <div>
            <p :class="['text-xs font-medium mb-1', isDark ? 'text-gray-500' : 'text-gray-600']">
              {{ $t('createEvent.eventDate') }}
            </p>
            <p :class="['text-sm font-semibold', isDark ? 'text-white' : 'text-gray-900']">
              {{ formatDate(store.eventData.date) }}
            </p>
          </div>
          <div>
            <p :class="['text-xs font-medium mb-1', isDark ? 'text-gray-500' : 'text-gray-600']">
              {{ $t('createEvent.eventTime') }}
            </p>
            <p :class="['text-sm font-semibold', isDark ? 'text-white' : 'text-gray-900']">
              {{ store.eventData.time }}
            </p>
          </div>
          <div>
            <p :class="['text-xs font-medium mb-1', isDark ? 'text-gray-500' : 'text-gray-600']">
              {{ $t('createEvent.eventLocation') }}
            </p>
            <p :class="['text-sm font-semibold', isDark ? 'text-white' : 'text-gray-900']">
              {{ store.eventData.location }}
            </p>
          </div>
          <div>
            <p :class="['text-xs font-medium mb-1', isDark ? 'text-gray-500' : 'text-gray-600']">
              {{ $t('createEvent.ticketPrice') }}
            </p>
            <p :class="['text-sm font-semibold', isDark ? 'text-white' : 'text-gray-900']">
              CHF {{ parseFloat(store.eventData.ticketPrice).toFixed(2) }}
            </p>
          </div>
        </div>

        <div class="pt-4 border-t" :class="isDark ? 'border-dark-700' : 'border-gray-200'">
          <p :class="['text-xs font-medium mb-2', isDark ? 'text-gray-500' : 'text-gray-600']">
            {{ $t('createEvent.availableTickets') }}
          </p>
          <div class="w-full bg-gray-300 rounded-full h-2">
            <div class="bg-primary-600 h-2 rounded-full" :style="{ width: '100%' }"></div>
          </div>
          <p :class="['text-sm font-semibold mt-2', isDark ? 'text-white' : 'text-gray-900']">
            {{ store.eventData.availableTickets }} {{ $t('createEvent.ticketsAvailable') }}
          </p>
        </div>
      </div>
    </div>

    <!-- Summary -->
    <div :class="['p-6 rounded-lg', isDark ? 'bg-dark-800/50' : 'bg-gray-50']">
      <h3 :class="['text-lg font-semibold mb-4', isDark ? 'text-white' : 'text-gray-900']">
        {{ $t('createEvent.summary') }}
      </h3>
      <div class="space-y-2 text-sm">
        <p :class="isDark ? 'text-gray-300' : 'text-gray-700'">
          <span class="font-medium">{{ $t('createEvent.ticketCategories') }}:</span> {{ store.eventData.ticketCategories.length }}
        </p>
        <p :class="isDark ? 'text-gray-300' : 'text-gray-700'">
          <span class="font-medium">{{ $t('createEvent.seatingAreas') }}:</span> {{ store.eventData.seatingPlan.sections.length }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useThemeStore } from '../stores/themeStore'
import { useEventCreationStore } from '../stores/eventCreationStore'

const themeStore = useThemeStore()
const store = useEventCreationStore()
const isDark = computed(() => themeStore.isDark)
const imageError = ref(false)

const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('de-DE', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
}
</script>

