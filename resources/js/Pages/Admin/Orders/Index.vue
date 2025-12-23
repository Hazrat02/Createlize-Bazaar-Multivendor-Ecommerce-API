<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('orders_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_orders') }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('orders_title') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            <div class="select-position select-sm">
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_order_placeholder')"
                aria-label="Search orders"
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
              <th>#</th>
              <th>{{ t('customer') }}</th>
              <th>{{ t('vendor') }}</th>
              <th>{{ t('total') }}</th>
              <th>{{ t('payment') }}</th>
              <th>{{ t('status') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders.data" :key="order.id">
              <td class="fw-semibold">#{{ order.order_number || order.id }}</td>
              <td class="text-muted">{{ order.customer?.name || '-' }}</td>
              <td class="text-muted">{{ order.vendor?.name || '-' }}</td>
              <td class="text-muted">{{ formatAmount(order.total) }}</td>
              <td class="text-muted">{{ order.payment_status || '-' }}</td>
              <td class="text-muted">{{ order.order_status || '-' }}</td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button
                    class="more-btn"
                    type="button"
                    :aria-expanded="openMenuId === order.id ? 'true' : 'false'"
                    @click.stop="toggleMenu(order.id)"
                  >
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === order.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/orders/${order.id}`" class="text-gray">{{ t('view') }}</Link>
                    </li>
                    <li class="dropdown-item" v-if="order.order_status === 'delivered'">
                      <a :href="`/admin/orders/${order.id}/invoice`" class="text-gray" target="_blank" rel="noopener">
                        {{ t('download_invoice') }}
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!orders.data.length">
              <td colspan="7" class="text-center text-muted py-4">{{ t('no_orders_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="orders.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  orders: { type: Object, required: true },
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
  router.get('/admin/orders', {}, { preserveState: true, replace: true })
}

function toggleMenu(id) {
  openMenuId.value = openMenuId.value === id ? null : id
}

function handleDocumentClick() {
  openMenuId.value = null
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
    router.get('/admin/orders', { q: value || undefined }, { preserveState: true, replace: true })
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
