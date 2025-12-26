<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
  <div class="minipopup-box" :class="{ 'show': popup.visible }" role="status" aria-live="polite">
    <p class="minipopup-title">Successfully Added</p>
    <div v-if="popup.item" class="product product-cart">
      <figure class="product-media">
        <NuxtLink :to="`/product/${popup.item.slug}`">
          <img :src="popup.item.image" :alt="popup.item.name" width="80" height="88" />
        </NuxtLink>
      </figure>
      <div class="product-detail">
        <NuxtLink :to="`/product/${popup.item.slug}`" class="product-name">{{ popup.item.name }}</NuxtLink>
        <div class="price-box">
          <span class="product-quantity">{{ popup.qty }}</span>
          <span class="product-price">{{ formatPrice(popup.item.price) }}</span>
        </div>
      </div>
    </div>
    <div class="minipopup-action">
      <NuxtLink to="/cart" class="btn btn-outline btn-rounded">View Cart</NuxtLink>
      <NuxtLink to="/checkout" class="btn btn-primary btn-rounded">Check Out</NuxtLink>
    </div>
  </div>
  <div v-if="loginModalOpen" class="mfp-bg mfp-ready"></div>
  <div v-if="loginModalOpen" class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-login mfp-fade mfp-ready" tabindex="-1" @click.self="closeLoginModal">
    <div class="mfp-container mfp-ajax-holder">
      <div class="mfp-content">
        <div class="login-popup">
          <div class="form-box">
            <div class="tab tab-nav-simple tab-nav-boxed form-tab">
              <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5" role="tablist">
                <li class="nav-item">
                  <a class="nav-link border-no lh-1 ls-normal" :class="{ active: loginTab === 'login' }" href="#" @click.prevent="loginTab = 'login'">Login</a>
                </li>
                <li class="delimiter">or</li>
                <li class="nav-item">
                  <a class="nav-link border-no lh-1 ls-normal" :class="{ active: loginTab === 'register' }" href="#" @click.prevent="loginTab = 'register'">Register</a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane" :class="{ active: loginTab === 'login' }" id="signin">
                  <form action="#" @submit.prevent="submitLogin">
                    <div class="form-group mb-3">
                      <input v-model="loginForm.email" type="email" class="form-control" id="singin-email" name="singin-email" placeholder="Username or Email Address *" required>
                    </div>
                    <div class="form-group">
                      <input v-model="loginForm.password" type="password" class="form-control" id="singin-password" name="singin-password" placeholder="Password *" required>
                    </div>
                    <div class="form-footer">
                      <div class="form-checkbox">
                        <input v-model="loginForm.remember" type="checkbox" class="custom-checkbox" id="signin-remember" name="signin-remember">
                        <label class="form-control-label" for="signin-remember">Remember me</label>
                      </div>
                      <a href="#" class="lost-link">Lost your password?</a>
                    </div>
                    <p v-if="loginError" class="text-danger mb-3">{{ loginError }}</p>
                    <button class="btn btn-dark btn-block btn-rounded" type="submit" :disabled="loginLoading">
                      {{ loginLoading ? 'Logging in...' : 'Login' }}
                    </button>
                  </form>
                  <div v-if="settings.auth_google_enabled" class="form-choice text-center">
                    <label class="ls-m">or Login With</label>
                    <div class="social-links">
                      <a href="#" class="social-link social-google fab fa-google border-no" @click.prevent="startGoogleLogin"></a>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" :class="{ active: loginTab === 'register' }" id="register">
                  <form action="#" @submit.prevent="submitRegister">
                    <div class="form-group mb-3">
                      <input v-model="registerForm.name" type="text" class="form-control" id="register-name" name="register-name" placeholder="Your Name *" required>
                    </div>
                    <div class="form-group mb-3">
                      <input v-model="registerForm.email" type="email" class="form-control" id="register-email" name="register-email" placeholder="Your Email Address *" required>
                    </div>
                    <div class="form-group">
                      <input v-model="registerForm.password" type="password" class="form-control" id="register-password" name="register-password" placeholder="Password *" required>
                    </div>
                    <div class="form-footer">
                      <div class="form-checkbox">
                        <input v-model="registerForm.agree" type="checkbox" class="custom-checkbox" id="register-agree" name="register-agree" required>
                        <label class="form-control-label" for="register-agree">I agree to the privacy policy</label>
                      </div>
                    </div>
                    <p v-if="registerError" class="text-danger mb-3">{{ registerError }}</p>
                    <button class="btn btn-dark btn-block btn-rounded" type="submit" :disabled="registerLoading">
                      {{ registerLoading ? 'Creating...' : 'Register' }}
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <button title="Close (Esc)" type="button" class="mfp-close" @click="closeLoginModal"><span>×</span></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const { popup } = useCart()
const { settings, refreshSettings } = useSiteSettings()
const {
  login,
  register,
  loginModalOpen,
  loginModalTab,
  openLoginModal,
  closeLoginModal,
  startGoogleLogin,
  fetchUser
} = useAuth()
const faviconUrl = computed(() => settings.value.site_logo_url || '/images/icons/favicon.png')
const siteTitle = computed(() => settings.value.site_name || 'Riode')

useHead({
  title: siteTitle,
  titleTemplate: (chunk) => (chunk ? `${chunk} | ${siteTitle.value}` : siteTitle.value),
  link: [
    {
      key: 'favicon',
      rel: 'icon',
      type: 'image/png',
      href: faviconUrl
    }
  ]
})

const formatPrice = (value) => `$${value.toFixed(2)}`

const loginTab = loginModalTab

const loginForm = reactive({
  email: '',
  password: '',
  remember: false
})

const registerForm = reactive({
  name: '',
  email: '',
  password: '',
  agree: false
})

const loginError = ref('')
const registerError = ref('')
const loginLoading = ref(false)
const registerLoading = ref(false)

const submitLogin = async () => {
  loginError.value = ''
  loginLoading.value = true
  try {
    await login({
      email: loginForm.email,
      password: loginForm.password,
      remember: loginForm.remember
    })
    closeLoginModal()
  } catch (error) {
    loginError.value = 'Login failed. Please check your credentials.'
  } finally {
    loginLoading.value = false
  }
}

const submitRegister = async () => {
  if (!registerForm.agree) {
    registerError.value = 'Please accept the privacy policy.'
    return
  }

  registerError.value = ''
  registerLoading.value = true
  try {
    await register({
      name: registerForm.name,
      email: registerForm.email,
      password: registerForm.password
    })
    closeLoginModal()
  } catch (error) {
    registerError.value = 'Registration failed. Please try again.'
  } finally {
    registerLoading.value = false
  }
}

const handleLoginToggleClick = async (event) => {
  const target = event.target?.closest?.('[data-toggle="login-modal"]')
  if (!target) return
  event.preventDefault()
  const tab = target.classList.contains('register-link') ? 'register' : 'login'
  await refreshSettings()
  openLoginModal(tab)
}

const handleKeydown = (event) => {
  if (event.key === 'Escape' && loginModalOpen.value) {
    closeLoginModal()
  }
}

onMounted(() => {
  void refreshSettings()
  void fetchUser()
  document.addEventListener('click', handleLoginToggleClick)
  document.addEventListener('keydown', handleKeydown)
})

watch(loginModalOpen, (value) => {
  if (value) {
    void refreshSettings()
  }
})

onUnmounted(() => {
  document.removeEventListener('click', handleLoginToggleClick)
  document.removeEventListener('keydown', handleKeydown)
})
</script>

<style scoped>
.minipopup-box {
  position: fixed;
  left: 20px;
  bottom: 20px;
  width: 320px;
  background: #ffffff;
  border: 1px solid #e1e1e1;
  border-radius: 6px;
  padding: 16px;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
  opacity: 0;
  transform: translateY(12px);
  transition: opacity 0.2s ease, transform 0.2s ease;
  z-index: 9999;
  pointer-events: none;
}

.minipopup-box.show {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto;
}

.minipopup-title {
  font-weight: 600;
  margin: 0 0 12px;
  color: #222;
}

.minipopup-action {
  display: flex;
  gap: 10px;
  margin-top: 12px;
}

.minipopup-action .btn {
  flex: 1;
  text-align: center;
}

</style>
