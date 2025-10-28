import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useCartStore = defineStore('cart', () => {
  const items = ref([])

  const addItem = (ticket, quantity = 1) => {
    const existingItem = items.value.find(item => item.id === ticket.id)
    
    if (existingItem) {
      existingItem.quantity += quantity
    } else {
      items.value.push({
        ...ticket,
        quantity,
      })
    }
  }

  const removeItem = (ticketId) => {
    items.value = items.value.filter(item => item.id !== ticketId)
  }

  const updateQuantity = (ticketId, quantity) => {
    const item = items.value.find(item => item.id === ticketId)
    if (item) {
      item.quantity = Math.max(1, quantity)
    }
  }

  const clearCart = () => {
    items.value = []
  }

  const itemCount = computed(() => {
    return items.value.reduce((total, item) => total + item.quantity, 0)
  })

  const subtotal = computed(() => {
    return items.value.reduce((total, item) => total + (item.price * item.quantity), 0)
  })

  const tax = computed(() => {
    return subtotal.value * 0.19 // 19% VAT
  })

  const shipping = computed(() => {
    return subtotal.value > 100 ? 0 : 9.99
  })

  const total = computed(() => {
    return subtotal.value + tax.value + shipping.value
  })

  return {
    items,
    addItem,
    removeItem,
    updateQuantity,
    clearCart,
    itemCount,
    subtotal,
    tax,
    shipping,
    total,
  }
})

