<template>
  <div :class="['h-full border rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg hover:scale-105', isDark ? 'bg-dark-800 border-dark-700/50 hover:border-primary-600/30' : 'bg-white border-gray-200/50 hover:border-primary-600/30']">
    <!-- Image -->
    <div class="relative overflow-hidden h-40 bg-gradient-to-br from-gray-200 to-gray-300">
      <img
        :src="ticket.image"
        :alt="ticket.title"
        class="w-full h-full object-cover transition-transform duration-300 hover:scale-110"
      />

      <!-- Category Badge -->
      <div class="absolute top-3 right-3">
        <span class="px-3 py-1.5 bg-primary-600 text-white text-xs font-semibold rounded-full shadow-md">
          {{ getCategoryLabel(ticket.category) }}
        </span>
      </div>

      <!-- Availability Badge -->
      <div class="absolute bottom-3 left-3">
        <span
          :class="[
            'px-3 py-1.5 text-xs font-semibold rounded-full shadow-md',
            ticket.available > 0
              ? 'bg-green-600 text-white'
              : 'bg-red-600 text-white'
          ]"
        >
          {{ ticket.available > 0 ? $t('home.available') : $t('home.soldOut') }}
        </span>
      </div>
    </div>

    <!-- Content -->
    <div class="p-5 flex flex-col h-full">
      <!-- Title -->
      <h3 :class="['font-semibold mb-3 line-clamp-2 text-sm', isDark ? 'text-white' : 'text-gray-900']">
        {{ ticket.title }}
      </h3>

      <!-- Rating -->
      <div class="flex items-center gap-2 mb-4">
        <div class="flex gap-0.5">
          <span v-for="i in 5" :key="i" class="text-yellow-500 text-sm">★</span>
        </div>
        <span :class="['text-xs font-medium', isDark ? 'text-gray-500' : 'text-gray-600']">{{ ticket.rating }} ({{ ticket.reviews }})</span>
      </div>

      <!-- Details -->
      <div :class="['space-y-2 mb-4 text-xs flex-grow', isDark ? 'text-gray-400' : 'text-gray-600']">
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 flex-shrink-0 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          <span>{{ formatDate(ticket.date) }}</span>
        </div>
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 flex-shrink-0 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          <span class="line-clamp-1">{{ ticket.location }}</span>
        </div>
      </div>

      <!-- Price and Button -->
      <div :class="['flex items-center justify-between pt-4 border-t', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
        <div>
          <p :class="['text-xs font-medium mb-1', isDark ? 'text-gray-500' : 'text-gray-600']">{{ $t('home.price') }}</p>
          <p class="text-lg font-bold text-primary-600">€{{ ticket.price.toFixed(2) }}</p>
        </div>
        <div class="flex gap-2">
          <router-link
            :to="`/ticket/${ticket.id}`"
            :class="['px-3 py-2 text-xs font-medium rounded-lg transition-all duration-200', isDark ? 'bg-dark-700 text-white hover:bg-dark-600' : 'bg-gray-100 text-gray-900 hover:bg-gray-200']"
          >
            {{ $t('home.viewDetails') }}
          </router-link>
          <button
            @click="addToCart"
            :disabled="ticket.available === 0"
            :class="[
              'px-3 py-2 rounded-lg font-medium transition-all duration-200 flex items-center justify-center',
              ticket.available > 0
                ? 'bg-primary-600 text-white hover:bg-primary-700 shadow-sm hover:shadow-md'
                : 'bg-gray-200 text-gray-500 cursor-not-allowed opacity-50'
            ]"
            :title="ticket.available > 0 ? 'Zum Warenkorb hinzufügen' : 'Ausverkauft'"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useCartStore } from '../stores/cartStore'
import { useThemeStore } from '../stores/themeStore'

const { t } = useI18n()
const cartStore = useCartStore()
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)

const getCategoryLabel = (category) => {
  const labels = {
    music: t('home.music'),
    sports: t('home.sports'),
    theater: t('home.theater'),
    conference: t('home.conference'),
  }
  return labels[category] || category
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('de-DE', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}

const props = defineProps({
  ticket: {
    type: Object,
    required: true,
  },
})

const addToCart = () => {
  cartStore.addItem(props.ticket, 1)
}
</script>

