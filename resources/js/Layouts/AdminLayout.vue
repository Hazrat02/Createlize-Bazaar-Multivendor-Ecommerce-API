<template>
  <div>
    <div id="preloader" v-show="preloaderVisible">
      <div class="spinner"></div>
    </div>

    <aside class="sidebar-nav-wrapper" :class="{ active: sidebarOpen }">
      <div class="navbar-logo">
        <Link href="/">
          <img src="@/../admin/assets/images/logo/logo.svg" alt="logo" />
        </Link>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li class="nav-item nav-item-has-children">
            <a href="#" @click.prevent="toggleMenu('dashboard')" :aria-expanded="menuOpen.dashboard ? 'true' : 'false'">
              <span class="icon"><i class="lni lni-dashboard"></i></span>
              <span class="text">{{ t('dashboard') }}</span>
            </a>
            <ul class="collapse dropdown-nav" :class="{ show: menuOpen.dashboard }">
              <li>
                <Link :class="{ active: isActive('/') }" href="/">{{ t('overview') }}</Link>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <Link href="/admin/categories" :class="{ active: isActive('/admin/categories') }">
              <span class="icon"><i class="lni lni-list"></i></span>
              <span class="text">{{ t('categories') }}</span>
            </Link>
          </li>

          <li  class="nav-item">
            <Link href="/admin/subcategories" :class="{ active: isActive('/admin/subcategories') }">
              <span class="icon"><i class="lni lni-layers"></i></span>
              <span class="text">{{ t('subcategories') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/deliveries" :class="{ active: isActive('/admin/deliveries') }">
              <span class="icon"><i class="lni lni-delivery"></i></span>
              <span class="text">{{ t('delivery_types_fields') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/vendors" :class="{ active: isActive('/admin/vendors') }">
              <span class="icon"><i class="lni lni-user"></i></span>
              <span class="text">{{ t('vendor_manage') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/products" :class="{ active: isActive('/admin/products') }">
              <span class="icon"><i class="lni lni-package"></i></span>
              <span class="text">{{ t('products') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/users" :class="{ active: isActive('/admin/users') }">
              <span class="icon"><i class="lni lni-users"></i></span>
              <span class="text">{{ t('users') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/orders" :class="{ active: isActive('/admin/orders') }">
              <span class="icon"><i class="lni lni-cart"></i></span>
              <span class="text">{{ t('orders') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/coupons" :class="{ active: isActive('/admin/coupons') }">
              <span class="icon"><i class="lni lni-offer"></i></span>
              <span class="text">{{ t('coupons') }}</span>
            </Link>
          </li>

          <li class="nav-item nav-item-has-children">
            <a href="#" @click.prevent="toggleMenu('content')" :aria-expanded="menuOpen.content ? 'true' : 'false'">
              <span class="icon"><i class="lni lni-write"></i></span>
              <span class="text">{{ t('content_manage') }}</span>
            </a>
            <ul class="collapse dropdown-nav" :class="{ show: menuOpen.content }">
              <li>
                <Link href="/admin/content" :class="{ active: isActive('/admin/content') }">{{ t('pages_faqs') }}</Link>
              </li>
            </ul>
          </li>

          <li class="nav-item nav-item-has-children">
            <a href="#" @click.prevent="toggleMenu('payment')" :aria-expanded="menuOpen.payment ? 'true' : 'false'">
              <span class="icon"><i class="lni lni-credit-cards"></i></span>
              <span class="text">{{ t('payment_manage') }}</span>
            </a>
            <ul class="collapse dropdown-nav" :class="{ show: menuOpen.payment }">
              <li>
                <Link href="/admin/payments/uddoktapay" :class="{ active: isActive('/admin/payments/uddoktapay') }">{{ t('uddoktapay') }}</Link>
              </li>
            </ul>
          </li>

          <span class="divider"><hr /></span>

          <li class="nav-item">
            <Link href="/admin/smtp" :class="{ active: isActive('/admin/smtp') }">
              <span class="icon"><i class="lni lni-envelope"></i></span>
              <span class="text">{{ t('smtp_manage') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/invoice-template" :class="{ active: isActive('/admin/invoice-template') }">
              <span class="icon"><i class="lni lni-printer"></i></span>
              <span class="text">{{ t('invoice_template') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/seo" :class="{ active: isActive('/admin/seo') }">
              <span class="icon"><i class="lni lni-search"></i></span>
              <span class="text">{{ t('seo_manage') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/settings" :class="{ active: isActive('/admin/settings') }">
              <span class="icon"><i class="lni lni-cog"></i></span>
              <span class="text">{{ t('settings') }}</span>
            </Link>
          </li>

          <li class="nav-item">
            <Link href="/admin/api-docs" :class="{ active: isActive('/admin/api-docs') }">
              <span class="icon"><i class="lni lni-code"></i></span>
              <span class="text">{{ t('api_docs') }}</span>
            </Link>
          </li>
        </ul>
      </nav>
      <div class="promo-box">
        <div class="promo-icon">
          <img class="mx-auto" style="width: 80px;" src="@/../admin/assets/images/createlize.png" alt="Logo" />
        </div>
        <h3>Contact With Dev</h3>
        <p>Improve your development process and start doing more with Createlize</p>
        <a href="https://cretelize.org" target="_blank" rel="nofollow" class="main-btn primary-btn btn-hover">
          Createlize
        </a>
      </div>
    </aside>

    <div class="overlay" :class="{ active: sidebarOpen }" @click="sidebarOpen = false"></div>

    <main class="main-wrapper">
      <header class="header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
              <div class="header-left d-flex align-items-center">
                <div class="menu-toggle-btn mr-15">
                  <button type="button" class="main-btn primary-btn btn-hover" @click="sidebarOpen = !sidebarOpen">
                    <i class="lni lni-chevron-left me-2"></i> {{ t('menu') }}
                  </button>
                </div>
                <div class="header-search d-none d-md-flex">
                  <input type="text" :placeholder="t('search_placeholder')" v-model="search" @keydown.enter="onSearch" />
                </div>
              </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
              <div class="header-right">
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" @click="languageOpen = !languageOpen">
                    <div class="profile-info">
                      <div class="info">
                        <h6 class="mb-0">
                          <a v-if="locale === 'bn'" class="language-label">
                            <svg class="flag-icon" viewBox="0 0 60 30" aria-hidden="true">
                              <rect width="60" height="30" fill="#006A4E" />
                              <circle cx="26" cy="15" r="9" fill="#F42A41" />
                            </svg>
                             বাংলা
                          </a>
                          <a v-else class="language-label">
                            <svg class="flag-icon" viewBox="0 0 60 30" aria-hidden="true">
                              <rect width="60" height="30" fill="#012169" />
                              <polygon points="0,0 7,0 60,26 60,30 53,30 0,4" fill="#FFFFFF" />
                              <polygon points="60,0 53,0 0,26 0,30 7,30 60,4" fill="#FFFFFF" />
                              <polygon points="0,0 4,0 60,24 60,30 56,30 0,6" fill="#C8102E" />
                              <polygon points="60,0 56,0 0,24 0,30 4,30 60,6" fill="#C8102E" />
                              <rect x="25" width="10" height="30" fill="#FFFFFF" />
                              <rect y="10" width="60" height="10" fill="#FFFFFF" />
                              <rect x="27" width="6" height="30" fill="#C8102E" />
                              <rect y="12" width="60" height="6" fill="#C8102E" />
                            </svg>
                             English
                          </a>
                        </h6>
                      </div>
                    </div>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: languageOpen }">
                    <li>
                      <a type="button" class="dropdown-item" :class="{ active: locale === 'en' }" @click="setLocale('en')">
                        <svg class="flag-icon" viewBox="0 0 60 30" aria-hidden="true">
                          <rect width="60" height="30" fill="#012169" />
                          <polygon points="0,0 7,0 60,26 60,30 53,30 0,4" fill="#FFFFFF" />
                          <polygon points="60,0 53,0 0,26 0,30 7,30 60,4" fill="#FFFFFF" />
                          <polygon points="0,0 4,0 60,24 60,30 56,30 0,6" fill="#C8102E" />
                          <polygon points="60,0 56,0 0,24 0,30 4,30 60,6" fill="#C8102E" />
                          <rect x="25" width="10" height="30" fill="#FFFFFF" />
                          <rect y="10" width="60" height="10" fill="#FFFFFF" />
                          <rect x="27" width="6" height="30" fill="#C8102E" />
                          <rect y="12" width="60" height="6" fill="#C8102E" />
                        </svg>
                        English
                      </a>
                    </li>
                    <li>
                      <a type="button" class="dropdown-item" :class="{ active: locale === 'bn' }" @click="setLocale('bn')">
                        <svg class="flag-icon" viewBox="0 0 60 30" aria-hidden="true">
                          <rect width="60" height="30" fill="#006A4E" />
                          <circle cx="26" cy="15" r="9" fill="#F42A41" />
                        </svg>
                        বাংলা
                      </a>
                    </li>
                  </ul>
                </div>
                <div class="profile-box ml-15">
                  <button class="dropdown-toggle bg-transparent border-0" type="button" @click="profileOpen = !profileOpen">
                    <div class="profile-info">
                      <div class="info">
                        <div class="image">
                          <img src="@/../admin/assets/images/profile/profile-image.png" alt="" />
                        </div>
                        <div>
                          <h6 class="fw-500">{{ user?.name || t('admin') }}</h6>
                          <p>{{ t('admin') }}</p>
                        </div>
                      </div>
                    </div>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: profileOpen }">
                    <li>
                      <div class="author-info flex items-center !p-1">
                        <div class="image">
                          <img src="@/../admin/assets/images/profile/profile-image.png" alt="image" />
                        </div>
                        <div class="content">
                          <h4 class="text-sm">{{ user?.name || t('admin') }}</h4>
                          <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#">
                            {{ user?.email || '' }}
                          </a>
                        </div>
                      </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <Link href="/admin/settings">
                        <i class="lni lni-cog"></i> {{ t('settings') }}
                      </Link>
                    </li>
                    <li class="divider"></li>
                    <li>
                      <form method="POST" action="/admin/logout">
                        <input type="hidden" name="_token" :value="csrf" />
                        <button type="submit"  class="logout">
                          <i class="lni lni-exit"></i> {{ t('sign_out') }}
                        </button>
                      </form>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <section class="section">
        <div class="container-fluid">
          <div v-if="flashMessage" class="alert alert-success mb-3" role="alert">
            {{ flashMessage }}
          </div>
          <div v-if="flashError" class="alert alert-danger mb-3" role="alert">
            {{ flashError }}
          </div>
          <slot />
        </div>
      </section>

      <footer class="footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6 order-last order-md-first">
              <div class="copyright text-center text-md-start">
                <p class="text-sm">
                  Designed and Developed by
                  <a href="https://plainadmin.com" rel="nofollow" target="_blank">
                    PlainAdmin
                  </a>
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="terms d-flex justify-content-center justify-content-md-end">
                <a href="#" class="text-sm">{{ t('terms') }}</a>
                <a href="#" class="text-sm ml-15">{{ t('privacy') }}</a>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </main>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth?.user)
const csrf = computed(() => page.props.csrf_token || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '')
const locale = computed(() => page.props.i18n?.locale || 'en')
const messages = computed(() => page.props.i18n?.admin || {})

const flashMessage = computed(() => page.props.flash?.success || '')
const flashError = computed(() => page.props.flash?.error || '')

const sidebarOpen = ref(false)
const profileOpen = ref(false)
const languageOpen = ref(false)
const search = ref('')
const preloaderVisible = ref(true)

const menuOpen = reactive({
  dashboard: true,
  content: false,
  payment: false,
})

function toggleMenu(key) {
  menuOpen[key] = !menuOpen[key]
}

function isActive(prefix) {
  return (page.url || window.location.pathname).startsWith(prefix)
}

function onSearch() {}

function t(key) {
  return messages.value[key] || key
}

function setLocale(value) {
  router.post('/admin/locale', { locale: value }, { preserveScroll: true, onFinish: () => (languageOpen.value = false) })
}

onMounted(() => {
  preloaderVisible.value = false
})

watch(
  () => page.url,
  () => {
    profileOpen.value = false
    sidebarOpen.value = false
    languageOpen.value = false
  }
)
</script>

<style scoped>
.flag-icon {
  width: 18px;
  height: 16px;
  display: inline-block;
}

.language-label {
  display: inline-flex;
  align-items: center;
  gap: 6px;
}

/* .active {
  color: #1A2142;
  background: rgba(223, 229, 239, 0.3);
} */

 .logout{
  background: none !important;
  
 }
</style>




