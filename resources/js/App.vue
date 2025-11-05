<template>
  <div :class="['min-h-screen flex flex-col transition-colors duration-300', isDark ? 'bg-dark-950' : 'bg-gray-50']">
    <Header />
    <EmailVerificationNotice v-if="authStore.isAuthenticated && !authStore.emailVerified" />

    <main class="flex-grow">
      <Transition
        name="page"
        mode="out-in"
      >
        <router-view :key="$route.fullPath" />
      </Transition>
    </main>

    <Footer />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useThemeStore } from './stores/themeStore'
import { useAuthStore } from './stores/authStore'
import Header from './components/Header.vue'
import Footer from './components/Footer.vue'
import EmailVerificationNotice from './components/EmailVerificationNotice.vue'

const themeStore = useThemeStore()
const authStore = useAuthStore()
const { isDark } = themeStore

onMounted(() => {
  authStore.initializeAuth()
})
</script>

<style scoped>
.page-enter-active,
.page-leave-active {
  transition: all 0.3s ease;
}

.page-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

.page-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>

