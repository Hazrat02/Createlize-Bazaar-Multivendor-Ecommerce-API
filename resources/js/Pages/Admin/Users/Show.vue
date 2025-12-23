<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('view_user') }}</h2>
            <p class="text-sm text-muted">{{ user.name }} ({{ user.email }})</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <button class="main-btn primary-btn btn-hover" type="button" @click="openMail">
              {{ t('send_mail') }}
            </button>
            <Link :href="`/admin/users/${user.id}/edit`" class="main-btn primary-btn-outline btn-hover ms-2">
              {{ t('edit') }}
            </Link>
            <Link href="/admin/users" class="main-btn primary-btn-outline btn-hover ms-2">{{ t('back') }}</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card-style mb-30">
          <div class="title d-flex align-items-center justify-content-between">
            <h6 class="text-medium">{{ t('user_profile') }}</h6>
            <span class="status-btn" :class="user.status === 'active' ? 'success-btn' : 'close-btn'">
              {{ user.status === 'active' ? t('active') : t('banned') }}
            </span>
          </div>
          <div class="profile-block mt-3">
            <div class="profile-avatar">
              <img src="@/../admin/assets/images/profile/profile-image.png" alt="" />
            </div>
            <div class="profile-details">
              <h6 class="mb-1">{{ user.name }}</h6>
              <p class="text-sm text-muted mb-0">{{ user.email }}</p>
              <p class="text-sm text-muted mb-0">{{ formatRoles(user.roles) }}</p>
            </div>
          </div>
          <div class="profile-meta mt-3">
            <div class="meta-item">
              <span class="text-sm text-muted">{{ t('created') }}</span>
              <span class="fw-semibold">{{ formatDate(user.created_at) }}</span>
            </div>
            <div class="meta-item">
              <span class="text-sm text-muted">{{ t('status') }}</span>
              <span class="fw-semibold">{{ user.status }}</span>
            </div>
          </div>
          <div class="mt-3">
            <button v-if="user.status !== 'banned'" class="main-btn danger-btn-outline btn-hover btn-sm" @click="ban">
              {{ t('ban') }}
            </button>
            <button v-else class="main-btn primary-btn-outline btn-hover btn-sm" @click="unban">
              {{ t('unban') }}
            </button>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="text-medium">{{ t('payment_history') }}</h6>
            <small class="text-muted">{{ payments.length }} {{ t('items') }}</small>
          </div>
          <div class="table-responsive mt-3">
            <table class="table top-selling-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ t('total') }}</th>
                  <th>{{ t('payment') }}</th>
                  <th>{{ t('status') }}</th>
                  <th>{{ t('created') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                  <td class="fw-semibold">#{{ payment.order_number || payment.id }}</td>
                  <td class="text-muted">{{ formatAmount(payment.total) }}</td>
                  <td class="text-muted">{{ payment.payment_method || '-' }}</td>
                  <td class="text-muted">{{ payment.payment_status || '-' }}</td>
                  <td class="text-muted">{{ formatDate(payment.created_at) }}</td>
                </tr>
                <tr v-if="!payments.length">
                  <td colspan="5" class="text-center text-muted py-3">{{ t('no_payments_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card-style mb-30">
          <div class="title d-flex flex-wrap justify-content-between align-items-center">
            <h6 class="text-medium">{{ t('order_history') }}</h6>
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
                  <th>{{ t('actions') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders" :key="order.id">
                  <td class="fw-semibold">#{{ order.order_number || order.id }}</td>
                  <td class="text-muted">{{ formatAmount(order.total) }}</td>
                  <td class="text-muted">{{ order.payment_status || '-' }}</td>
                  <td class="text-muted">{{ order.order_status || '-' }}</td>
                  <td>
                    <Link :href="`/admin/orders/${order.id}`" class="text-primary">{{ t('view') }}</Link>
                  </td>
                </tr>
                <tr v-if="!orders.length">
                  <td colspan="5" class="text-center text-muted py-3">{{ t('no_orders_found') }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div v-if="mailOpen" class="modal-backdrop">
      <div class="modal-card">
        <div class="modal-header">
          <h5 class="mb-0">{{ t('send_mail') }}</h5>
          <button type="button" class="btn-close" @click="closeMail" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-style-1">
            <label>{{ t('subject') }}</label>
            <input v-model="mailForm.subject" type="text" class="form-control" />
            <div v-if="mailForm.errors.subject" class="text-danger text-sm mt-1">{{ mailForm.errors.subject }}</div>
          </div>
          <div class="input-style-1 mt-2">
            <label>{{ t('message') }}</label>
            <textarea v-model="mailForm.message" rows="5" class="form-control"></textarea>
            <div v-if="mailForm.errors.message" class="text-danger text-sm mt-1">{{ mailForm.errors.message }}</div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="main-btn dark-btn-outline btn-hover" type="button" @click="closeMail">{{ t('cancel') }}</button>
          <button class="main-btn primary-btn btn-hover" type="button" :disabled="mailForm.processing" @click="sendMail">
            {{ mailForm.processing ? t('sending') : t('send') }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router, useForm, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  user: { type: Object, required: true },
  orders: { type: Array, default: () => [] },
  payments: { type: Array, default: () => [] },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const mailOpen = ref(false)
const mailForm = useForm({
  subject: '',
  message: '',
})

function openMail() {
  mailOpen.value = true
}

function closeMail() {
  mailOpen.value = false
}

function sendMail() {
  mailForm.post(`/admin/users/${props.user.id}/mail`, {
    preserveScroll: true,
    onSuccess: () => {
      mailForm.reset()
      closeMail()
    },
  })
}

function ban() {
  if (!confirm(`${t('confirm_ban')} "${props.user.name}"?`)) return
  router.post(`/admin/users/${props.user.id}/ban`, { preserveScroll: true })
}

function unban() {
  if (!confirm(`${t('confirm_unban')} "${props.user.name}"?`)) return
  router.post(`/admin/users/${props.user.id}/unban`, { preserveScroll: true })
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}

function formatRoles(roles) {
  if (!roles || !roles.length) return '-'
  return roles.map((role) => role.name).join(', ')
}

function formatDate(value) {
  if (!value) return '-'
  return new Date(value).toLocaleDateString()
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

.modal-backdrop {
  position: fixed;
  inset: 0;
  background: rgba(17, 24, 39, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1100;
  padding: 24px 16px;
}

.modal-card {
  width: 100%;
  max-width: 640px;
  background: #fff;
  border-radius: 8px;
  padding: 20px;
  max-height: calc(100vh - 48px);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #e5e7eb;
  padding-bottom: 12px;
}

.modal-body {
  padding-top: 16px;
  overflow-y: auto;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding-top: 12px;
  flex-wrap: wrap;
}

@media (max-width: 768px) {
  .modal-footer {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>
