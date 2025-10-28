<template>
  <div class="space-y-6">
    <!-- Seating Plan Layout Type -->
    <div>
      <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
        {{ $t('createEvent.seatingLayout') }}
      </label>
      <div class="grid grid-cols-3 gap-3">
        <button
          v-for="layout in ['grid', 'theater', 'custom']"
          :key="layout"
          type="button"
          @click="store.updateNestedData('seatingPlan.layout', layout)"
          :class="['px-4 py-2 rounded-lg font-medium transition-all duration-200',
            store.eventData.seatingPlan.layout === layout
              ? 'bg-primary-600 text-white shadow-lg'
              : isDark
                ? 'bg-dark-800 text-gray-300 hover:bg-dark-700'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
        >
          {{ $t(`createEvent.layout${layout.charAt(0).toUpperCase() + layout.slice(1)}`) }}
        </button>
      </div>
    </div>

    <!-- Grid Configuration -->
    <div v-if="store.eventData.seatingPlan.layout === 'grid'" class="space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('createEvent.rows') }}
          </label>
          <input
            v-model.number="store.eventData.seatingPlan.rows"
            type="number"
            min="1"
            max="50"
            :class="['w-full px-4 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none',
              isDark
                ? 'bg-dark-800 border-dark-700 text-white focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 focus:border-primary-600']"
          />
        </div>
        <div>
          <label :class="['block text-sm font-medium mb-2', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('createEvent.columns') }}
          </label>
          <input
            v-model.number="store.eventData.seatingPlan.columns"
            type="number"
            min="1"
            max="50"
            :class="['w-full px-4 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none',
              isDark
                ? 'bg-dark-800 border-dark-700 text-white focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 focus:border-primary-600']"
          />
        </div>
      </div>

      <!-- Grid Preview -->
      <div :class="['p-4 rounded-lg', isDark ? 'bg-dark-800/50' : 'bg-gray-50']">
        <p :class="['text-sm font-medium mb-3', isDark ? 'text-gray-300' : 'text-gray-700']">
          {{ $t('createEvent.preview') }}: {{ store.eventData.seatingPlan.rows * store.eventData.seatingPlan.columns }} {{ $t('createEvent.seats') }}
        </p>
        <div class="grid gap-1" :style="{ gridTemplateColumns: `repeat(${Math.min(store.eventData.seatingPlan.columns, 10)}, minmax(0, 1fr))` }">
          <div
            v-for="i in Math.min(store.eventData.seatingPlan.rows * store.eventData.seatingPlan.columns, 100)"
            :key="i"
            :class="['w-6 h-6 rounded-sm', isDark ? 'bg-primary-600/50' : 'bg-primary-200']"
          />
        </div>
      </div>
    </div>

    <!-- Seating Sections -->
    <div>
      <div class="flex items-center justify-between mb-4">
        <label :class="['block text-sm font-medium', isDark ? 'text-gray-300' : 'text-gray-700']">
          {{ $t('createEvent.seatingAreas') }}
        </label>
        <button
          type="button"
          @click="store.addSeatingSection"
          :class="['text-sm font-medium px-3 py-1 rounded-lg transition-all duration-200',
            isDark
              ? 'bg-dark-700 text-primary-400 hover:bg-dark-600'
              : 'bg-gray-200 text-primary-600 hover:bg-gray-300']"
        >
          + {{ $t('createEvent.addArea') }}
        </button>
      </div>

      <div v-for="section in store.eventData.seatingPlan.sections" :key="section.id" class="space-y-3 p-4 rounded-lg" :class="isDark ? 'bg-dark-800/50' : 'bg-gray-50'">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <input
            v-model="section.name"
            type="text"
            placeholder="z.B. Sektor A"
            :class="['px-3 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none text-sm',
              isDark
                ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600']"
          />
          <input
            v-model="section.price"
            type="number"
            step="0.01"
            min="0"
            placeholder="Preis"
            :class="['px-3 py-2 rounded-lg border-2 transition-all duration-200 focus:outline-none text-sm',
              isDark
                ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:border-primary-600'
                : 'bg-white border-gray-300 text-gray-900 placeholder-gray-400 focus:border-primary-600']"
          />
        </div>
        <button
          type="button"
          @click="store.removeSeatingSection(section.id)"
          :class="['text-sm font-medium px-3 py-1 rounded-lg transition-all duration-200',
            isDark
              ? 'bg-red-500/20 text-red-400 hover:bg-red-500/30'
              : 'bg-red-50 text-red-600 hover:bg-red-100']"
        >
          {{ $t('createEvent.removeArea') }}
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

