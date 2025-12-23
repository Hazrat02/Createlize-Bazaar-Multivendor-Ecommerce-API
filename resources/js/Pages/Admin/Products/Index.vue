<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('products_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_products') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/products/create" class="main-btn primary-btn btn-hover">
              + {{ t('add_product') }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('products_title') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            <div class="select-position select-sm">
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_product_placeholder')"
                aria-label="Search products"
              />
            </div>
          </div>
        </div>
      </div>

      <div v-if="q" class="text-end mb-3">
        <button class="main-btn danger-btn-outline btn-hover btn-sm" @click="clearSearch">{{ t('clear') }}</button>
      </div>

      <div class="table-responsive">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th style="width: 80px;">#</th>
              <th>{{ t('product') }}</th>
              <th>{{ t('vendor') }}</th>
              <th>{{ t('category') }}</th>
              <th>{{ t('price') }}</th>
              <th class="min-width">{{ t('status') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, idx) in products.data" :key="product.id">
              <td>{{ (products.from || 1) + idx }}</td>
              <td class="fw-semibold">{{ product.name }}</td>
              <td class="text-muted">{{ product.vendor?.name || '-' }}</td>
              <td class="text-muted">{{ product.category?.name || '-' }}</td>
              <td class="text-muted">{{ formatAmount(product.price) }}</td>
              <td>
                <span class="status-btn" :class="product.is_active ? 'success-btn' : 'close-btn'">
                  {{ product.is_active ? t('active') : t('inactive') }}
                </span>
              </td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button
                    class="more-btn"
                    type="button"
                    :aria-expanded="openMenuId === product.id ? 'true' : 'false'"
                    @click.stop="toggleMenu(product.id)"
                  >
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === product.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/products/${product.id}/edit`" class="text-gray">{{ t('edit') }}</Link>
                    </li>
                    <li class="dropdown-item">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="destroy(product)">
                        {{ t('remove') }}
                      </button>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!products.data.length">
              <td colspan="7" class="text-center text-muted py-4">{{ t('no_products_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="products.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  products: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const q = ref(props.filters?.q || '')
let searchTimer = null
const openMenuId = ref(null)

function clearSearch() {
  q.value = ''
  router.get('/admin/products', {}, { preserveState: true, replace: true })
}

function toggleMenu(id) {
  openMenuId.value = openMenuId.value === id ? null : id
}

function handleDocumentClick() {
  openMenuId.value = null
}

function destroy(product) {
  if (!confirm(`${t('confirm_remove')} "${product.name}"?`)) return
  router.delete(`/admin/products/${product.id}`, { preserveScroll: true })
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}

onMounted(() => {
  document.addEventListener('click', handleDocumentClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleDocumentClick)
})

watch(q, (value) => {
  if (searchTimer) clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    router.get('/admin/products', { q: value || undefined }, { preserveState: true, replace: true })
  }, 300)
})
</script>

<style scoped>
.dropdown-menu.show {
  position: absolute;
  top: calc(100% + 6px);
  right: 0;
  left: auto;
  margin: 0;
  z-index: 1060;
}
</style>
