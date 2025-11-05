<template>
  <Transition name="fade">
    <div v-if="isVisible" class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-md" :class="isDark ? 'bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900' : 'bg-gradient-to-br from-gray-50 via-white to-gray-50'">
      <!-- Animated Background Circles -->
      <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div :class="['absolute top-1/4 left-1/4 w-96 h-96 rounded-full blur-3xl opacity-30 animate-pulse-slow', isDark ? 'bg-primary-600' : 'bg-primary-400']"></div>
        <div :class="['absolute bottom-1/4 right-1/4 w-96 h-96 rounded-full blur-3xl opacity-30 animate-pulse-slow', isDark ? 'bg-purple-600' : 'bg-purple-400']" style="animation-delay: 1s;"></div>
      </div>

      <!-- Loading Container with Modern Glassmorphism -->
      <div :class="['relative flex flex-col items-center gap-10 px-12 py-16 rounded-3xl backdrop-blur-xl transition-all duration-500 animate-scale-in', isDark ? 'bg-gray-800/60 border-2 border-gray-700/50 shadow-2xl' : 'bg-white/80 border-2 border-gray-200/50 shadow-2xl']">

        <!-- Logo Animation Container with Gradient Ring -->
        <div class="relative w-40 h-40 flex items-center justify-center">
          <!-- Rotating Gradient Ring -->
          <div class="absolute inset-0 rounded-full bg-gradient-to-r from-primary-600 via-purple-600 to-primary-600 animate-spin-slow opacity-20"></div>
          <div class="absolute inset-2 rounded-full bg-gradient-to-r from-purple-600 via-primary-600 to-purple-600 animate-spin-reverse opacity-15"></div>

          <!-- Pulsing Glow -->
          <div :class="['absolute inset-4 rounded-full blur-2xl animate-pulse-glow', isDark ? 'bg-gradient-to-r from-primary-600 to-purple-600' : 'bg-gradient-to-r from-primary-500 to-purple-500']"></div>

          <!-- Inner Circle Background -->
          <div :class="['absolute inset-6 rounded-full backdrop-blur-sm', isDark ? 'bg-gray-800/80' : 'bg-white/90']"></div>

          <!-- Logo Image with 3D effect -->
          <img
            src="/images/tix4melogooriginallogo.png"
            alt="Tix4me Logo"
            class="relative w-28 h-28 object-contain animate-logo-float drop-shadow-2xl"
          />
        </div>

        <!-- Loading Text with Gradient -->
        <div v-if="loadingText" class="flex flex-col items-center gap-5">
          <p :class="['text-xl font-bold text-center bg-gradient-to-r from-primary-600 to-purple-600 bg-clip-text text-transparent animate-text-shimmer']">
            {{ loadingText }}
          </p>

          <!-- Modern Progress Bar -->
          <div :class="['w-64 h-2 rounded-full overflow-hidden', isDark ? 'bg-gray-700/50' : 'bg-gray-200/50']">
            <div class="h-full bg-gradient-to-r from-primary-600 via-purple-600 to-primary-600 animate-progress-bar"></div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { computed } from 'vue'
import { useThemeStore } from '../stores/themeStore'

const props = defineProps({
  isVisible: {
    type: Boolean,
    default: false
  },
  loadingText: {
    type: String,
    default: 'Wird geladen...'
  }
})

const themeStore = useThemeStore()
const isDark = computed(() => themeStore.isDark)
</script>

<style scoped>
/* Logo Float Animation - 3D floating effect */
@keyframes logo-float {
  0%, 100% {
    transform: translateY(0) scale(1);
  }
  50% {
    transform: translateY(-12px) scale(1.05);
  }
}

/* Pulsing Glow Animation */
@keyframes pulse-glow {
  0%, 100% {
    opacity: 0.4;
    transform: scale(0.95);
  }
  50% {
    opacity: 0.8;
    transform: scale(1.1);
  }
}

/* Slow Pulse for Background Circles */
@keyframes pulse-slow {
  0%, 100% {
    opacity: 0.2;
    transform: scale(1);
  }
  50% {
    opacity: 0.4;
    transform: scale(1.1);
  }
}

/* Spinning Gradient Ring */
@keyframes spin-slow {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Reverse Spinning Ring */
@keyframes spin-reverse {
  from {
    transform: rotate(360deg);
  }
  to {
    transform: rotate(0deg);
  }
}

/* Text Shimmer Effect */
@keyframes text-shimmer {
  0% {
    background-position: -200% center;
  }
  100% {
    background-position: 200% center;
  }
}

/* Progress Bar Animation */
@keyframes progress-bar {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

/* Scale In Animation for Container */
@keyframes scale-in {
  from {
    opacity: 0;
    transform: scale(0.9);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

/* Apply Animations */
.animate-logo-float {
  animation: logo-float 3s ease-in-out infinite;
}

.animate-pulse-glow {
  animation: pulse-glow 2s ease-in-out infinite;
}

.animate-pulse-slow {
  animation: pulse-slow 4s ease-in-out infinite;
}

.animate-spin-slow {
  animation: spin-slow 3s linear infinite;
}

.animate-spin-reverse {
  animation: spin-reverse 4s linear infinite;
}

.animate-text-shimmer {
  background-size: 200% auto;
  animation: text-shimmer 3s linear infinite;
}

.animate-progress-bar {
  animation: progress-bar 1.5s ease-in-out infinite;
}

.animate-scale-in {
  animation: scale-in 0.5s ease-out;
}

/* Fade Transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

