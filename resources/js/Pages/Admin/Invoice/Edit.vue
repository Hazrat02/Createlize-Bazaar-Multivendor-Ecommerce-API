<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Invoice Template</h2>
            <p class="text-sm text-muted">Configure invoice details.</p>
          </div>
        </div>
      </div>
    </div>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-6">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Company Details</h6>
              <div class="input-style-1">
                <label>Company Name</label>
                <input v-model="form.company_name" type="text" class="form-control" />
                <div v-if="form.errors.company_name" class="text-danger text-sm mt-1">
                  {{ form.errors.company_name }}
                </div>
              </div>
              <div class="input-style-1">
                <label>Company Address</label>
                <textarea v-model="form.company_address" class="form-control" rows="3"></textarea>
                <div v-if="form.errors.company_address" class="text-danger text-sm mt-1">
                  {{ form.errors.company_address }}
                </div>
              </div>
              <div class="input-style-1">
                <label>Footer Note</label>
                <textarea v-model="form.footer_note" class="form-control" rows="2"></textarea>
                <div v-if="form.errors.footer_note" class="text-danger text-sm mt-1">
                  {{ form.errors.footer_note }}
                </div>
              </div>
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save Template' }}
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Invoice Preview</h6>
              <div class="invoice-preview">
                <div class="preview-header">
                  <div>
                    <div class="preview-title">{{ form.company_name || 'Company' }}</div>
                    <div class="preview-muted">{{ form.company_address || 'Company address' }}</div>
                  </div>
                  <div class="preview-meta">
                    <div><strong>Invoice</strong></div>
                    <div class="preview-muted">Order #{{ sample.order_number }}</div>
                    <div class="preview-muted">Date: {{ sample.date }}</div>
                  </div>
                </div>
                <div class="preview-bill">
                  <strong>Bill To</strong>
                  <div class="preview-muted">{{ sample.customer_name }}</div>
                  <div class="preview-muted">{{ sample.customer_email }}</div>
                </div>
                <table class="preview-table">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in sample.items" :key="item.name">
                      <td>{{ item.name }}</td>
                      <td>{{ item.qty }}</td>
                      <td>{{ formatAmount(item.price) }}</td>
                      <td>{{ formatAmount(item.total) }}</td>
                    </tr>
                  </tbody>
                </table>
                <table class="preview-table totals">
                  <tbody>
                    <tr>
                      <td class="text-end">Subtotal</td>
                      <td class="text-end">{{ formatAmount(sample.subtotal) }}</td>
                    </tr>
                    <tr>
                      <td class="text-end">Discount</td>
                      <td class="text-end">-{{ formatAmount(sample.discount) }}</td>
                    </tr>
                    <tr>
                      <td class="text-end fw-semibold">Total</td>
                      <td class="text-end fw-semibold">{{ formatAmount(sample.total) }}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="preview-footer">{{ form.footer_note || 'Thanks for your purchase.' }}</div>
              </div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Email Preview</h6>
              <div class="email-preview">
                <div class="preview-subject">
                  Subject: {{ emailSubjectPreview }}
                </div>
                <div class="preview-body" v-html="emailBodyPreview"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  template: { type: Object, default: () => ({}) },
})

const form = useForm({
  company_name: props.template.company_name || '',
  company_address: props.template.company_address || '',
  footer_note: props.template.footer_note || '',
})

const sample = {
  order_number: 'CBZ-20250101-ABCD1234',
  customer_name: 'Demo Customer',
  customer_email: 'customer@example.com',
  date: '2025-01-01',
  items: [
    { name: 'Premium Subscription', qty: 1, price: 1200, total: 1200 },
    { name: 'Support Add-on', qty: 1, price: 300, total: 300 },
  ],
  subtotal: 1500,
  discount: 100,
  total: 1400,
}

function submit() {
  form.post('/admin/invoice-template')
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}

</script>

<style scoped>
.invoice-preview {
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 16px;
  background: #fff;
}

.preview-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 16px;
}

.preview-title {
  font-weight: 700;
  font-size: 18px;
}

.preview-muted {
  color: #6b7280;
  font-size: 12px;
}

.preview-bill {
  margin-bottom: 12px;
}

.preview-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 8px;
}

.preview-table th,
.preview-table td {
  border-bottom: 1px solid #e5e7eb;
  padding: 6px;
  font-size: 13px;
}

.preview-table th {
  background: #f9fafb;
  text-align: left;
}

.preview-table.totals td {
  border-bottom: none;
}

.preview-footer {
  margin-top: 16px;
  font-size: 12px;
  color: #6b7280;
}

</style>
