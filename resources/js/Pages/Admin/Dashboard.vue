<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('ecommerce_dashboard') }}</h2>
            <p class="text-sm text-muted">{{ t('live_overview') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="breadcrumb-wrapper text-md-end mb-30">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">{{ t('dashboard') }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ t('overview') }}</li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon primary">
            <i class="lni lni-cart-full"></i>
          </div>
          <div class="content">
            <h6 class="mb-10">{{ t('total_orders') }}</h6>
            <h3 class="text-bold mb-10">{{ stats.orders_total }}</h3>
            <p class="text-sm text-muted">
              {{ t('created') }}: {{ stats.orders_created }} | {{ t('processing') }}: {{ stats.orders_processing }}
            </p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon success">
            <i class="lni lni-dollar"></i>
          </div>
          <div class="content">
            <h6 class="mb-10">{{ t('paid_revenue') }}</h6>
            <h3 class="text-bold mb-10">{{ formatCurrency(stats.revenue_total) }}</h3>
            <p class="text-sm text-muted">{{ t('paid_orders_only') }}</p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon warning">
            <i class="lni lni-package"></i>
          </div>
          <div class="content">
            <h6 class="mb-10">{{ t('products_label') }}</h6>
            <h3 class="text-bold mb-10">{{ stats.products_total }}</h3>
            <p class="text-sm text-muted">{{ t('categories_label') }}: {{ stats.categories_total }}</p>
          </div>
        </div>
      </div>

      <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
          <div class="icon purple">
            <i class="lni lni-users"></i>
          </div>
          <div class="content">
            <h6 class="mb-10">{{ t('users_label') }}</h6>
            <h3 class="text-bold mb-10">{{ stats.customers_total }}</h3>
            <p class="text-sm text-muted">{{ t('vendors_label') }}: {{ stats.vendors_total }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-5">
        <div class="card-style mb-30">
          <div class="title d-flex justify-content-between align-items-center">
            <div class="left">
              <h6 class="text-medium mb-30">{{ t('order_status') }}</h6>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <td>{{ t('created') }}</td>
                  <td class="text-end"><span class="status-btn close-btn">{{ stats.orders_created }}</span></td>
                </tr>
                <tr>
                  <td>{{ t('processing') }}</td>
                  <td class="text-end"><span class="status-btn warning-btn">{{ stats.orders_processing }}</span></td>
                </tr>
                <tr>
                  <td>{{ t('delivered') }}</td>
                  <td class="text-end"><span class="status-btn success-btn">{{ stats.orders_delivered }}</span></td>
                </tr>
                <tr>
                  <td>{{ t('canceled') }}</td>
                  <td class="text-end"><span class="status-btn close-btn">{{ stats.orders_canceled }}</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap align-items-center justify-content-between">
            <div class="left">
              <h6 class="text-medium mb-30">{{ t('traffic_analysis') }}</h6>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-md-8">
              <svg viewBox="0 0 100 60" width="100%" height="120" aria-label="Traffic chart">
                <polyline
                  :points="trafficPoints"
                  fill="none"
                  stroke="#365CF5"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
                <line x1="0" y1="55" x2="100" y2="55" stroke="rgba(143, 146, 161, .2)" stroke-width="1" />
              </svg>
            </div>
            <div class="col-md-4">
              <ul class="list-unstyled mb-0">
                <li class="mb-2"><span class="text-sm text-muted">{{ t('last_7_days') }}</span></li>
                <li class="mb-2">
                  <span class="text-sm">{{ t('total_label') }}</span>
                  <span class="float-end fw-500">{{ trafficTotal }}</span>
                </li>
                <li class="mb-2">
                  <span class="text-sm">{{ t('peak_label') }}</span>
                  <span class="float-end fw-500">{{ trafficPeak }}</span>
                </li>
                <li class="mb-0">
                  <span class="text-sm">{{ t('today_label') }}</span>
                  <span class="float-end fw-500">{{ trafficToday }}</span>
                </li>
              </ul>
            </div>
          </div>
          <div class="d-flex justify-content-between mt-3">
            <span v-for="(label, idx) in traffic.labels" :key="`t-${idx}`" class="text-xs text-muted">
              {{ label }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap align-items-center justify-content-between">
            <div class="left">
              <h6 class="text-medium mb-30">{{ t('recent_orders') }}</h6>
            </div>
            <div class="right">
              <Link href="/admin/orders" class="main-btn primary-btn-outline btn-hover btn-sm">{{ t('view_all') }}</Link>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table top-selling-table">
              <thead>
                <tr>
                  <th><h6 class="text-sm text-medium">{{ t('order') }}</h6></th>
                  <th class="min-width"><h6 class="text-sm text-medium">{{ t('customer') }}</h6></th>
                  <th class="min-width"><h6 class="text-sm text-medium">{{ t('vendor') }}</h6></th>
                  <th class="min-width"><h6 class="text-sm text-medium">{{ t('total') }}</h6></th>
                  <th class="min-width"><h6 class="text-sm text-medium">{{ t('payment') }}</h6></th>
                  <th class="min-width"><h6 class="text-sm text-medium">{{ t('status') }}</h6></th>
                  <th><h6 class="text-sm text-medium text-end">{{ t('actions') }}</h6></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in recentOrders" :key="order.id">
                  <td>
                    <div class="product">
                      <p class="text-sm">{{ order.order_number }}</p>
                      <span class="text-xs text-muted">{{ formatDate(order.created_at) }}</span>
                    </div>
                  </td>
                  <td><p class="text-sm">{{ order.customer?.name || 'Customer' }}</p></td>
                  <td><p class="text-sm">{{ order.vendor?.name || 'Vendor' }}</p></td>
                  <td><p class="text-sm">{{ formatCurrency(order.total, order.currency) }}</p></td>
                  <td>
                    <span class="status-btn" :class="statusClass(order.payment_status)">
                      {{ order.payment_status }}
                    </span>
                  </td>
                  <td>
                    <span class="status-btn" :class="statusClass(order.order_status)">
                      {{ order.order_status }}
                    </span>
                  </td>
                  <td class="text-end">
                    <Link :href="`/admin/orders/${order.id}`" class="main-btn primary-btn-outline btn-hover btn-sm">
                      {{ t('view') }}
                    </Link>
                  </td>
                </tr>
                <tr v-if="!recentOrders.length">
                  <td colspan="7" class="text-center text-muted py-4">{{ t('no_orders_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      orders_total: 0,
      orders_created: 0,
      orders_processing: 0,
      orders_delivered: 0,
      orders_canceled: 0,
      revenue_total: 0,
      products_total: 0,
      categories_total: 0,
      vendors_total: 0,
      customers_total: 0,
    }),
  },
  recentOrders: {
    type: Array,
    default: () => [],
  },
  traffic: {
    type: Object,
    default: () => ({
      labels: [],
      values: [],
    }),
  },
})

const stats = props.stats
const recentOrders = props.recentOrders
const traffic = props.traffic

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const trafficTotal = traffic.values.reduce((sum, value) => sum + Number(value || 0), 0)
const trafficPeak = Math.max(0, ...traffic.values.map((value) => Number(value || 0)))
const trafficToday = traffic.values.length ? Number(traffic.values[traffic.values.length - 1] || 0) : 0

const trafficPoints = (() => {
  const values = traffic.values.length ? traffic.values : [0]
  const maxValue = Math.max(1, ...values.map((value) => Number(value || 0)))
  const count = values.length
  const padding = 5
  const height = 55 - padding
  return values
    .map((value, index) => {
      const x = count === 1 ? 50 : (index / (count - 1)) * 100
      const y = 55 - (Number(value || 0) / maxValue) * height
      return `${x.toFixed(2)},${y.toFixed(2)}`
    })
    .join(' ')
})()

function formatCurrency(value, currency = 'BDT') {
  const amount = Number(value || 0)
  return `${currency} ${amount.toFixed(2)}`
}

function formatDate(value) {
  if (!value) return ''
  return new Date(value).toLocaleDateString()
}

function statusClass(value = '') {
  const key = String(value).toLowerCase()
  if (key === 'paid' || key === 'delivered') return 'success-btn'
  if (key === 'processing' || key === 'pending') return 'warning-btn'
  if (key === 'failed' || key === 'canceled' || key === 'cancelled') return 'close-btn'
  return 'primary-btn'
}
</script>
