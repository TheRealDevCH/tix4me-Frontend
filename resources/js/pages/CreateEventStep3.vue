<template>
  <div class="space-y-6">
    <!-- Ticket Price -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.ticketPrice') }}
        <span class="text-primary-600">*</span>
      </label>
      <input
        v-model="store.eventData.ticketPrice"
        type="number"
        step="0.01"
        min="0"
        :placeholder="$t('createEvent.ticketPricePlaceholder')"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.ticketPrice" class="text-red-500 text-sm mt-1">{{ store.errors.ticketPrice }}</p>
    </div>

    <!-- Available Tickets -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.availableTickets') }}
        <span class="text-primary-600">*</span>
      </label>
      <input
        v-model="store.eventData.availableTickets"
        type="number"
        min="1"
        :placeholder="$t('createEvent.availableTicketsPlaceholder')"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.availableTickets" class="text-red-500 text-sm mt-1">{{ store.errors.availableTickets }}</p>
    </div>

    <!-- Ticket Categories -->
    <div>
      <div class="flex items-center justify-between mb-4">
        <label :class="['block text-sm font-medium', isDark ? 'text-gray-300' : 'text-gray-700']">
          {{ $t('createEvent.ticketCategories') }}
        </label>
        <button
          type="button"
          @click="store.addTicketCategory"
          :class="['text-sm font-medium px-3 py-1 rounded-lg transition-all duration-200',
            isDark
              ? 'bg-dark-700 text-primary-400 hover:bg-dark-600'
              : 'bg-gray-200 text-primary-600 hover:bg-gray-300']"
        >
          + {{ $t('createEvent.addCategory') }}
        </button>
      </div>

      <div v-for="(category, index) in store.eventData.ticketCategories" :key="index" class="space-y-3 p-4 rounded-lg" :class="isDark ? 'bg-dark-800/50' : 'bg-gray-50'">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <input
            v-model="category.name"
            type="text"
            placeholder="z.B. VIP"
            :class="['px-3 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none text-sm',
              isDark
                ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600']"
          />
          <input
            v-model="category.price"
            type="number"
            step="0.01"
            min="0"
            placeholder="Preis"
            :class="['px-3 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none text-sm',
              isDark
                ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600']"
          />
          <input
            v-model="category.quantity"
            type="number"
            min="1"
            placeholder="Menge"
            :class="['px-3 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none text-sm',
              isDark
                ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600']"
          />
        </div>
        <button
          v-if="store.eventData.ticketCategories.length > 1"
          type="button"
          @click="store.removeTicketCategory(index)"
          :class="['text-sm font-medium px-3 py-1 rounded-lg transition-all duration-200',
            isDark
              ? 'bg-red-500/20 text-red-400 hover:bg-red-500/30'
              : 'bg-red-50 text-red-600 hover:bg-red-100']"
        >
          {{ $t('createEvent.removeCategory') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useThemeStore } from '../stores/themeStore'
import { useEventCreationStore } from '../stores/eventCreationStore'

const themeStore = useThemeStore()
const store = useEventCreationStore()
const isDark = computed(() => themeStore.isDark)
</script>

