<template>
  <div :class="['min-h-screen transition-colors duration-300 relative overflow-hidden', isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-50']">
    <!-- Animated Background Gradient -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
      <div :class="['absolute -top-40 -right-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-primary-600' : 'bg-primary-400']"></div>
      <div :class="['absolute -bottom-40 -left-40 w-80 h-80 rounded-full blur-3xl opacity-20 animate-pulse', isDark ? 'bg-purple-600' : 'bg-purple-400']" style="animation-delay: 1s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-32 relative z-10">
      <h1
        :class="['text-5xl md:text-6xl font-extrabold mb-12 transition-all duration-1000 ease-out bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent', isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8']"
      >{{ $t('cart.title') }}</h1>

      <div
        v-if="cartStore.items.length > 0"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8 transition-all duration-1000 ease-out"
        :class="isLoaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        style="transition-delay: 200ms;"
      >
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-6">
          <div
            v-for="(item, index) in cartStore.items"
            :key="item.id"
            :class="['rounded-2xl p-8 transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl backdrop-blur-md', isDark ? 'bg-gray-800/50 border border-gray-700/50 shadow-xl' : 'bg-white/90 border border-gray-200/50 shadow-xl']"
          >
            <div class="flex gap-6">
              <!-- Image -->
              <div :class="['w-24 h-24 rounded-lg overflow-hidden flex-shrink-0', isDark ? 'bg-dark-700' : 'bg-gray-200']">
                <img
                  :src="item.image"
                  :alt="item.title"
                  class="w-full h-full object-cover"
                />
              </div>

              <!-- Details -->
              <div class="flex-grow">
                <h3 :class="['text-lg font-bold mb-2', isDark ? 'text-white' : 'text-gray-900']">{{ item.title }}</h3>
                <p :class="['text-sm mb-3', isDark ? 'text-gray-400' : 'text-gray-600']">{{ item.location }}</p>
                <p class="text-primary-600 font-bold">€{{ item.price.toFixed(2) }}</p>
              </div>

              <!-- Quantity & Remove -->
              <div class="flex flex-col items-end justify-between">
                <button
                  @click="cartStore.removeItem(item.id)"
                  :class="['transition-colors duration-200', isDark ? 'text-gray-400 hover:text-red-400' : 'text-gray-500 hover:text-red-600']"
                >
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>

                <div class="flex items-center gap-2">
                  <button
                    @click="cartStore.updateQuantity(item.id, item.quantity - 1)"
                    :class="['w-8 h-8 rounded-lg transition-colors duration-200 font-medium', isDark ? 'bg-dark-700 hover:bg-dark-600 text-gray-300' : 'bg-gray-200 hover:bg-gray-300 text-gray-700']"
                  >
                    −
                  </button>
                  <span :class="['w-8 text-center font-medium', isDark ? 'text-white' : 'text-gray-900']">{{ item.quantity }}</span>
                  <button
                    @click="cartStore.updateQuantity(item.id, item.quantity + 1)"
                    :class="['w-8 h-8 rounded-lg transition-colors duration-200 font-medium', isDark ? 'bg-dark-700 hover:bg-dark-600 text-gray-300' : 'bg-gray-200 hover:bg-gray-300 text-gray-700']"
                  >
                    +
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div>
          <div :class="['rounded-2xl p-10 sticky top-32 transition-all duration-300 backdrop-blur-md', isDark ? 'bg-gray-800/50 border border-gray-700/50 shadow-2xl' : 'bg-white/90 border border-gray-200/50 shadow-2xl']">
            <h2 :class="['text-2xl font-extrabold mb-8 bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent']">{{ $t('cart.orderSummary') }}</h2>

            <div :class="['space-y-4 mb-6 pb-6 border-b', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
              <div :class="['flex justify-between', isDark ? 'text-gray-400' : 'text-gray-600']">
                <span>{{ $t('cart.subtotal') }}</span>
                <span>€{{ cartStore.subtotal.toFixed(2) }}</span>
              </div>
              <div :class="['flex justify-between', isDark ? 'text-gray-400' : 'text-gray-600']">
                <span>{{ $t('cart.tax') }} (19%)</span>
                <span>€{{ cartStore.tax.toFixed(2) }}</span>
              </div>
              <div :class="['flex justify-between', isDark ? 'text-gray-400' : 'text-gray-600']">
                <span>{{ $t('cart.shipping') }}</span>
                <span>
                  {{ cartStore.shipping === 0 ? $t('home.available') : '€' + cartStore.shipping.toFixed(2) }}
                </span>
              </div>
            </div>

            <div class="flex justify-between items-center mb-10">
              <span :class="['text-xl font-bold', isDark ? 'text-white' : 'text-gray-900']">{{ $t('cart.total') }}</span>
              <span class="text-4xl font-extrabold bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent">€{{ cartStore.total.toFixed(2) }}</span>
            </div>

            <router-link
              to="/checkout"
              class="group w-full py-5 bg-gradient-to-r from-primary-600 to-purple-600 text-white rounded-2xl hover:scale-110 transition-all duration-500 font-bold text-center block mb-5 shadow-xl hover:shadow-2xl text-xl relative overflow-hidden"
            >
              <span class="relative z-10 flex items-center justify-center gap-3">
                <svg class="w-7 h-7 transition-transform duration-500 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                <span class="transition-all duration-500 group-hover:tracking-wider">{{ $t('cart.checkout') }}</span>
              </span>
              <div class="absolute inset-0 bg-white/20 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </router-link>

            <router-link
              to="/"
              :class="['group w-full py-5 rounded-2xl transition-all duration-500 font-bold text-center block backdrop-blur-md text-lg relative overflow-hidden hover:scale-105', isDark ? 'bg-gray-700/50 text-gray-300 hover:bg-gray-600/50' : 'bg-white/80 text-gray-700 hover:bg-white shadow-lg']"
            >
              <span class="relative z-10 flex items-center justify-center gap-3">
                <svg class="w-6 h-6 transition-transform duration-500 group-hover:-translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="transition-all duration-500 group-hover:tracking-wide">{{ $t('cart.continueShopping') }}</span>
              </span>
              <div :class="['absolute inset-0 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left', isDark ? 'bg-gray-600/30' : 'bg-gray-200/50']"></div>
            </router-link>
          </div>
        </div>
      </div>

      <!-- Empty Cart -->
      <div v-else class="text-center py-20 animate-fade-in">
        <svg :class="['w-24 h-24 mx-auto mb-6', isDark ? 'text-gray-700' : 'text-gray-300']" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <p :class="['text-lg mb-8', isDark ? 'text-gray-400' : 'text-gray-600']">{{ $t('cart.empty') }}</p>
        <router-link
          to="/"
          class="inline-block px-8 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-300 font-bold transform hover:scale-105 active:scale-95 shadow-sm hover:shadow-md"
        >
          {{ $t('cart.continueShoppingButton') }}
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import { useCartStore } from '../stores/cartStore'

useI18n()
const themeStore = useThemeStore()
const cartStore = useCartStore()
const isDark = computed(() => themeStore.isDark)
const isLoaded = ref(false)

onMounted(() => {
  setTimeout(() => {
    isLoaded.value = true
  }, 100)
})
</script>

