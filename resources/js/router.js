import { createRouter, createWebHistory } from 'vue-router'
import Home from './pages/Home.vue'
import TicketDetail from './pages/TicketDetail.vue'
import Cart from './pages/Cart.vue'
import Checkout from './pages/Checkout.vue'
import Login from './pages/Login.vue'
import Register from './pages/Register.vue'
import Account from './pages/Account.vue'
import Impressum from './pages/Impressum.vue'
import Privacy from './pages/Privacy.vue'
import Terms from './pages/Terms.vue'
import ForgotPassword from './pages/ForgotPassword.vue'
import ResetPassword from './pages/ResetPassword.vue'
import CreateEvent from './pages/CreateEvent.vue'
import EmailVerify from './pages/EmailVerify.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { title: 'Tix4me - Dein Moment4me' },
  },
  {
    path: '/ticket/:id',
    name: 'TicketDetail',
    component: TicketDetail,
    meta: { title: 'Ticket Details - Tix4me' },
  },
  {
    path: '/cart',
    name: 'Cart',
    component: Cart,
    meta: { title: 'Warenkorb - Tix4me' },
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout,
    meta: { title: 'Kasse - Tix4me' },
  },
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { title: 'Anmelden - Tix4me' },
  },
  {
    path: '/register',
    name: 'Register',
    component: Register,
    meta: { title: 'Registrieren - Tix4me' },
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: ForgotPassword,
    meta: { title: 'Passwort vergessen - Tix4me' },
  },
  {
    path: '/reset-password/:token',
    name: 'ResetPassword',
    component: ResetPassword,
    meta: { title: 'Passwort zurücksetzen - Tix4me' },
  },
  {
    path: '/email/verify',
    name: 'EmailVerify',
    component: EmailVerify,
    meta: { title: 'E-Mail bestätigen - Tix4me' },
  },
  {
    path: '/account',
    name: 'Account',
    component: Account,
    meta: { title: 'Dein Konto4me - Tix4me' },
  },
  {
    path: '/impressum',
    name: 'Impressum',
    component: Impressum,
    meta: { title: 'Impressum - Tix4me' },
  },
  {
    path: '/privacy',
    name: 'Privacy',
    component: Privacy,
    meta: { title: 'Datenschutz - Tix4me' },
  },
  {
    path: '/terms',
    name: 'Terms',
    component: Terms,
    meta: { title: 'Bedingungen - Tix4me' },
  },
  {
    path: '/create-event',
    name: 'CreateEvent',
    component: CreateEvent,
    meta: { title: 'Event erstellen - Tix4me', requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

// Update page title on route change
router.afterEach((to) => {
  document.title = to.meta.title || 'Tix4me'
})

export default router

