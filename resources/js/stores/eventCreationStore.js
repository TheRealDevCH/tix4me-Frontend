import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useEventCreationStore = defineStore('eventCreation', () => {
  // Current step (1-5)
  const currentStep = ref(1)

  // Event data
  const eventData = ref({
    // Step 1: Basic Information
    title: '',
    description: '',
    category: '',
    imageUrl: '',

    // Step 2: Date & Location
    date: '',
    time: '',
    location: '',
    address: '',

    // Step 3: Tickets & Prices
    ticketPrice: '',
    availableTickets: '',
    ticketCategories: [
      { name: 'Standard', price: '', quantity: '' },
    ],

    // Step 4: Seating Plan
    seatingPlan: {
      layout: 'grid', // grid, theater, custom
      rows: 10,
      columns: 10,
      sections: [],
    },

    // Step 5: Preview
    status: 'draft',
  })

  // Validation errors
  const errors = ref({})

  // Reset store
  const reset = () => {
    currentStep.value = 1
    eventData.value = {
      title: '',
      description: '',
      category: '',
      imageUrl: '',
      date: '',
      time: '',
      location: '',
      address: '',
      ticketPrice: '',
      availableTickets: '',
      ticketCategories: [
        { name: 'Standard', price: '', quantity: '' },
      ],
      seatingPlan: {
        layout: 'grid',
        rows: 10,
        columns: 10,
        sections: [],
      },
      status: 'draft',
    }
    errors.value = {}
  }

  // Go to next step
  const nextStep = () => {
    if (currentStep.value < 5) {
      currentStep.value++
    }
  }

  // Go to previous step
  const previousStep = () => {
    if (currentStep.value > 1) {
      currentStep.value--
    }
  }

  // Go to specific step
  const goToStep = (step) => {
    if (step >= 1 && step <= 5) {
      currentStep.value = step
    }
  }

  // Update event data
  const updateEventData = (key, value) => {
    eventData.value[key] = value
  }

  // Update nested event data
  const updateNestedData = (path, value) => {
    const keys = path.split('.')
    let obj = eventData.value
    for (let i = 0; i < keys.length - 1; i++) {
      obj = obj[keys[i]]
    }
    obj[keys[keys.length - 1]] = value
  }

  // Add ticket category
  const addTicketCategory = () => {
    eventData.value.ticketCategories.push({
      name: '',
      price: '',
      quantity: '',
    })
  }

  // Remove ticket category
  const removeTicketCategory = (index) => {
    if (eventData.value.ticketCategories.length > 1) {
      eventData.value.ticketCategories.splice(index, 1)
    }
  }

  // Update ticket category
  const updateTicketCategory = (index, key, value) => {
    eventData.value.ticketCategories[index][key] = value
  }

  // Add seating section
  const addSeatingSection = () => {
    eventData.value.seatingPlan.sections.push({
      id: Date.now(),
      name: '',
      rows: 5,
      columns: 5,
      price: '',
      color: '#a0634f',
    })
  }

  // Remove seating section
  const removeSeatingSection = (id) => {
    eventData.value.seatingPlan.sections = eventData.value.seatingPlan.sections.filter(s => s.id !== id)
  }

  // Update seating section
  const updateSeatingSection = (id, key, value) => {
    const section = eventData.value.seatingPlan.sections.find(s => s.id === id)
    if (section) {
      section[key] = value
    }
  }

  // Set errors
  const setErrors = (newErrors) => {
    errors.value = newErrors
  }

  // Clear errors
  const clearErrors = () => {
    errors.value = {}
  }

  // Get step progress
  const stepProgress = computed(() => {
    return (currentStep.value / 5) * 100
  })

  // Get step title
  const stepTitle = computed(() => {
    const titles = {
      1: 'Basis-Informationen',
      2: 'Datum & Ort',
      3: 'Tickets & Preise',
      4: 'Saalplan',
      5: 'Vorschau & Veröffentlichen',
    }
    return titles[currentStep.value] || ''
  })

  return {
    currentStep,
    eventData,
    errors,
    reset,
    nextStep,
    previousStep,
    goToStep,
    updateEventData,
    updateNestedData,
    addTicketCategory,
    removeTicketCategory,
    updateTicketCategory,
    addSeatingSection,
    removeSeatingSection,
    updateSeatingSection,
    setErrors,
    clearErrors,
    stepProgress,
    stepTitle,
  }
})

