<template>
  <div class="space-y-6">
    <!-- Event Title -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventTitle') }}
        <span class="text-primary-600">*</span>
      </label>
      <input
        v-model="store.eventData.title"
        type="text"
        :placeholder="$t('createEvent.eventTitlePlaceholder')"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.title" class="text-red-500 text-sm mt-1">{{ store.errors.title }}</p>
    </div>

    <!-- Event Description -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventDescription') }}
        <span class="text-primary-600">*</span>
      </label>
      <textarea
        v-model="store.eventData.description"
        :placeholder="$t('createEvent.eventDescriptionPlaceholder')"
        rows="4"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none resize-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p v-if="store.errors.description" class="text-red-500 text-sm mt-1">{{ store.errors.description }}</p>
    </div>

    <!-- Event Category -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventCategory') }}
        <span class="text-primary-600">*</span>
      </label>
      <select
        v-model="store.eventData.category"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      >
        <option value="">{{ $t('createEvent.selectCategory') }}</option>
        <option value="music">{{ $t('home.music') }}</option>
        <option value="sports">{{ $t('home.sports') }}</option>
        <option value="theater">{{ $t('home.theater') }}</option>
        <option value="conference">{{ $t('home.conference') }}</option>
      </select>
      <p v-if="store.errors.category" class="text-red-500 text-sm mt-1">{{ store.errors.category }}</p>
    </div>

    <!-- Event Image URL -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.eventImageUrl') }}
      </label>
      <input
        v-model="store.eventData.imageUrl"
        type="url"
        :placeholder="$t('createEvent.eventImageUrlPlaceholder')"
        :class="['w-full px-4 py-3 rounded-lg border-2 transition-all duration-200 focus:outline-none',
          isDark
            ? 'bg-dark-800 border-dark-700 text-white placeholder-gray-500 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20'
            : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600 focus:ring-2 focus:ring-primary-600/20']"
      />
      <p :class="['text-xs mt-1', isDark ? 'text-gray-500' : 'text-gray-500']">
        {{ $t('createEvent.eventImageUrlInfo') }}
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

