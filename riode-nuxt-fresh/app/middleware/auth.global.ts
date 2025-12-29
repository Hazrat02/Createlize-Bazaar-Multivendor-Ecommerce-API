export default defineNuxtRouteMiddleware(async (to) => {
  const { user, userLoaded, fetchUser, token } = useAuth()

  // Hydrate user if token exists but user not loaded
  if (!userLoaded.value && (token.value || (process.client && localStorage.getItem('auth_token')))) {
    await fetchUser()
  }

  // Protect routes that explicitly require auth
  if (to.meta.requiresAuth && !user.value) {
    return navigateTo('/')
  }
})
