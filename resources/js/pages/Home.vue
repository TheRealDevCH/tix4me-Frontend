<template>
  <div :class="['min-h-screen transition-colors duration-300', isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-50']">
    <!-- Hero Section with Fade-In Animation -->
    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
      <!-- Animated Background Gradient -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div :class="['absolute -top-40 -right-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-primary-600' : 'bg-primary-400']"></div>
        <div :class="['absolute -bottom-40 -left-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-purple-600' : 'bg-purple-400']" style="animation-delay: 1s;"></div>
      </div>

      <div class="max-w-7xl mx-auto relative z-10">
        <!-- Title with Fade-In (delay: 0ms) -->
        <div
          class="mb-12 transition-all duration-1000 ease-out"
          :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <h1 :class="['text-5xl md:text-7xl font-extrabold mb-6 leading-tight', isDark ? 'text-white' : 'text-gray-900']">
            <span v-if="titleVariants && titleVariants.length > 0" class="relative inline-block overflow-hidden h-20 md:h-28">
              <TransitionGroup name="slide-up">
                <div
                  v-for="(variant, index) in titleVariants"
                  :key="index"
                  v-show="currentTitleIndex === index"
                  class="absolute inset-0 flex items-center"
                >
                  {{ variant.replace('4me', '') }}<span :class="['bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent']">4me</span>
                </div>
              </TransitionGroup>
            </span>
            <span v-else>{{ $t('home.title') }}</span>
          </h1>
          <p :class="['text-xl md:text-2xl font-light', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('home.subtitle') }}
          </p>
        </div>

        <!-- Search Bar with Fade-In (delay: 200ms) -->
        <div
          class="mb-12 transition-all duration-1000 ease-out"
          :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          style="transition-delay: 200ms;"
        >
          <div class="flex gap-6">
            <div class="flex-1 relative group">
              <div :class="['relative rounded-3xl overflow-hidden backdrop-blur-sm transition-all duration-500 group-hover:scale-[1.02]', isDark ? 'bg-gray-800/50 border-2 border-gray-700 group-hover:border-gray-600' : 'bg-white/80 border-2 border-gray-200 shadow-xl group-hover:border-gray-300']">
                <input
                  v-model="searchQuery"
                  type="text"
                  :placeholder="$t('home.searchPlaceholder')"
                  :class="['w-full px-8 py-7 bg-transparent text-xl focus:outline-none transition-all duration-300', isDark ? 'text-white placeholder-gray-500' : 'text-gray-900 placeholder-gray-400']"
                />
                <div :class="['absolute inset-0 rounded-3xl ring-2 ring-transparent group-focus-within:ring-primary-500 transition-all duration-500 pointer-events-none']"></div>
              </div>
            </div>
            <button
              :class="['px-10 py-7 rounded-3xl text-xl font-bold transition-all duration-500 transform hover:scale-110 hover:shadow-2xl group relative overflow-hidden', isDark ? 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-lg shadow-primary-600/30' : 'bg-gradient-to-r from-primary-600 to-purple-600 text-white shadow-xl shadow-primary-600/40']"
            >
              <span class="relative z-10 flex items-center gap-2">
                <svg class="w-7 h-7 transition-transform duration-500 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="hidden md:inline transition-all duration-500 group-hover:tracking-wider">Suchen</span>
              </span>
              <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Filters Section with Fade-In (delay: 400ms) -->
    <section
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 transition-all duration-1000 ease-out"
      :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
      style="transition-delay: 400ms;"
    >
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Category Filter -->
        <div class="group">
          <label :class="['block text-base font-bold mb-4 uppercase tracking-wider', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('home.filterByCategory') }}
          </label>
          <div class="relative">
            <select
              v-model="selectedCategory"
              :class="['w-full px-7 py-6 rounded-2xl text-lg font-medium focus:outline-none transition-all duration-500 appearance-none cursor-pointer backdrop-blur-sm group-hover:scale-[1.02]', isDark ? 'bg-gray-800/50 border-2 border-gray-700 text-white hover:border-primary-500 focus:border-primary-500 focus:shadow-lg focus:shadow-primary-600/20' : 'bg-white/80 border-2 border-gray-200 text-gray-900 hover:border-primary-400 focus:border-primary-500 focus:shadow-xl focus:shadow-primary-600/10']"
            >
              <option value="">{{ $t('home.allCategories') }}</option>
              <option value="music">{{ $t('home.music') }}</option>
              <option value="sports">{{ $t('home.sports') }}</option>
              <option value="theater">{{ $t('home.theater') }}</option>
              <option value="conference">{{ $t('home.conference') }}</option>
            </select>
            <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none transition-transform duration-500 group-hover:rotate-180">
              <svg class="w-6 h-6 text-gray-400 group-hover:text-primary-500 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>

        <!-- Sort Filter -->
        <div class="group">
          <label :class="['block text-base font-bold mb-4 uppercase tracking-wider', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ $t('home.sortBy') }}
          </label>
          <div class="relative">
            <select
              v-model="sortBy"
              :class="['w-full px-7 py-6 rounded-2xl text-lg font-medium focus:outline-none transition-all duration-500 appearance-none cursor-pointer backdrop-blur-sm group-hover:scale-[1.02]', isDark ? 'bg-gray-800/50 border-2 border-gray-700 text-white hover:border-primary-500 focus:border-primary-500 focus:shadow-lg focus:shadow-primary-600/20' : 'bg-white/80 border-2 border-gray-200 text-gray-900 hover:border-primary-400 focus:border-primary-500 focus:shadow-xl focus:shadow-primary-600/10']"
            >
              <option value="date">{{ $t('home.dateNewest') }}</option>
              <option value="price-low">{{ $t('home.priceLowToHigh') }}</option>
              <option value="price-high">{{ $t('home.priceHighToLow') }}</option>
            </select>
            <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none transition-transform duration-500 group-hover:rotate-180">
              <svg class="w-6 h-6 text-gray-400 group-hover:text-primary-500 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tickets Grid with Staggered Fade-In -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
      <div v-if="filteredTickets.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(ticket, index) in filteredTickets"
          :key="ticket.id"
          class="transition-all duration-1000 ease-out"
          :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
          :style="{ transitionDelay: `${600 + index * 100}ms` }"
        >
          <TicketCard :ticket="ticket" />
        </div>
      </div>
      <div
        v-else
        class="text-center py-24 transition-all duration-1000 ease-out"
        :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        style="transition-delay: 600ms;"
      >
        <div :class="['inline-flex items-center justify-center w-24 h-24 rounded-full mb-6', isDark ? 'bg-gray-800/50' : 'bg-gray-100']">
          <svg :class="['w-12 h-12', isDark ? 'text-gray-600' : 'text-gray-400']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
          </svg>
        </div>
        <p :class="['text-2xl font-bold mb-2', isDark ? 'text-gray-300' : 'text-gray-800']">{{ $t('home.noResults') }}</p>
        <p :class="['text-lg', isDark ? 'text-gray-500' : 'text-gray-600']">{{ $t('home.searchPlaceholder') }}</p>
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
const isLoaded = ref(false)
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
  // Trigger fade-in animations
  setTimeout(() => {
    isLoaded.value = true
  }, 100)

  // Start the title rotation (every 7 seconds)
  titleInterval = setInterval(() => {
    const length = titleVariants.value.length
    if (length > 0) {
      currentTitleIndex.value = (currentTitleIndex.value + 1) % length
    }
  }, 7000)
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

<style scoped>
/* Slide-up animation for title transitions */
.slide-up-enter-active {
  transition: all 1.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.slide-up-leave-active {
  transition: all 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.slide-up-enter-from {
  opacity: 0;
  transform: translateY(100%);
}

.slide-up-leave-to {
  opacity: 0;
  transform: translateY(-100%);
}

.slide-up-enter-to,
.slide-up-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>

