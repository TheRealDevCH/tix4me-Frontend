import { defineStore } from 'pinia'
import { ref, watch } from 'vue'

export const useThemeStore = defineStore('theme', () => {
  // Initialize theme from localStorage or default to 'dark'
  const savedTheme = localStorage.getItem('theme') || 'dark'
  const isDark = ref(savedTheme === 'dark')

  // Watch for changes and update localStorage
  watch(isDark, (newValue) => {
    const theme = newValue ? 'dark' : 'light'
    localStorage.setItem('theme', theme)
    
    // Update document class for Tailwind dark mode
    if (newValue) {
      document.documentElement.classList.add('dark')
      document.documentElement.classList.remove('light')
    } else {
      document.documentElement.classList.add('light')
      document.documentElement.classList.remove('dark')
    }
  })

  // Initialize document class on store creation
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    document.documentElement.classList.remove('light')
  } else {
    document.documentElement.classList.add('light')
    document.documentElement.classList.remove('dark')
  }

  const toggleTheme = () => {
    isDark.value = !isDark.value
  }

  const setTheme = (theme) => {
    isDark.value = theme === 'dark'
  }

  return {
    isDark,
    toggleTheme,
    setTheme,
  }
})

