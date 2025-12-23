<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('view_vendor') }}</h2>
            <p class="text-sm text-muted">{{ vendor.name }} ({{ vendor.email }})</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link :href="`/admin/vendors/${vendor.id}/edit`" class="main-btn primary-btn btn-hover">
              {{ t('edit') }}
            </Link>
            <button class="main-btn danger-btn-outline btn-hover ms-2" type="button" @click="removeProfile">
              {{ t('remove') }}
            </button>
            <Link href="/admin/vendors" class="main-btn primary-btn-outline btn-hover ms-2">{{ t('back') }}</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card-style mb-30">
          <div class="title d-flex align-items-center justify-content-between">
            <h6 class="text-medium">{{ t('vendor_profile') }}</h6>
            <span class="status-btn" :class="vendor.status === 'active' ? 'success-btn' : 'close-btn'">
              {{ vendor.status === 'active' ? t('active') : t('banned') }}
            </span>
          </div>
          <div class="profile-block mt-3">
            <div class="profile-avatar">
              <img src="@/../admin/assets/images/profile/profile-image.png" alt="" />
            </div>
            <div class="profile-details">
              <h6 class="mb-1">{{ vendorProfile?.store_name || '-' }}</h6>
              <p class="text-sm text-muted mb-0">{{ vendorProfile?.phone || '-' }}</p>
              <p class="text-sm text-muted mb-0">{{ vendorProfile?.address || '-' }}</p>
            </div>
          </div>
          <div class="profile-meta mt-3">
            <div class="meta-item">
              <span class="text-sm text-muted">{{ t('balance') }}</span>
              <span class="fw-semibold">{{ formatAmount(vendorProfile?.balance) }}</span>
            </div>
            <div class="meta-item">
              <span class="text-sm text-muted">{{ t('nid') }}</span>
              <span class="fw-semibold">{{ vendorProfile?.nid || '-' }}</span>
            </div>
          </div>
          <div class="mt-3">
            <button v-if="vendor.status !== 'banned'" class="main-btn danger-btn-outline btn-hover btn-sm" @click="ban">
              {{ t('ban') }}
            </button>
            <button v-else class="main-btn primary-btn-outline btn-hover btn-sm" @click="unban">
              {{ t('unban') }}
            </button>
          </div>
        </div>

        <div class="card-style mb-30">
          <div class="title">
            <h6 class="text-medium">{{ t('payout_info') }}</h6>
          </div>
          <pre class="text-sm payout-box">{{ formatObject(vendorProfile?.payout_info) }}</pre>
        </div>

        <div class="card-style mb-30">
          <div class="title">
            <h6 class="text-medium">{{ t('documents') }}</h6>
          </div>
          <div class="tag-list">
            <span v-for="(doc, idx) in vendorProfile?.documents || []" :key="idx" class="tag">
              {{ doc }}
            </span>
            <span v-if="!vendorProfile?.documents?.length" class="text-sm text-muted">-</span>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="text-medium">{{ t('vendor_products') }}</h6>
            <small class="text-muted">{{ products.length }} {{ t('items') }}</small>
          </div>
          <div class="table-responsive mt-3">
            <table class="table top-selling-table">
              <thead>
                <tr>
                  <th>{{ t('name') }}</th>
                  <th>{{ t('price') }}</th>
                  <th>{{ t('status') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="product in products" :key="product.id">
                  <td class="fw-semibold">{{ product.name }}</td>
                  <td class="text-muted">{{ formatAmount(product.price) }}</td>
                  <td>
                    <span class="status-btn" :class="product.is_active ? 'success-btn' : 'close-btn'">
                      {{ product.is_active ? t('active') : t('inactive') }}
                    </span>
                  </td>
                </tr>
                <tr v-if="!products.length">
                  <td colspan="3" class="text-center text-muted py-3">{{ t('no_products_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="text-medium">{{ t('vendor_orders') }}</h6>
            <small class="text-muted">{{ orders.length }} {{ t('items') }}</small>
          </div>
          <div class="table-responsive mt-3">
            <table class="table top-selling-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ t('total') }}</th>
                  <th>{{ t('payment') }}</th>
                  <th>{{ t('status') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders" :key="order.id">
                  <td class="fw-semibold">#{{ order.id }}</td>
                  <td class="text-muted">{{ formatAmount(order.total) }}</td>
                  <td class="text-muted">{{ order.payment_status || '-' }}</td>
                  <td class="text-muted">{{ order.order_status || '-' }}</td>
                </tr>
                <tr v-if="!orders.length">
                  <td colspan="4" class="text-center text-muted py-3">{{ t('no_orders_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="text-medium">{{ t('vendor_transactions') }}</h6>
            <small class="text-muted">{{ transactions.data.length }} {{ t('items') }}</small>
          </div>
          <div class="table-responsive mt-3">
            <table class="table top-selling-table">
              <thead>
                <tr>
                  <th>{{ t('created') }}</th>
                  <th>{{ t('amount') }}</th>
                  <th>{{ t('transaction_type') }}</th>
                  <th>{{ t('payment_method') }}</th>
                  <th>{{ t('reference') }}</th>
                  <th>{{ t('created_by') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="transaction in transactions.data" :key="transaction.id">
                  <td class="text-muted">{{ formatDate(transaction.created_at) }}</td>
                  <td class="fw-semibold">{{ formatAmount(transaction.amount) }}</td>
                  <td class="text-muted">{{ transaction.type }}</td>
                  <td class="text-muted">{{ transaction.payment_method || '-' }}</td>
                  <td class="text-muted">{{ transaction.reference || '-' }}</td>
                  <td class="text-muted">{{ transaction.creator?.name || '-' }}</td>
                </tr>
                <tr v-if="!transactions.data.length">
                  <td colspan="6" class="text-center text-muted py-3">{{ t('no_transactions_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <Pagination :links="transactions.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  vendor: { type: Object, required: true },
  vendorProfile: { type: Object, default: null },
  products: { type: Array, default: () => [] },
  orders: { type: Array, default: () => [] },
  transactions: { type: Object, required: true },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}

function formatObject(value) {
  if (!value) return '-'
  if (typeof value === 'string') return value
  return JSON.stringify(value, null, 2)
}

function formatDate(value) {
  if (!value) return '-'
  return new Date(value).toLocaleDateString()
}

function ban() {
  if (!confirm(`${t('confirm_ban')} "${props.vendor.name}"?`)) return
  router.post(`/admin/vendors/${props.vendor.id}/ban`, { preserveScroll: true })
}

function unban() {
  if (!confirm(`${t('confirm_unban')} "${props.vendor.name}"?`)) return
  router.post(`/admin/vendors/${props.vendor.id}/unban`, { preserveScroll: true })
}

function removeProfile() {
  if (!confirm(`${t('confirm_remove_vendor_profile')} "${props.vendor.name}"?`)) return
  router.delete(`/admin/vendors/${props.vendor.id}/profile`, { preserveScroll: true })
}
</script>

<style scoped>
.profile-block {
  display: flex;
  gap: 12px;
  align-items: center;
}

.profile-avatar img {
  width: 56px;
  height: 56px;
  border-radius: 50%;
}

.profile-meta {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

.meta-item {
  display: flex;
  flex-direction: column;
}

.payout-box {
  background: #f3f4f6;
  padding: 12px;
  border-radius: 6px;
  white-space: pre-wrap;
}

.tag-list {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
}

.tag {
  background: #eef2ff;
  color: #312e81;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 12px;
}
</style>
