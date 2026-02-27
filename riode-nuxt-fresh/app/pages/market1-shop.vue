<template>
  <main class="main">
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><NuxtLink to="/"><i class="d-icon-home"></i></NuxtLink></li>
                        <li>{{ siteName }} Shop</li>
                    </ul>
                </div>
            </nav>
            <div class="page-content mb-10 pb-2">
                <div class="container">
                   
                    <div class="brand-wrapper mb-8">
                        <div class="owl-carousel owl-theme row cols-xl-7 cols-lg-6 cols-md-4 cols-sm-3 cols-2"
                            data-owl-options="{
                            'nav': false,
                            'dots': false,
                            'magin': 0,
                            'responsive': {
                                '0': {
                                    'items': 2
                                },
                                '576': {
                                    'items': 3
                                },
                                '768': {
                                    'items': 4
                                },
                                '992': {
                                    'items': 6
                                },
                                '1200': {
                                    'items': 7
                                }
                            }
                        }">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/1.jpg" alt="Brand" width="197"
                                    height="93" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/2.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/3.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/4.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/5.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/6.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/7.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                        </div>
                    </div>
                    <!-- End Brand -->
                    <div class="row cols-xl-8 cols-lg-6 cols-md-4 cols-sm-3 cols-2">
                        <div v-for="item in shopCategoryIcons" :key="item.key" class="category-wrap mb-4">
                            <div class="category category-icon">
                                <NuxtLink :to="categoryLink(item)">
                                    <figure class="categroy-media">
                                        <img v-if="item.iconUrl" :src="item.iconUrl" :alt="item.name" width="32"
                                            height="32" style="width: 2.2rem; height: 2.2rem; object-fit: contain;" />
                                        <i v-else :class="item.icon"></i>
                                    </figure>
                                    <div :class="item.contentClass">
                                        <h4 class="category-name">{{ item.name }}</h4>
                                    </div>
                                </NuxtLink>
                            </div>
                        </div>
                    </div>
                    <!-- End Category icon -->
                    <nav class="toolbox toolbox-horizontal sticky-toolbox sticky-content fix-top pt-2" data-top="1174">
                        <aside class="sidebar sidebar-fixed shop-sidebar">
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
                            <div class="sidebar-content toolbox-left">
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Size</a>
                                    <ul class="filter-items">
                                        <li v-for="size in availableSizes" :key="size">
                                            <a href="#" :class="{ active: selectedSizes.includes(size) }"
                                                @click.prevent="toggleListFilter('sizes', size)">
                                                {{ size }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Color</a>
                                    <ul class="filter-items">
                                        <li v-for="color in availableColors" :key="color">
                                            <a href="#" :class="{ active: selectedColors.includes(color) }"
                                                @click.prevent="toggleListFilter('colors', color)">
                                                {{ color }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="availablePlans.length" class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Plan</a>
                                    <ul class="filter-items">
                                        <li v-for="plan in availablePlans" :key="plan">
                                            <a href="#" :class="{ active: selectedPlans.includes(plan) }"
                                                @click.prevent="toggleListFilter('plans', plan)">
                                                {{ plan }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Price</a>
                                    <ul class="filter-items filter-price">
                                        <li v-for="range in priceRanges" :key="range.label">
                                            <a href="#" :class="{ active: isPriceRangeSelected(range) }"
                                                @click.prevent="applyPriceRange(range)">
                                                {{ range.label }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        <div class="toolbox-left">
                            <a href="#"
                                class="toolbox-item left-sidebar-toggle btn btn-sm btn-outline btn-primary btn-rounded btn-icon-right d-lg-none">
                                Filter<i class="d-icon-arrow-right"></i></a>
                            <div class="toolbox-item toolbox-sort select-menu">
                                <select v-model="sort" name="orderby" class="form-control ls-normal">
                                    <option value="default">Default sorting</option>
                                    <option value="popularity">Most popular</option>
                                    <option value="rating">Average rating</option>
                                    <option value="date">Latest</option>
                                    <option value="price-low">Sort forward price low</option>
                                    <option value="price-high">Sort forward price high</option>
                                    <option value="">Clear custom sort</option>
                                </select>
                            </div>
                        </div>
                        <div class="toolbox-right">
                            <div class="toolbox-item toolbox-show select-box text-dark">
                                <label>show :</label>
                                <select v-model.number="perPage" name="count" class="form-control">
                                    <option v-for="count in perPageOptions" :key="count" :value="count">
                                        {{ count }}
                                    </option>
                                </select>
                            </div>
                            <div class="toolbox-item toolbox-layout">
                                <a href="#" class="d-icon-mode-list btn-layout"></a>
                                <NuxtLink to="/shop" class="d-icon-mode-grid btn-layout active"></NuxtLink>
                            </div>
                        </div>
                    </nav>
                    <!-- End Toolbox -->
                    <div class="select-items">
                        <a href="#" class="filter-clean text-primary" @click.prevent="clearFilters">Clean All</a>
                    </div>
                    <div class="row product-wrapper cols-xl-5 cols-lg-4 cols-md-3 cols-2">
                        <div v-for="product in products" :key="product.id" class="product-wrap">
                            <ProductCard :product="product" />
                        </div>
                        <div v-if="!products.length && !productsPending" class="col-12 text-center py-6 text-muted">
                            No products found.
                        </div>
                    </div>
                    <!-- End Product -->
                    <nav class="toolbox toolbox-pagination">
                        <p class="show-info d-block">Showing<span>{{ showingFrom }}-{{ showingTo }} of {{ total }}</span> Products</p>
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: currentPage <= 1 }">
                                <a class="page-link page-link-prev" href="#" aria-label="Previous"
                                    @click.prevent="goToPage(currentPage - 1)">
                                    <i class="d-icon-arrow-left"></i>Prev
                                </a>
                            </li>
                            <li v-for="page in paginationPages" :key="page" class="page-item"
                                :class="{ active: page === currentPage }">
                                <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: currentPage >= pageCount }">
                                <a class="page-link page-link-next" href="#" aria-label="Next"
                                    @click.prevent="goToPage(currentPage + 1)">
                                    Next<i class="d-icon-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

             <div class="shop-boxed-banner banner mb-8 mb-lg-7"
                        style="background-image: url('/images/demos/demo-market1/banner/shopbanner.jpg'); background-color: #ECEDEF;">
                        <div class="banner-content">
                            <h4 class="banner-subtitle font-weight-semi-bold ls-m text-uppercase text-secondary mb-3">
                                Winter Season's</h4>
                            <h1 class="banner-title font-weight-bold ls-m mb-6">Discover Our Ski Equipment</h1>
                            <a href="#" class="btn btn-dark btn-outline btn-rounded">Shop Now<i
                                    class="d-icon-arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- End Shop banner-->

        </main>
</template>

<script setup>
const { cart, cartCount, cartSubtotal, removeItem } = useCart()
const { categories } = useCategories()
const { settings } = useSiteSettings()

const siteName = computed(() => settings.value.site_name || 'Riode')
const siteLogoWide = computed(
  () =>
    settings.value.site_logo_wide_url ||
    settings.value.site_logo_url ||
    '/images/demos/demo-market1/logo.png'
)

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}

const categoryMenuIcons = [
  'd-icon-desktop',
  'd-icon-handbag',
  'd-icon-t-shirt2',
  'd-icon-camera2',
  'd-icon-gamepad2',
  'd-icon-officebag',
  'd-icon-mobile',
  'd-icon-bridge-lamp',
  'd-icon-headphone',
  'd-icon-memory',
  'd-icon-cook'
]

const categoryMenuItems = computed(() => {
  const items = categories.value.slice(0, categoryMenuIcons.length).map((category, index) => ({
    ...category,
    icon: categoryMenuIcons[index],
    iconUrl: category.icon_url ?? null,
    key: category.slug || String(category.id)
  }))

  items.push({
    id: -1,
    name: 'All Categories',
    slug: 'all',
    icon: 'd-icon-category',
    iconUrl: null,
    key: 'all'
  })

  return items
})

const shopCategoryIcons = computed(() => {
  const iconMap = [
    { icon: 'd-icon-t-shirt1', contentClass: 'category-content' },
    { icon: 'd-icon-sofa', contentClass: 'category-content' },
    { icon: 'd-icon-basketball1', contentClass: 'category-content' },
    { icon: 'd-icon-babycare', contentClass: 'category-babycare' },
    { icon: 'd-icon-camera1', contentClass: 'category-content' },
    { icon: 'd-icon-gamepad1', contentClass: 'category-babycare' },
    { icon: 'd-icon-headphone', contentClass: 'category-content' },
    { icon: 'd-icon-mobile', contentClass: 'category-content' }
  ]

  return categories.value.slice(0, iconMap.length).map((category, index) => ({
    ...category,
    ...iconMap[index],
    iconUrl: category.icon_url ?? null,
    key: category.slug || String(category.id)
  }))
})

const footerCategories = computed(() =>
  categories.value.slice(0, 6).map((category) => ({
    ...category,
    key: category.slug || String(category.id),
    subcategories: (category.subcategories ?? []).slice(0, 12)
  }))
)

const route = useRoute()
const router = useRouter()

const parseQueryString = (value) => {
  if (Array.isArray(value)) return value[0] || ''
  return value ? String(value) : ''
}

const parseNumber = (value) => {
  const parsed = Number(value)
  return Number.isFinite(parsed) ? parsed : null
}

const parseList = (value) => {
  if (Array.isArray(value)) return value.map((item) => String(item).trim()).filter(Boolean)
  if (!value) return []
  return String(value)
    .split(',')
    .map((item) => item.trim())
    .filter(Boolean)
}

const categoryId = computed(() => {
  const direct = parseNumber(route.query.category_id)
  if (direct) return direct

  const slug = parseQueryString(route.query.category)
  if (!slug) return null
  return categories.value.find((item) => item.slug === slug)?.id ?? null
})

const subCategoryId = computed(() => {
  const direct = parseNumber(route.query.sub_category_id)
  if (direct) return direct

  const slug = parseQueryString(route.query.subcategory)
  if (!slug) return null
  const found = categories.value
    .flatMap((category) => category.subcategories ?? [])
    .find((subcategory) => subcategory.slug === slug)
  return found?.id ?? null
})

const vendorId = computed(() => {
  const direct = parseNumber(route.query.vendor_id)
  if (direct) return direct
  return parseNumber(route.query.vendor)
})

const searchTerm = computed(() => parseQueryString(route.query.search))
const searchInput = ref('')
const searchCategory = ref('all-cat')
const selectedColors = computed(() => parseList(route.query.colors))
const selectedSizes = computed(() => parseList(route.query.sizes))
const selectedPlans = computed(() => parseList(route.query.plans))
const currentPage = computed(() => parseNumber(route.query.page) || 1)
const minPrice = computed(() => parseNumber(route.query.min_price))
const maxPrice = computed(() => parseNumber(route.query.max_price))

watch(
  searchTerm,
  (value) => {
    searchInput.value = value || ''
  },
  { immediate: true }
)

watch(
  [() => route.query.category, categoryId, categories],
  () => {
    const slug = parseQueryString(route.query.category)
    if (slug) {
      searchCategory.value = slug
      return
    }
    if (categoryId.value) {
      const found = categories.value.find((item) => item.id === categoryId.value)
      searchCategory.value = found?.slug || 'all-cat'
      return
    }
    searchCategory.value = 'all-cat'
  },
  { immediate: true }
)

const sort = computed({
  get: () => parseQueryString(route.query.sort) || 'default',
  set: (value) => {
    const next = value && value !== 'default' ? value : undefined
    updateQuery({ sort: next, page: 1 })
  }
})

const perPage = computed({
  get: () => parseNumber(route.query.per_page) || 15,
  set: (value) => {
    updateQuery({ per_page: value, page: 1 })
  }
})

const filters = computed(() => ({
  page: currentPage.value,
  per_page: perPage.value,
  category_id: categoryId.value ?? undefined,
  sub_category_id: subCategoryId.value ?? undefined,
  vendor_id: vendorId.value ?? undefined,
  search: searchTerm.value || undefined,
  min_price: minPrice.value ?? undefined,
  max_price: maxPrice.value ?? undefined,
  colors: selectedColors.value,
  sizes: selectedSizes.value,
  plans: selectedPlans.value,
  sort: sort.value !== 'default' ? sort.value : undefined
}))

const { data: productData, pending: productsPending } = useProductSearch(filters)
const products = computed(() => productData.value.items ?? [])
const total = computed(() => Number(productData.value.total ?? 0))
const pageCount = computed(() => Math.max(1, Math.ceil(total.value / perPage.value)))
const showingFrom = computed(() =>
  total.value === 0 ? 0 : (currentPage.value - 1) * perPage.value + 1
)
const showingTo = computed(() => Math.min(total.value, currentPage.value * perPage.value))

const perPageOptions = [10, 15, 20, 30]

const priceRanges = [
  { label: 'All Prices', min: null, max: null },
  { label: '$0.00 - $50.00', min: 0, max: 50 },
  { label: '$50.00 - $100.00', min: 50, max: 100 },
  { label: '$100.00 - $200.00', min: 100, max: 200 },
  { label: '$200.00+', min: 200, max: null }
]

const availableColors = computed(() => {
  const unique = new Set()
  products.value.forEach((product) => (product.colors ?? []).forEach((color) => unique.add(color)))
  return unique.size ? Array.from(unique) : ['Black', 'Blue', 'Brown', 'Green']
})

const availableSizes = computed(() => {
  const unique = new Set()
  products.value.forEach((product) => (product.sizes ?? []).forEach((size) => unique.add(size)))
  return unique.size ? Array.from(unique) : ['Extra Large', 'Large', 'Medium', 'Small']
})

const availablePlans = computed(() => {
  const unique = new Set()
  products.value.forEach((product) => (product.plans ?? []).forEach((plan) => unique.add(plan)))
  return Array.from(unique)
})

const paginationPages = computed(() => {
  const totalPages = pageCount.value
  const current = currentPage.value
  const pages = new Set([1, totalPages, current - 1, current, current + 1])
  return Array.from(pages)
    .filter((page) => page >= 1 && page <= totalPages)
    .sort((a, b) => a - b)
})

const updateQuery = (changes) => {
  const next = { ...route.query, ...changes }
  Object.keys(next).forEach((key) => {
    const value = next[key]
    if (value === undefined || value === null || value === '') {
      delete next[key]
    }
  })
  router.push({ query: next })
}

const submitSearch = () => {
  const term = searchInput.value.trim()
  const category = searchCategory.value !== 'all-cat' ? searchCategory.value : undefined
  updateQuery({
    search: term || undefined,
    category,
    category_id: category ? undefined : route.query.category_id,
    sub_category_id: category ? undefined : route.query.sub_category_id,
    page: 1
  })
}

const toggleListFilter = (key, value) => {
  const current =
    key === 'colors'
      ? selectedColors.value
      : key === 'sizes'
      ? selectedSizes.value
      : selectedPlans.value
  const exists = current.includes(value)
  const next = exists ? current.filter((item) => item !== value) : [...current, value]
  updateQuery({ [key]: next.length ? next.join(',') : undefined, page: 1 })
}

const applyPriceRange = (range) => {
  updateQuery({
    min_price: range.min ?? undefined,
    max_price: range.max ?? undefined,
    page: 1
  })
}

const isPriceRangeSelected = (range) => {
  const currentMin = minPrice.value ?? null
  const currentMax = maxPrice.value ?? null
  return currentMin === (range.min ?? null) && currentMax === (range.max ?? null)
}

const clearFilters = () => {
  updateQuery({
    colors: undefined,
    sizes: undefined,
    plans: undefined,
    min_price: undefined,
    max_price: undefined,
    sort: undefined,
    page: 1
  })
}

const goToPage = (page) => {
  const nextPage = Math.min(Math.max(1, page), pageCount.value)
  if (nextPage === currentPage.value) return
  updateQuery({ page: nextPage })
}

const categoryLink = (item) => {
  if (!item?.slug || item.slug === 'all') {
    return '/market-shop'
  }
  return { path: '/market-shop', query: { category: item.slug } }
}

useHead({
  bodyAttrs: { class: 'market1-shop market' }
})
definePageMeta({
  layout: 'riode',
  alias: ['/market-shop']
})
</script>

<style scoped>
:deep(.product-wrapper .product-media) {
  width: 238px;
  height: 267px;
}

:deep(.product-wrapper .product-media img) {
  width: 238px;
  height: 267px;
  object-fit: cover;
}
</style>











