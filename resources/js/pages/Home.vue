<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <!-- Hero Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="mb-12">
          <h1 :class="['text-4xl md:text-5xl font-bold mb-4', isDark ? 'text-white' : 'text-gray-900']">
            <span v-if="titleVariants && titleVariants.length > 0" class="relative inline-block overflow-hidden">
              <span
                class="inline-block transition-all duration-500 ease-in-out"
                :style="{ transform: `translateY(${-currentTitleIndex * 100}%)` }"
              >
                <div v-for="(variant, index) in titleVariants" :key="index" class="h-16 md:h-20 flex items-center">
                  {{ variant.replace('4me', '') }}<span class="text-primary-600">4me</span>
                </div>
              </span>
            </span>
            <span v-else>{{ $t('home.title') }}</span>
          </h1>
          <p :class="['text-lg', isDark ? 'text-gray-400' : 'text-gray-600']">
            {{ $t('home.subtitle') }}
          </p>
        </div>

        <!-- Search Bar - Minimalist Underline Design -->
        <div class="flex gap-3 mb-8">
          <div class="flex-1 relative group">
            <input
              v-model="searchQuery"
              type="text"
              :placeholder="$t('home.searchPlaceholder')"
              :class="['w-full px-0 py-4 bg-transparent text-base focus:outline-none transition-all duration-200', isDark ? 'text-white placeholder-gray-600' : 'text-gray-900 placeholder-gray-500']"
            />
            <!-- Underline - Default State -->
            <div :class="['absolute bottom-0 left-0 right-0 h-0.5 transition-all duration-300', isDark ? 'bg-dark-700' : 'bg-gray-300']"></div>
            <!-- Underline - Focus State -->
            <div :class="['absolute bottom-0 left-0 right-0 h-1 bg-primary-600 transition-all duration-300 scale-x-0 group-focus-within:scale-x-100 origin-left', isDark ? 'shadow-lg shadow-primary-600/30' : 'shadow-md shadow-primary-600/20']"></div>
          </div>
          <button class="px-6 py-3 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-all duration-200 shadow-sm hover:shadow-md">
            {{ $t('home.searchPlaceholder') }}
          </button>
        </div>
      </div>
    </section>

    <!-- Filters Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Category Filter -->
        <div>
          <label :class="['block text-xs font-medium mb-2.5 uppercase tracking-wide', isDark ? 'text-gray-500' : 'text-gray-600']">
            {{ $t('home.filterByCategory') }}
          </label>
          <select
            v-model="selectedCategory"
            :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-800 border-dark-700 text-white focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 focus:shadow-md focus:shadow-primary-600/10']"
          >
            <option value="">{{ $t('home.allCategories') }}</option>
            <option value="music">{{ $t('home.music') }}</option>
            <option value="sports">{{ $t('home.sports') }}</option>
            <option value="theater">{{ $t('home.theater') }}</option>
            <option value="conference">{{ $t('home.conference') }}</option>
          </select>
        </div>

        <!-- Sort Filter -->
        <div>
          <label :class="['block text-xs font-medium mb-2.5 uppercase tracking-wide', isDark ? 'text-gray-500' : 'text-gray-600']">
            {{ $t('home.sortBy') }}
          </label>
          <select
            v-model="sortBy"
            :class="['w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-800 border-dark-700 text-white focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 focus:shadow-md focus:shadow-primary-600/10']"
          >
            <option value="date">{{ $t('home.dateNewest') }}</option>
            <option value="price-low">{{ $t('home.priceLowToHigh') }}</option>
            <option value="price-high">{{ $t('home.priceHighToLow') }}</option>
          </select>
        </div>

        <!-- Results Count -->
        <div class="flex items-end">
          <p :class="['text-sm font-medium', isDark ? 'text-gray-500' : 'text-gray-600']">
            {{ filteredTickets.length }} {{ $t('home.tickets') }}
          </p>
        </div>
      </div>
    </section>

    <!-- Tickets Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
      <div v-if="filteredTickets.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="ticket in filteredTickets"
          :key="ticket.id"
        >
          <TicketCard :ticket="ticket" />
        </div>
      </div>
      <div v-else class="text-center py-16">
        <svg :class="['w-12 h-12 mx-auto mb-4', isDark ? 'text-gray-700' : 'text-gray-300']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <p :class="['text-base font-medium mb-1', isDark ? 'text-gray-400' : 'text-gray-700']">{{ $t('home.noResults') }}</p>
        <p :class="['text-sm', isDark ? 'text-gray-600' : 'text-gray-500']">{{ $t('home.searchPlaceholder') }}</p>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import TicketCard from '../components/TicketCard.vue'
import { mockTickets } from '../data/mockTickets'

const { t } = useI18n()
const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)

const searchQuery = ref('')
const selectedCategory = ref('')
const sortBy = ref('date')
const currentTitleIndex = ref(0)
let titleInterval = null

const titleVariants = computed(() => {
  try {
    const variants = t('home.titleVariants')
    return Array.isArray(variants) ? variants : []
  } catch (e) {
    console.error('Error loading title variants:', e)
    return []
  }
})

onMounted(() => {
  // Start the title rotation
  titleInterval = setInterval(() => {
    const length = titleVariants.value.length
    if (length > 0) {
      currentTitleIndex.value = (currentTitleIndex.value + 1) % length
    }
  }, 3500)
})

onUnmounted(() => {
  if (titleInterval) {
    clearInterval(titleInterval)
  }
})

const filteredTickets = computed(() => {
  let tickets = mockTickets.filter(ticket => {
    const matchesSearch = ticket.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                         ticket.description.toLowerCase().includes(searchQuery.value.toLowerCase())
    const matchesCategory = !selectedCategory.value || ticket.category === selectedCategory.value
    return matchesSearch && matchesCategory
  })

  // Sort
  if (sortBy.value === 'price-low') {
    tickets.sort((a, b) => a.price - b.price)
  } else if (sortBy.value === 'price-high') {
    tickets.sort((a, b) => b.price - a.price)
  } else {
    tickets.sort((a, b) => new Date(b.date) - new Date(a.date))
  }

  return tickets
})
</script>

