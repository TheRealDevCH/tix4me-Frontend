<template>
  <div :class="['min-h-screen transition-colors duration-200', isDark ? 'bg-dark-950' : 'bg-white']">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h1 :class="['text-4xl font-bold mb-12 animate-fade-in', isDark ? 'text-white' : 'text-gray-900']">{{ $t('checkout.title') }}</h1>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2 space-y-8 animate-slide-up">
          <!-- Personal Information -->
          <div :class="['rounded-2xl p-8 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
            <h2 :class="['text-2xl font-bold mb-6', isDark ? 'text-white' : 'text-gray-900']">{{ $t('checkout.personalInfo') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <input
                v-model="form.firstName"
                type="text"
                :placeholder="$t('checkout.firstName')"
                :class="['px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <input
                v-model="form.lastName"
                type="text"
                :placeholder="$t('checkout.lastName')"
                :class="['px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <input
                v-model="form.email"
                type="email"
                :placeholder="$t('checkout.email')"
                :class="['md:col-span-2 px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <input
                v-model="form.phone"
                type="tel"
                :placeholder="$t('checkout.phone')"
                :class="['md:col-span-2 px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
            </div>
          </div>

          <!-- Billing Address -->
          <div :class="['rounded-2xl p-8 transition-all duration-200 shadow-lg animate-slide-up', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']" style="animation-delay: 0.1s">
            <h2 :class="['text-2xl font-bold mb-6', isDark ? 'text-white' : 'text-gray-900']">{{ $t('checkout.billingAddress') }}</h2>
            <div class="space-y-4">
              <input
                v-model="form.address"
                type="text"
                :placeholder="$t('checkout.address')"
                :class="['w-full px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input
                  v-model="form.city"
                  type="text"
                  :placeholder="$t('checkout.city')"
                  :class="['px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
                />
                <input
                  v-model="form.postalCode"
                  type="text"
                  :placeholder="$t('checkout.postalCode')"
                  :class="['px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
                />
              </div>
              <input
                v-model="form.country"
                type="text"
                :placeholder="$t('checkout.country')"
                :class="['w-full px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
            </div>
          </div>

          <!-- Payment Method -->
          <div :class="['rounded-2xl p-8 transition-all duration-200 shadow-lg animate-slide-up', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']" style="animation-delay: 0.2s">
            <h2 :class="['text-2xl font-bold mb-6', isDark ? 'text-white' : 'text-gray-900']">{{ $t('checkout.paymentMethod') }}</h2>
            <div class="space-y-4">
              <input
                v-model="form.cardNumber"
                type="text"
                :placeholder="$t('checkout.cardNumber')"
                :class="['w-full px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
              />
              <div class="grid grid-cols-2 gap-4">
                <input
                  v-model="form.expiryDate"
                  type="text"
                  :placeholder="$t('checkout.expiryDate')"
                  :class="['px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
                />
                <input
                  v-model="form.cvv"
                  type="text"
                  :placeholder="$t('checkout.cvv')"
                  :class="['px-4 py-3 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-600 transition-all duration-200 shadow-sm', isDark ? 'bg-dark-700 border-dark-600 text-white placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/20' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:shadow-md focus:shadow-primary-600/10']"
                />
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-4 animate-slide-up" style="animation-delay: 0.3s">
            <router-link
              to="/cart"
              :class="['flex-1 py-3 rounded-lg transition-all duration-300 font-bold text-center shadow-sm hover:shadow-md', isDark ? 'bg-dark-700 text-gray-300 hover:bg-dark-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300']"
            >
              {{ $t('checkout.backToCart') }}
            </router-link>
            <button
              @click="placeOrder"
              class="flex-1 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-all duration-300 font-bold transform hover:scale-105 active:scale-95 shadow-sm hover:shadow-md"
            >
              {{ $t('checkout.placeOrder') }}
            </button>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="animate-slide-up" style="animation-delay: 0.1s">
          <div :class="['rounded-2xl p-8 sticky top-24 transition-all duration-200 shadow-lg', isDark ? 'bg-dark-800 border border-dark-700/50 shadow-black/20' : 'bg-white border border-gray-200/50 shadow-black/5']">
            <h2 :class="['text-xl font-bold mb-6', isDark ? 'text-white' : 'text-gray-900']">{{ $t('checkout.orderReview') }}</h2>

            <div :class="['space-y-4 mb-6 pb-6 border-b max-h-96 overflow-y-auto', isDark ? 'border-dark-700/50' : 'border-gray-200/50']">
              <div
                v-for="item in cartStore.items"
                :key="item.id"
                :class="['flex justify-between text-sm', isDark ? 'text-gray-400' : 'text-gray-600']"
              >
                <div>
                  <p :class="['font-medium', isDark ? 'text-gray-300' : 'text-gray-900']">{{ item.title }}</p>
                  <p :class="[isDark ? 'text-gray-600' : 'text-gray-500']">x{{ item.quantity }}</p>
                </div>
                <p :class="['font-medium', isDark ? 'text-gray-300' : 'text-gray-900']">€{{ (item.price * item.quantity).toFixed(2) }}</p>
              </div>
            </div>

            <div :class="['space-y-3 mb-6 pb-6 border-b', isDark ? 'border-dark-700/50 text-gray-400' : 'border-gray-200/50 text-gray-600']">
              <div class="flex justify-between">
                <span>{{ $t('cart.subtotal') }}</span>
                <span>€{{ cartStore.subtotal.toFixed(2) }}</span>
              </div>
              <div class="flex justify-between">
                <span>{{ $t('cart.tax') }}</span>
                <span>€{{ cartStore.tax.toFixed(2) }}</span>
              </div>
              <div class="flex justify-between">
                <span>{{ $t('cart.shipping') }}</span>
                <span>{{ cartStore.shipping === 0 ? 'Kostenlos' : '€' + cartStore.shipping.toFixed(2) }}</span>
              </div>
            </div>

            <div class="flex justify-between items-center">
              <span :class="['text-lg font-bold', isDark ? 'text-white' : 'text-gray-900']">{{ $t('cart.total') }}</span>
              <span class="text-3xl font-bold text-primary-600">€{{ cartStore.total.toFixed(2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import { useThemeStore } from '../stores/themeStore'
import { useCartStore } from '../stores/cartStore'

const router = useRouter()
const { t } = useI18n()
const themeStore = useThemeStore()
const cartStore = useCartStore()
const isDark = computed(() => themeStore.isDark)

const form = ref({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  postalCode: '',
  country: '',
  cardNumber: '',
  expiryDate: '',
  cvv: '',
})

const placeOrder = () => {
  // Mock order placement
  alert(t('checkout.placeOrder') + ' - ' + t('checkout.orderReview'))
  cartStore.clearCart()
  router.push('/')
}
</script>

