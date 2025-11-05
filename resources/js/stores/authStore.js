import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

const DEFAULT_PROFILE_IMAGE = '/images/Pp.png'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(null)
  const isAuthenticated = computed(() => user.value !== null && token.value !== null)
  const rememberMe = ref(false)
  const emailVerified = computed(() => user.value?.email_verified ?? false)

  const migrateExistingUsers = () => {
    const usersData = localStorage.getItem('users')
    try {
      if (usersData) {
        const users = JSON.parse(usersData)
        let updated = false

        users.forEach(u => {
          if (!u.profileImage || u.profileImage.startsWith('data:image')) {
            u.profileImage = DEFAULT_PROFILE_IMAGE
            updated = true
          }
        })

        if (updated) {
          localStorage.setItem('users', JSON.stringify(users))
          console.log('✅ User profiles migrated to default image')
        }
      }
    } catch (e) {
      console.error('Error migrating users:', e)
    }
  }

  const initializeAuth = () => {
    migrateExistingUsers()

    const savedUser = localStorage.getItem('currentUser')
    const savedToken = localStorage.getItem('authToken')
    const savedRememberMe = localStorage.getItem('rememberMe')

    if (savedUser && savedToken && savedRememberMe === 'true') {
      try {
        user.value = JSON.parse(savedUser)
        token.value = savedToken

        if (!user.value.firstName || !user.value.lastName) {
          if (user.value.name) {
            const nameParts = user.value.name.split(' ')
            user.value.firstName = nameParts[0] || ''
            user.value.lastName = nameParts.slice(1).join(' ') || ''
          }
        }

        if (!user.value.profileImage) {
          user.value.profileImage = DEFAULT_PROFILE_IMAGE
        }
        axios.defaults.headers.common['Authorization'] = `Bearer ${savedToken}`
      } catch (e) {
        console.error('Error parsing saved user:', e)
        localStorage.removeItem('currentUser')
        localStorage.removeItem('authToken')
      }
    }
  }

  // Get all users from localStorage
  const getAllUsers = () => {
    const usersData = localStorage.getItem('users')
    try {
      return usersData ? JSON.parse(usersData) : []
    } catch (e) {
      console.error('Error parsing users:', e)
      return []
    }
  }

  // Save all users to localStorage
  const saveAllUsers = (users) => {
    localStorage.setItem('users', JSON.stringify(users))
  }

  // Register a new user
  const register = async (firstName, lastName, email, password, confirmPassword) => {
    try {
      // Validation
      if (!firstName || !lastName || !email || !password || !confirmPassword) {
        return { success: false, message: 'Alle Felder sind erforderlich' }
      }

      if (password !== confirmPassword) {
        return { success: false, message: 'Passwörter stimmen nicht überein' }
      }

      if (password.length < 8) {
        return { success: false, message: 'Passwort muss mindestens 8 Zeichen lang sein' }
      }

      // Call API
      const response = await axios.post('/api/auth/register', {
        name: `${firstName} ${lastName}`,
        email,
        password,
        password_confirmation: confirmPassword
      })

      // Store token and user data
      token.value = response.data.token
      user.value = {
        id: response.data.user.id,
        firstName: firstName,
        lastName: lastName,
        email: response.data.user.email,
        email_verified: response.data.user.email_verified,
        profileImage: DEFAULT_PROFILE_IMAGE,
      }
      rememberMe.value = true

      // Save to localStorage
      localStorage.setItem('authToken', token.value)
      localStorage.setItem('currentUser', JSON.stringify(user.value))
      localStorage.setItem('rememberMe', 'true')

      // Set axios default header
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`

      return {
        success: true,
        message: response.data.message || 'Registrierung erfolgreich! Bitte überprüfen Sie Ihre E-Mail zur Verifizierung.'
      }
    } catch (error) {
      console.error('Registration error:', error)
      const message = error.response?.data?.message || 'Registrierung fehlgeschlagen'
      return { success: false, message }
    }
  }

  // Login user
  const login = async (email, password, remember = false) => {
    try {
      // Validation
      if (!email || !password) {
        return { success: false, message: 'E-Mail und Passwort sind erforderlich' }
      }

      // Call API
      const response = await axios.post('/api/auth/login', {
        email,
        password
      })

      // Store token and user data
      token.value = response.data.token
      const nameParts = response.data.user.name.split(' ')
      user.value = {
        id: response.data.user.id,
        firstName: nameParts[0] || '',
        lastName: nameParts.slice(1).join(' ') || '',
        email: response.data.user.email,
        email_verified: response.data.user.email_verified,
        profileImage: DEFAULT_PROFILE_IMAGE,
      }
      rememberMe.value = remember

      // Set axios default header
      axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`

      if (remember) {
        localStorage.setItem('authToken', token.value)
        localStorage.setItem('currentUser', JSON.stringify(user.value))
        localStorage.setItem('rememberMe', 'true')
      } else {
        localStorage.removeItem('authToken')
        localStorage.removeItem('currentUser')
        localStorage.removeItem('rememberMe')
      }

      return { success: true, message: 'Login erfolgreich!' }
    } catch (error) {
      console.error('Login error:', error)
      const message = error.response?.data?.message || 'Login fehlgeschlagen'
      return { success: false, message }
    }
  }

  // Logout user
  const logout = async () => {
    try {
      if (token.value) {
        await axios.post('/api/auth/logout')
      }
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      user.value = null
      token.value = null
      rememberMe.value = false
      localStorage.removeItem('currentUser')
      localStorage.removeItem('authToken')
      localStorage.removeItem('rememberMe')
      delete axios.defaults.headers.common['Authorization']
    }
  }

  // Get user full name
  const getUserFullName = computed(() => {
    if (!user.value) return ''
    return `${user.value.firstName} ${user.value.lastName}`
  })

  // Update user profile
  const updateProfile = async (name, email) => {
    // Validation
    if (!name || !email) {
      return { success: false, message: 'Alle Felder sind erforderlich' }
    }

    try {
      const response = await axios.put('/api/user/profile', {
        name,
        email,
      })

      // Update local user data
      user.value.name = response.data.user.name
      user.value.email = response.data.user.email
      user.value.email_verified_at = response.data.user.email_verified_at

      // If email changed, update emailVerified status
      if (response.data.email_changed) {
        emailVerified.value = false
      }

      localStorage.setItem('currentUser', JSON.stringify(user.value))

      return {
        success: true,
        message: response.data.message,
        emailChanged: response.data.email_changed
      }
    } catch (error) {
      console.error('Update profile error:', error)
      return {
        success: false,
        message: error.response?.data?.message || 'Fehler beim Aktualisieren des Profils'
      }
    }
  }

  // Update password
  const updatePassword = async (currentPassword, newPassword, confirmPassword) => {
    // Validation
    if (!currentPassword || !newPassword || !confirmPassword) {
      return { success: false, message: 'Alle Felder sind erforderlich' }
    }

    if (newPassword !== confirmPassword) {
      return { success: false, message: 'Neue Passwörter stimmen nicht überein' }
    }

    if (newPassword.length < 8) {
      return { success: false, message: 'Neues Passwort muss mindestens 8 Zeichen lang sein' }
    }

    try {
      const response = await axios.put('/api/user/password', {
        current_password: currentPassword,
        new_password: newPassword,
        new_password_confirmation: confirmPassword,
      })

      return { success: true, message: response.data.message }
    } catch (error) {
      console.error('Update password error:', error)
      return {
        success: false,
        message: error.response?.data?.message || 'Fehler beim Ändern des Passworts'
      }
    }
  }

  // Delete account
  const deleteAccount = async (password) => {
    if (!user.value) {
      return { success: false, message: 'Kein Benutzer angemeldet' }
    }

    if (!password) {
      return { success: false, message: 'Passwort ist erforderlich' }
    }

    try {
      const response = await axios.delete('/api/user/account', {
        data: { password }
      })

      // Logout
      logout()

      return { success: true, message: response.data.message }
    } catch (error) {
      console.error('Delete account error:', error)
      return {
        success: false,
        message: error.response?.data?.message || 'Fehler beim Löschen des Kontos'
      }
    }
  }

  // Resend email verification
  const resendVerificationEmail = async () => {
    try {
      const response = await axios.post('/api/auth/email/resend')
      return { success: true, message: response.data.message || 'Verifizierungs-E-Mail wurde erneut gesendet' }
    } catch (error) {
      console.error('Resend verification error:', error)
      const message = error.response?.data?.message || 'Fehler beim Senden der Verifizierungs-E-Mail'
      return { success: false, message }
    }
  }

  // Check email verification status
  const checkVerificationStatus = async () => {
    try {
      const response = await axios.get('/api/auth/email/verification-status')
      if (user.value) {
        user.value.email_verified = response.data.verified
        localStorage.setItem('currentUser', JSON.stringify(user.value))
      }
      return response.data.verified
    } catch (error) {
      console.error('Check verification status error:', error)
      return false
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    emailVerified,
    rememberMe,
    initializeAuth,
    register,
    login,
    logout,
    getUserFullName,
    updateProfile,
    updatePassword,
    deleteAccount,
    resendVerificationEmail,
    checkVerificationStatus,
  }
})

