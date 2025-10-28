<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 :class="['text-4xl font-bold mb-12 animate-fade-in', isDark ? 'text-white' : 'text-gray-900']">{{ $t('cart.title') }}</h1>

      <div v-if="cartStore.items.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4 animate-slide-up">
          <div
            v-for="(item, index) in cartStore.items"
            :key="item.id"
            :class="['rounded-2xl p-6 transition-all duration-300 animate-scale-in shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']"
            :style="{ 'animation-delay': `${index * 0.05}s` }"
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
        <div class="animate-slide-up" style="animation-delay: 0.1s">
          <div :class="['rounded-2xl p-8 sticky top-24 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
            <h2 :class="['text-xl font-bold mb-6', isDark ? 'text-white' : 'text-gray-900']">{{ $t('cart.orderSummary') }}</h2>

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

            <div class="flex justify-between items-center mb-8">
              <span :class="['text-lg font-bold', isDark ? 'text-white' : 'text-gray-900']">{{ $t('cart.total') }}</span>
              <span class="text-3xl font-bold text-primary-600">€{{ cartStore.total.toFixed(2) }}</span>
            </div>

            <router-link
              to="/checkout"
              class="w-full py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-300 font-bold text-center block transform hover:scale-105 active:scale-95 mb-4 shadow-sm hover:shadow-md"
            >
              {{ $t('cart.checkout') }}
            </router-link>

            <router-link
              to="/"
              :class="['w-full py-3 rounded-lg transition-all duration-300 font-medium text-center block shadow-sm hover:shadow-md', isDark ? 'bg-dark-700 text-gray-300 hover:bg-dark-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
            >
              {{ $t('cart.continueShopping') }}
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
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import { useCartStore } from '../stores/cartStore'

useI18n()
const themeStore = useThemeStore()
const cartStore = useCartStore()
const isDark = computed(() => themeStore.isDark)
</script>

