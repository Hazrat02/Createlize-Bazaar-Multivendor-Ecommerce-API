<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('order_details') }}</h2>
            <p class="text-sm text-muted">#{{ order.order_number || order.id }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <a
              v-if="order.order_status === 'delivered'"
              :href="`/admin/orders/${order.id}/invoice`"
              class="main-btn primary-btn btn-hover"
              target="_blank"
              rel="noopener"
            >
              {{ t('download_invoice') }}
            </a>
            <Link href="/admin/orders" class="main-btn primary-btn-outline btn-hover ms-2">{{ t('back') }}</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="card-content">
        <div class="row">
          <div class="col-lg-6">
            <h6 class="text-medium mb-3">{{ t('order_summary') }}</h6>
            <div class="summary-grid">
              <div>
                <span class="text-sm text-muted">{{ t('customer') }}</span>
                <div class="fw-semibold">{{ order.customer?.name || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">{{ t('vendor') }}</span>
                <div class="fw-semibold">{{ order.vendor?.name || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">{{ t('payment') }}</span>
                <div class="fw-semibold">{{ order.payment_status || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">{{ t('status') }}</span>
                <div class="fw-semibold">{{ order.order_status || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">{{ t('total') }}</span>
                <div class="fw-semibold">{{ formatAmount(order.total) }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">{{ t('payment_method') }}</span>
                <div class="fw-semibold">{{ order.payment_method || '-' }}</div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <h6 class="text-medium mb-3">{{ t('update_status') }}</h6>
            <form @submit.prevent="submit">
              <div class="row">
                <div class="col-md-6">
                  <div class="select-style-1">
                    <label>{{ t('payment') }}</label>
                    <div class="select-position">
                      <select v-model="form.payment_status" class="form-control">
                        <option value="pending">pending</option>
                        <option value="paid">paid</option>
                        <option value="unpaid">unpaid</option>
                        <option value="failed">failed</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="select-style-1">
                    <label>{{ t('status') }}</label>
                    <div class="select-position">
                      <select v-model="form.order_status" class="form-control">
                        <option value="processing">processing</option>
                        <option value="delivered">delivered</option>
                        <option value="canceled">canceled</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12 mt-2">
                  <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                    {{ form.processing ? t('saving') : t('update') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title">
        <h6 class="text-medium">{{ t('order_items') }}</h6>
      </div>
      <div class="table-responsive mt-3">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th>{{ t('name') }}</th>
              <th>{{ t('price') }}</th>
              <th>{{ t('qty') }}</th>
              <th>{{ t('total') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in order.items" :key="item.id">
              <td class="fw-semibold">{{ item.product_name || item.product?.name || '-' }}</td>
              <td class="text-muted">{{ formatAmount(item.unit_price) }}</td>
              <td class="text-muted">{{ item.qty || 1 }}</td>
              <td class="text-muted">{{ formatAmount(item.line_total) }}</td>
            </tr>
            <tr v-if="!order.items.length">
              <td colspan="4" class="text-center text-muted py-3">{{ t('no_items_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title">
        <h6 class="text-medium">{{ t('required_fields') }}</h6>
      </div>
      <div class="table-responsive mt-3">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th>{{ t('field_title') }}</th>
              <th>{{ t('field_key') }}</th>
              <th>{{ t('value') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="field in order.required_data" :key="field.id">
              <td class="fw-semibold">{{ field.field_title || '-' }}</td>
              <td class="text-muted">{{ field.field_name || '-' }}</td>
              <td class="text-muted">{{ field.value || '-' }}</td>
            </tr>
            <tr v-if="!order.required_data.length">
              <td colspan="3" class="text-center text-muted py-3">{{ t('no_required_fields_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title">
        <h6 class="text-medium">{{ t('delivery_files') }}</h6>
      </div>
      <div class="table-responsive mt-3">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th>{{ t('label') }}</th>
              <th>{{ t('file') }}</th>
              <th>{{ t('created') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="delivery in order.deliveries" :key="delivery.id">
              <td class="fw-semibold">{{ delivery.status }}</td>
              <td class="text-muted">{{ delivery.files?.length || 0 }} {{ t('items') }}</td>
              <td class="text-muted">{{ formatDate(delivery.created_at) }}</td>
            </tr>
            <tr v-if="!order.deliveries.length">
              <td colspan="3" class="text-center text-muted py-3">{{ t('no_deliveries_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <form class="mt-3" @submit.prevent="uploadFile">
        <div class="row">
          <div class="col-md-6">
            <div class="input-style-1">
              <label>{{ t('label') }}</label>
              <input v-model="uploadForm.label" type="text" class="form-control" />
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-style-1">
              <label>{{ t('file') }}</label>
              <input type="file" class="form-control" @change="onFileChange" />
            </div>
          </div>
          <div class="col-12 mt-2">
            <button type="submit" class="main-btn primary-btn btn-hover" :disabled="uploadForm.processing">
              {{ uploadForm.processing ? t('saving') : t('upload') }}
            </button>
          </div>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  order: { type: Object, required: true },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  payment_status: props.order.payment_status || 'pending',
  order_status: props.order.order_status || 'processing',
})

const uploadForm = useForm({
  label: '',
  file: null,
})

function submit() {
  form.put(`/admin/orders/${props.order.id}`)
}

function onFileChange(event) {
  uploadForm.file = event.target.files[0]
}

function uploadFile() {
  if (!uploadForm.file) return
  uploadForm.post(`/admin/orders/${props.order.id}/deliveries/upload`, {
    forceFormData: true,
    onSuccess: () => {
      uploadForm.reset()
    },
  })
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}

function formatDate(value) {
  if (!value) return '-'
  return new Date(value).toLocaleDateString()
}
</script>

<style scoped>
.summary-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
}
</style>
