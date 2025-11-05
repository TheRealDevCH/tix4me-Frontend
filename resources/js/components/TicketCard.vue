<template>
  <div :class="['group h-full rounded-3xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-3 backdrop-blur-sm', isDark ? 'bg-gray-800/50 border-2 border-gray-700/50 hover:border-primary-500/70' : 'bg-white/90 border-2 border-gray-200/50 hover:border-primary-400/70 shadow-xl']">
    <!-- Image -->
    <div class="relative overflow-hidden h-72 bg-gradient-to-br from-primary-100 to-purple-100">
      <img
        :src="ticket.image"
        :alt="ticket.title"
        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-125"
      />

      <!-- Gradient Overlay -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

      <!-- Category Badge -->
      <div class="absolute top-5 right-5 transition-all duration-500 group-hover:scale-110 group-hover:-translate-y-1">
        <span :class="['px-5 py-2.5 text-sm font-bold rounded-full shadow-xl backdrop-blur-md', isDark ? 'bg-primary-600/90 text-white' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white']">
          {{ getCategoryLabel(ticket.category) }}
        </span>
      </div>

      <!-- Availability Badge -->
      <div class="absolute bottom-5 left-5 transition-all duration-500 group-hover:scale-110 group-hover:translate-y-1">
        <span
          :class="[
            'px-5 py-2.5 text-sm font-bold rounded-full shadow-xl backdrop-blur-md',
            ticket.available > 0
              ? 'bg-green-500/90 text-white'
              : 'bg-red-500/90 text-white'
          ]"
        >
          {{ ticket.available > 0 ? $t('home.available') : $t('home.soldOut') }}
        </span>
      </div>
    </div>

    <!-- Content -->
    <div class="p-8 flex flex-col h-full">
      <!-- Title -->
      <h3 :class="['font-bold mb-5 line-clamp-2 text-xl leading-tight transition-colors duration-300 group-hover:text-primary-600', isDark ? 'text-white' : 'text-gray-900']">
        {{ ticket.title }}
      </h3>

      <!-- Rating -->
      <div class="flex items-center gap-4 mb-6">
        <div class="flex gap-1">
          <span v-for="i in 5" :key="i" class="text-yellow-400 text-lg transition-transform duration-300 group-hover:scale-110">★</span>
        </div>
        <span :class="['text-base font-semibold', isDark ? 'text-gray-400' : 'text-gray-600']">{{ ticket.rating }} <span class="font-normal">({{ ticket.reviews }})</span></span>
      </div>

      <!-- Details -->
      <div :class="['space-y-4 mb-6 text-base flex-grow', isDark ? 'text-gray-300' : 'text-gray-700']">
        <div class="flex items-center gap-4 transition-all duration-300 group-hover:translate-x-1">
          <div :class="['p-3 rounded-xl transition-all duration-300', isDark ? 'bg-gray-700/50 group-hover:bg-primary-600/20' : 'bg-primary-50 group-hover:bg-primary-100']">
            <svg class="w-6 h-6 flex-shrink-0 text-primary-600 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <span class="font-semibold">{{ formatDate(ticket.date) }}</span>
        </div>
        <div class="flex items-center gap-4 transition-all duration-300 group-hover:translate-x-1">
          <div :class="['p-3 rounded-xl transition-all duration-300', isDark ? 'bg-gray-700/50 group-hover:bg-primary-600/20' : 'bg-primary-50 group-hover:bg-primary-100']">
            <svg class="w-6 h-6 flex-shrink-0 text-primary-600 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
          </div>
          <span class="line-clamp-1 font-semibold">{{ ticket.location }}</span>
        </div>
      </div>

      <!-- Price and Button -->
      <div :class="['flex items-center justify-between pt-6 border-t-2', isDark ? 'border-gray-700/50' : 'border-gray-200/50']">
        <div>
          <p :class="['text-sm font-bold mb-2 uppercase tracking-wider', isDark ? 'text-gray-500' : 'text-gray-600']">{{ $t('home.price') }}</p>
          <p :class="['text-3xl font-extrabold bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent transition-all duration-300 group-hover:scale-110']">€{{ ticket.price.toFixed(2) }}</p>
        </div>
        <div class="flex gap-4">
          <router-link
            :to="`/ticket/${ticket.id}`"
            :class="['group/btn px-6 py-4 text-base font-bold rounded-2xl transition-all duration-500 hover:scale-110 relative overflow-hidden', isDark ? 'bg-gray-700/50 text-white hover:bg-gray-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200']"
          >
            <span class="relative z-10 flex items-center gap-2">
              <svg class="w-5 h-5 transition-transform duration-500 group-hover/btn:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              <span class="hidden md:inline">Details</span>
            </span>
            <div :class="['absolute inset-0 transform scale-x-0 group-hover/btn:scale-x-100 transition-transform duration-500 origin-left', isDark ? 'bg-gray-600/30' : 'bg-gray-300/50']"></div>
          </router-link>
          <button
            @click="addToCart"
            :disabled="ticket.available === 0"
            :class="[
              'group/add px-6 py-4 rounded-2xl font-bold transition-all duration-500 flex items-center justify-center relative overflow-hidden',
              ticket.available > 0
                ? 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl hover:shadow-2xl hover:scale-110'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed opacity-50'
            ]"
            :title="ticket.available > 0 ? 'Zum Warenkorb hinzufügen' : 'Ausverkauft'"
          >
            <span class="relative z-10 flex items-center gap-2">
              <svg class="w-6 h-6 transition-transform duration-500 group-hover/add:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              <span class="hidden md:inline transition-all duration-500 group-hover/add:tracking-wider">Kaufen</span>
            </span>
            <div v-if="ticket.available > 0" class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover/add:scale-x-100 transition-transform duration-500 origin-left"></div>
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

