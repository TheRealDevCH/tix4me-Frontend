import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

const DEFAULT_PROFILE_IMAGE = '/Pp.png'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const isAuthenticated = computed(() => user.value !== null)
  const rememberMe = ref(false)

  // Migrate all existing users to use the new profile image
  const migrateExistingUsers = () => {
    const usersData = localStorage.getItem('users')
    try {
      if (usersData) {
        const users = JSON.parse(usersData)
        let updated = false

        users.forEach(u => {
          // If user has no profileImage or has old Base64 image, set to default
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

  // Initialize from localStorage on store creation
  const initializeAuth = () => {
    // First, migrate existing users
    migrateExistingUsers()

    const savedUser = localStorage.getItem('currentUser')
    const savedRememberMe = localStorage.getItem('rememberMe')

    if (savedUser && savedRememberMe === 'true') {
      try {
        user.value = JSON.parse(savedUser)
        // Ensure profileImage is set
        if (!user.value.profileImage) {
          user.value.profileImage = DEFAULT_PROFILE_IMAGE
        }
      } catch (e) {
        console.error('Error parsing saved user:', e)
        localStorage.removeItem('currentUser')
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
  const register = (firstName, lastName, email, password, confirmPassword) => {
    // Validation
    if (!firstName || !lastName || !email || !password || !confirmPassword) {
      return { success: false, message: 'Alle Felder sind erforderlich' }
    }

    if (password !== confirmPassword) {
      return { success: false, message: 'Passwörter stimmen nicht überein' }
    }

    if (password.length < 6) {
      return { success: false, message: 'Passwort muss mindestens 6 Zeichen lang sein' }
    }

    // Check if email already exists
    const users = getAllUsers()
    if (users.some(u => u.email === email)) {
      return { success: false, message: 'Diese E-Mail ist bereits registriert' }
    }

    // Create new user
    const newUser = {
      id: Date.now(),
      firstName,
      lastName,
      email,
      password,
      profileImage: DEFAULT_PROFILE_IMAGE,
    }

    // Save user to users list
    users.push(newUser)
    saveAllUsers(users)

    // Auto-login the new user
    user.value = {
      id: newUser.id,
      firstName: newUser.firstName,
      lastName: newUser.lastName,
      email: newUser.email,
    }
    rememberMe.value = true
    localStorage.setItem('currentUser', JSON.stringify(user.value))
    localStorage.setItem('rememberMe', 'true')

    return { success: true, message: 'Registrierung erfolgreich! Sie sind jetzt angemeldet.' }
  }

  // Login user
  const login = (email, password, remember = false) => {
    // Validation
    if (!email || !password) {
      return { success: false, message: 'E-Mail und Passwort sind erforderlich' }
    }

    // Find user
    const users = getAllUsers()
    const foundUser = users.find(u => u.email === email && u.password === password)

    if (!foundUser) {
      return { success: false, message: 'Ungültige E-Mail oder Passwort' }
    }

    // Login user
    user.value = {
      id: foundUser.id,
      firstName: foundUser.firstName,
      lastName: foundUser.lastName,
      email: foundUser.email,
      profileImage: foundUser.profileImage || DEFAULT_PROFILE_IMAGE,
    }
    rememberMe.value = remember
    
    if (remember) {
      localStorage.setItem('currentUser', JSON.stringify(user.value))
      localStorage.setItem('rememberMe', 'true')
    } else {
      localStorage.removeItem('currentUser')
      localStorage.removeItem('rememberMe')
    }

    return { success: true, message: 'Login erfolgreich!' }
  }

  // Logout user
  const logout = () => {
    user.value = null
    rememberMe.value = false
    localStorage.removeItem('currentUser')
    localStorage.removeItem('rememberMe')
  }

  // Get user full name
  const getUserFullName = computed(() => {
    if (!user.value) return ''
    return `${user.value.firstName} ${user.value.lastName}`
  })

  // Update user profile
  const updateProfile = (firstName, lastName, email, profileImage = null) => {
    // Validation
    if (!firstName || !lastName || !email) {
      return { success: false, message: 'Alle Felder sind erforderlich' }
    }

    // Check if email already exists (for other users)
    const users = getAllUsers()
    const emailExists = users.some(u => u.email === email && u.id !== user.value.id)
    if (emailExists) {
      return { success: false, message: 'Diese E-Mail wird bereits von einem anderen Benutzer verwendet' }
    }

    // Update user in users list
    const userIndex = users.findIndex(u => u.id === user.value.id)
    if (userIndex !== -1) {
      users[userIndex].firstName = firstName
      users[userIndex].lastName = lastName
      users[userIndex].email = email
      if (profileImage !== null) {
        users[userIndex].profileImage = profileImage
      }
      saveAllUsers(users)
    }

    // Update current user
    user.value.firstName = firstName
    user.value.lastName = lastName
    user.value.email = email
    if (profileImage !== null) {
      user.value.profileImage = profileImage
    }
    localStorage.setItem('currentUser', JSON.stringify(user.value))

    return { success: true, message: 'Profil erfolgreich aktualisiert!' }
  }

  // Update password
  const updatePassword = (currentPassword, newPassword, confirmPassword) => {
    // Validation
    if (!currentPassword || !newPassword || !confirmPassword) {
      return { success: false, message: 'Alle Felder sind erforderlich' }
    }

    if (newPassword !== confirmPassword) {
      return { success: false, message: 'Neue Passwörter stimmen nicht überein' }
    }

    if (newPassword.length < 6) {
      return { success: false, message: 'Neues Passwort muss mindestens 6 Zeichen lang sein' }
    }

    // Get current user from users list
    const users = getAllUsers()
    const userIndex = users.findIndex(u => u.id === user.value.id)

    if (userIndex === -1) {
      return { success: false, message: 'Benutzer nicht gefunden' }
    }

    // Check if current password is correct
    if (users[userIndex].password !== currentPassword) {
      return { success: false, message: 'Aktuelles Passwort ist falsch' }
    }

    // Update password
    users[userIndex].password = newPassword
    saveAllUsers(users)

    return { success: true, message: 'Passwort erfolgreich geändert!' }
  }

  // Delete account
  const deleteAccount = () => {
    if (!user.value) {
      return { success: false, message: 'Kein Benutzer angemeldet' }
    }

    // Remove user from users list
    const users = getAllUsers()
    const filteredUsers = users.filter(u => u.id !== user.value.id)
    saveAllUsers(filteredUsers)

    // Logout
    logout()

    return { success: true, message: 'Konto erfolgreich gelöscht!' }
  }

  return {
    user,
    isAuthenticated,
    rememberMe,
    initializeAuth,
    register,
    login,
    logout,
    getUserFullName,
    updateProfile,
    updatePassword,
    deleteAccount,
  }
})

