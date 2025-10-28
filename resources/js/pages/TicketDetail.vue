<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <div v-if="ticket" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <!-- Back Button -->
      <router-link
        to="/"
        :class="['inline-flex items-center gap-2 transition-colors duration-200 mb-8 animate-fade-in', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']"
      >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        {{ $t('ticket.backToHome') }}
      </router-link>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Image Section -->
        <div class="lg:col-span-2 animate-slide-up">
          <div :class="['relative rounded-2xl overflow-hidden h-96 shadow-lg', isDark ? 'bg-dark-800 shadow-black/20' : 'bg-gray-200 shadow-black/5']">
            <img
              :src="ticket.image"
              :alt="ticket.title"
              class="w-full h-full object-cover"
            />
            <div :class="['absolute inset-0', isDark ? 'bg-gradient-to-t from-dark-900 via-transparent to-transparent' : 'bg-gradient-to-t from-gray-900/20 via-transparent to-transparent']"></div>
          </div>
        </div>

        <!-- Details Section -->
        <div class="animate-slide-up" style="animation-delay: 0.1s">
          <div :class="['rounded-2xl p-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
            <!-- Title -->
            <h1 :class="['text-3xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">{{ ticket.title }}</h1>

            <!-- Rating -->
            <div :class="['flex items-center gap-3 mb-6 pb-6 border-b', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
              <div class="flex gap-1">
                <span v-for="i in 5" :key="i" class="text-yellow-400 text-lg">★</span>
              </div>
              <span :class="[isDark ? 'text-gray-400' : 'text-gray-600']">{{ ticket.rating }} ({{ ticket.reviews }} {{ $t('home.tickets') }})</span>
            </div>

            <!-- Price -->
            <div class="mb-6">
              <p :class="['text-sm mb-2', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('ticket.price') }}</p>
              <p class="text-4xl font-bold text-primary-600">€{{ ticket.price.toFixed(2) }}</p>
            </div>

            <!-- Details Grid -->
            <div :class="['space-y-4 mb-8 pb-8 border-b', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
              <div>
                <p :class="['text-sm', isDark ? 'text-gray-500' : 'text-gray-500']">{{ $t('ticket.date') }}</p>
                <p :class="['font-medium', isDark ? 'text-white' : 'text-gray-900']">{{ formatDate(ticket.date) }}</p>
              </div>
              <div>
                <p :class="['text-sm', isDark ? 'text-gray-500' : 'text-gray-500']">{{ $t('ticket.time') }}</p>
                <p :class="['font-medium', isDark ? 'text-white' : 'text-gray-900']">{{ ticket.time }}</p>
              </div>
              <div>
                <p :class="['text-sm', isDark ? 'text-gray-500' : 'text-gray-500']">{{ $t('ticket.location') }}</p>
                <p :class="['font-medium', isDark ? 'text-white' : 'text-gray-900']">{{ ticket.location }}</p>
              </div>
              <div>
                <p :class="['text-sm', isDark ? 'text-gray-500' : 'text-gray-500']">{{ $t('ticket.category') }}</p>
                <p :class="['font-medium', isDark ? 'text-white' : 'text-gray-900']">{{ getCategoryLabel(ticket.category) }}</p>
              </div>
            </div>

            <!-- Availability -->
            <div class="mb-8">
              <p
                :class="[
                  'text-lg font-bold',
                  ticket.available > 0 ? 'text-green-500' : 'text-red-500'
                ]"
              >
                {{ ticket.available > 0 ? $t('ticket.available') : $t('ticket.soldOut') }}
              </p>
              <p :class="['text-sm', isDark ? 'text-gray-400' : 'text-gray-600']">{{ ticket.available }} {{ $t('home.tickets') }}</p>
            </div>

            <!-- Quantity Selector -->
            <div class="mb-8">
              <label :class="['block text-sm font-medium mb-3', isDark ? 'text-gray-400' : 'text-gray-600']">
                {{ $t('ticket.selectQuantity') }}
              </label>
              <div class="flex items-center gap-4">
                <button
                  @click="quantity = Math.max(1, quantity - 1)"
                  :disabled="ticket.available === 0"
                  :class="['w-10 h-10 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed', isDark ? 'bg-dark-700 hover:bg-dark-600' : 'bg-gray-200 hover:bg-gray-300']"
                >
                  −
                </button>
                <input
                  v-model.number="quantity"
                  type="number"
                  min="1"
                  :max="ticket.available"
                  :disabled="ticket.available === 0"
                  :class="['w-16 px-3 py-2 border rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-primary-600 disabled:opacity-50 disabled:cursor-not-allowed', isDark ? 'bg-dark-700 border-dark-600 text-white' : 'bg-white border-gray-300 text-gray-900']"
                />
                <button
                  @click="quantity = Math.min(ticket.available, quantity + 1)"
                  :disabled="ticket.available === 0"
                  :class="['w-10 h-10 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed', isDark ? 'bg-dark-700 hover:bg-dark-600' : 'bg-gray-200 hover:bg-gray-300']"
                >
                  +
                </button>
              </div>
            </div>

            <!-- Add to Cart Button -->
            <button
              @click="addToCart"
              :disabled="ticket.available === 0"
              :class="[
                'w-full py-3 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed shadow-sm hover:shadow-md',
                ticket.available > 0
                  ? 'bg-primary-600 text-white hover:bg-primary-700'
                  : isDark ? 'bg-gray-700 text-gray-500' : 'bg-gray-300 text-gray-500'
              ]"
            >
              {{ ticket.available > 0 ? $t('ticket.addToCart') : $t('ticket.soldOut') }}
            </button>
          </div>
        </div>
      </div>

      <!-- Description -->
      <div class="mt-12 animate-slide-up" style="animation-delay: 0.2s">
        <div :class="['rounded-2xl p-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
          <h2 :class="['text-2xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">{{ $t('ticket.description') }}</h2>
          <p :class="['leading-relaxed', isDark ? 'text-gray-400' : 'text-gray-600']">{{ ticket.description }}</p>
        </div>
      </div>

      <!-- Related Events -->
      <div class="mt-12 animate-slide-up" style="animation-delay: 0.3s">
        <h2 :class="['text-2xl font-bold mb-6', isDark ? 'text-white' : 'text-gray-900']">{{ $t('ticket.relatedEvents') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="relatedTicket in relatedTickets" :key="relatedTicket.id">
            <TicketCard :ticket="relatedTicket" />
          </div>
        </div>
      </div>
    </div>
    <div v-else class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <svg :class="['w-16 h-16 mx-auto mb-4', isDark ? 'text-gray-600' : 'text-gray-400']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p :class="['text-lg mb-4', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('home.noResults') }}</p>
        <router-link to="/" :class="['inline-flex items-center gap-2 transition-colors duration-200', isDark ? 'text-primary-400 hover:text-primary-300' : 'text-primary-600 hover:text-primary-700']">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          {{ $t('ticket.backToHome') }}
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import { useCartStore } from '../stores/cartStore'
import TicketCard from '../components/TicketCard.vue'
import { getTicketById, getRelatedTickets } from '../data/mockTickets'

const { t } = useI18n()
const route = useRoute()
const themeStore = useThemeStore()
const cartStore = useCartStore()
const isDark = computed(() => themeStore.isDark)

const quantity = ref(1)

const ticket = computed(() => getTicketById(route.params.id))
const relatedTickets = computed(() => getRelatedTickets(route.params.id))

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

const addToCart = () => {
  if (ticket.value) {
    cartStore.addItem(ticket.value, quantity.value)
    quantity.value = 1
  }
}
</script>

