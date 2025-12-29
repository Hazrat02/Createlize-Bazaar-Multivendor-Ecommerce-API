type AuthUser = {
  id: number
  name: string
  email: string
  status: string
  roles?: string[]
}

export const useAuth = () => {
  const config = useRuntimeConfig()
  const apiBase = config.public.apiBase
  const token = useState<string | null>('auth-token', () => null)
  const user = useState<AuthUser | null>('auth-user', () => null)
  const userLoaded = useState<boolean>('auth-user-loaded', () => false)
  const loginModalOpen = useState<boolean>('login-modal-open', () => false)
  const loginModalTab = useState<string>('login-modal-tab', () => 'login')

  const getStoredToken = () => {
    if (process.server) return null
    try {
      return localStorage.getItem('auth_token')
    } catch (e) {
      return null
    }
  }

  const setStoredToken = (value: string | null) => {
    if (process.server) return
    try {
      if (value) {
        localStorage.setItem('auth_token', value)
      } else {
        localStorage.removeItem('auth_token')
      }
    } catch (e) {
      // ignore storage errors
    }
  }

  const setToken = (value: string | null) => {
    token.value = value
    setStoredToken(value)
  }

  const setLoginModal = (open: boolean, tab = 'login') => {
    loginModalTab.value = tab
    loginModalOpen.value = open
  }

  const openLoginModal = (tab = 'login') => {
    setLoginModal(true, tab)
  }

  const closeLoginModal = () => {
    loginModalOpen.value = false
  }

  const fetchUser = async () => {
    if (!token.value) {
      const stored = getStoredToken()
      if (stored) {
        token.value = stored
      } else {
        user.value = null
        userLoaded.value = true
        return
      }
    }

    try {
      const payload = await $fetch<AuthUser>(`${apiBase}/auth/me`, {
        headers: token.value ? { Authorization: `Bearer ${token.value}` } : {}
      })
      user.value = payload
    } catch (error: any) {
      const status = error?.response?.status || error?.status
      if (status === 401) {
        setToken(null)
      }
      user.value = null
    } finally {
      userLoaded.value = true
    }
  }

  const login = async (payload: { email: string; password: string; remember?: boolean }) => {
    try {
      const response: any = await $fetch(`${apiBase}/auth/login`, {
        method: 'POST',
        body: payload
      })
      setToken(response?.token || null)
      console.log('login success', { response })
      await fetchUser()
    } catch (error) {
      console.error('login failed', {
        url: `${apiBase}/auth/login`,
        payload,
        error
      })
      throw error
    }
  }

  const register = async (payload: { name: string; email: string; password: string }) => {
    try {
      const response: any = await $fetch(`${apiBase}/auth/register`, {
        method: 'POST',
        body: payload
      })
      setToken(response?.token || null)
      console.log('register success', { response })
      await fetchUser()
    } catch (error) {
      console.error('register failed', {
        url: `${apiBase}/auth/register`,
        payload,
        error
      })
      throw error
    }
  }

  const logout = async () => {
    if (token.value) {
      try {
        await $fetch(`${apiBase}/auth/logout`, {
          method: 'POST',
          headers: { Authorization: `Bearer ${token.value}` }
        })
      } catch (e) {
        // ignore
      }
    }
    user.value = null
    setToken(null)
  }

  const ensureLoggedIn = async () => {
    if (!userLoaded.value) {
      await fetchUser()
    }
    return !!user.value
  }

  const startGoogleLogin = () => {
    window.location.href = `${apiBase}/auth/google/redirect`
  }

  return {
    user,
    userLoaded,
    token,
    loginModalOpen,
    loginModalTab,
    openLoginModal,
    closeLoginModal,
    fetchUser,
    login,
    register,
    logout,
    ensureLoggedIn,
    startGoogleLogin
  }
}
