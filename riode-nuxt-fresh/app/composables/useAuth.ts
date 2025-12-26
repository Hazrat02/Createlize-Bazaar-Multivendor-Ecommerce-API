type AuthUser = {
  id: number
  name: string
  email: string
  status: string
  roles?: string[]
}

const getBackendBase = (apiBase: string) => apiBase.replace(/\/api\/v2\/?$/, '')

export const useAuth = () => {
  const config = useRuntimeConfig()
  const apiBase = config.public.apiBase
  const backendBase = getBackendBase(apiBase)
  const user = useState<AuthUser | null>('auth-user', () => null)
  const userLoaded = useState<boolean>('auth-user-loaded', () => false)
  const loginModalOpen = useState<boolean>('login-modal-open', () => false)
  const loginModalTab = useState<string>('login-modal-tab', () => 'login')

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

  const fetchCsrf = async () => {
    await $fetch(`${backendBase}/sanctum/csrf-cookie`, {
      credentials: 'include'
    })
  }

  const fetchUser = async () => {
    try {
      const payload = await $fetch<AuthUser>(`${apiBase}/auth/me`, {
        credentials: 'include'
      })
      user.value = payload
    } catch (error) {
      user.value = null
    } finally {
      userLoaded.value = true
    }
  }

  const login = async (payload: { email: string; password: string; remember?: boolean }) => {
    await fetchCsrf()
    await $fetch(`${apiBase}/auth/login`, {
      method: 'POST',
      credentials: 'include',
      body: payload
    })
    await fetchUser()
  }

  const register = async (payload: { name: string; email: string; password: string }) => {
    await fetchCsrf()
    await $fetch(`${apiBase}/auth/register`, {
      method: 'POST',
      credentials: 'include',
      body: payload
    })
    await fetchUser()
  }

  const logout = async () => {
    await $fetch(`${apiBase}/auth/logout`, {
      method: 'POST',
      credentials: 'include'
    })
    user.value = null
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
