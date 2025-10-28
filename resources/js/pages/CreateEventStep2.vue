<template>
  <div class="space-y-6">
    <!-- Event Date -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventDate') }}
        <span class="text-primary-600">*</span>
      </label>
      <input
        v-model="store.eventData.date"
        type="date"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.date" class="text-red-500 text-sm mt-1">{{ store.errors.date }}</p>
    </div>

    <!-- Event Time -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventTime') }}
        <span class="text-primary-600">*</span>
      </label>
      <input
        v-model="store.eventData.time"
        type="time"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.time" class="text-red-500 text-sm mt-1">{{ store.errors.time }}</p>
    </div>

    <!-- Event Location -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventLocation') }}
        <span class="text-primary-600">*</span>
      </label>
      <input
        v-model="store.eventData.location"
        type="text"
        :placeholder="$t('createEvent.eventLocationPlaceholder')"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.location" class="text-red-500 text-sm mt-1">{{ store.errors.location }}</p>
    </div>

    <!-- Event Address (Optional) -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventAddress') }}
      </label>
      <input
        v-model="store.eventData.address"
        type="text"
        :placeholder="$t('createEvent.eventAddressPlaceholder')"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p :class="['text-xs mt-1', isDark ? 'text-gray-500' : 'text-gray-500']">
        {{ $t('createEvent.eventAddressInfo') }}
      </p>
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

