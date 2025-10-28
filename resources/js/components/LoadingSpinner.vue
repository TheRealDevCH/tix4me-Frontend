<template>
  <Transition name="fade">
    <div v-if="isVisible" class="fixed inset-0 flex items-center justify-center z-50 backdrop-blur-sm" :class="isDark ? 'bg-dark-950/40' : 'bg-white/40'">
      <!-- Loading Container with Glassmorphism -->
      <div :class="['flex flex-col items-center gap-8 px-8 py-12 rounded-2xl backdrop-blur-md transition-all duration-300', isDark ? 'bg-dark-800/50 border border-dark-700/50 shadow-2xl shadow-black/20' : 'bg-white/50 border border-white/60 shadow-2xl shadow-black/5']">

        <!-- Logo Animation Container -->
        <div class="relative w-28 h-28 sm:w-32 sm:h-32 flex items-center justify-center">
          <!-- Animated Rings (subtle background animation) -->
          <div class="absolute inset-0 rounded-full border border-primary-600/20 animate-ring-1"></div>
          <div class="absolute inset-2 rounded-full border border-primary-600/10 animate-ring-2"></div>

          <!-- Glow Background (subtle) -->
          <div :class="['absolute inset-0 rounded-full blur-3xl opacity-40 animate-logo-glow', isDark ? 'bg-primary-600/30' : 'bg-primary-600/20']"></div>

          <!-- Logo Image with smooth animation -->
          <img
            src="/tix4melogooriginallogo.png"
            alt="Tix4me Logo"
            class="relative w-20 h-20 sm:w-24 sm:h-24 object-contain animate-logo-pulse"
          />
        </div>

        <!-- Loading Text with subtle animation -->
        <div v-if="loadingText" class="flex flex-col items-center gap-3">
          <p :class="['text-sm font-medium text-center', isDark ? 'text-gray-300' : 'text-gray-700']">
            {{ loadingText }}
          </p>
          <!-- Animated dots -->
          <div class="flex gap-1.5">
            <span :class="['w-1.5 h-1.5 rounded-full animate-dot-1', isDark ? 'bg-primary-600/60' : 'bg-primary-600/50']"></span>
            <span :class="['w-1.5 h-1.5 rounded-full animate-dot-2', isDark ? 'bg-primary-600/60' : 'bg-primary-600/50']"></span>
            <span :class="['w-1.5 h-1.5 rounded-full animate-dot-3', isDark ? 'bg-primary-600/60' : 'bg-primary-600/50']"></span>
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
/* Smooth Logo Pulse Animation */
@keyframes logo-pulse {
  0% {
    transform: scale(0.98);
    opacity: 0.85;
  }
  50% {
    transform: scale(1.02);
    opacity: 1;
  }
  100% {
    transform: scale(0.98);
    opacity: 0.85;
  }
}

/* Subtle Glow Animation */
@keyframes logo-glow {
  0%, 100% {
    transform: scale(1);
    opacity: 0.35;
  }
  50% {
    transform: scale(1.15);
    opacity: 0.6;
  }
}

/* Ring Animations - Subtle rotating rings */
@keyframes ring-1 {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

@keyframes ring-2 {
  from {
    transform: rotate(360deg);
  }
  to {
    transform: rotate(0deg);
  }
}

/* Animated Dots */
@keyframes dot-bounce {
  0%, 100% {
    opacity: 0.4;
    transform: translateY(0);
  }
  50% {
    opacity: 1;
    transform: translateY(-4px);
  }
}

/* Fade Transition */
@keyframes fade-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes fade-out {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
  }
}

.animate-logo-pulse {
  animation: logo-pulse 1.8s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-logo-glow {
  animation: logo-glow 2.4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.animate-ring-1 {
  animation: ring-1 8s linear infinite;
}

.animate-ring-2 {
  animation: ring-2 12s linear infinite;
}

.animate-dot-1 {
  animation: dot-bounce 1.4s ease-in-out infinite;
  animation-delay: 0s;
}

.animate-dot-2 {
  animation: dot-bounce 1.4s ease-in-out infinite;
  animation-delay: 0.2s;
}

.animate-dot-3 {
  animation: dot-bounce 1.4s ease-in-out infinite;
  animation-delay: 0.4s;
}

/* Fade Transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>

