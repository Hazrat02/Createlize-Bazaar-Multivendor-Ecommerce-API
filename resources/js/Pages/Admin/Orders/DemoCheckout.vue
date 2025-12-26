<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Demo Checkout</h2>
            <p class="text-sm text-muted">Confirm required info and proceed to payment.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/orders/demo" class="main-btn primary-btn-outline btn-hover">Back</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-5">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Order Summary</h6>
            <div class="summary-grid">
              <div>
                <span class="text-sm text-muted">Customer</span>
                <div class="fw-semibold">{{ user.name }} ({{ user.email }})</div>
              </div>
              <div>
                <span class="text-sm text-muted">Product</span>
                <div class="fw-semibold">{{ product.display_name }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Qty</span>
                <div class="fw-semibold">{{ qty }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Total</span>
                <div class="fw-semibold">{{ formatAmount(total) }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Payment Method</span>
                <div class="fw-semibold">
                  {{ paymentMethodLabel }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Required Information</h6>
            <form @submit.prevent="submit">
              <div class="row">
                <template v-for="field in requiredFields" :key="field.name">
                  <div class="col-12">
                    <div class="input-style-1" v-if="field.type === 'textarea'">
                      <label>{{ field.title }} <span v-if="field.required" class="text-danger">*</span></label>
                      <textarea
                        v-model="form.required_data[field.name]"
                        class="form-control"
                        :placeholder="field.placeholder || ''"
                        rows="3"
                      ></textarea>
                    </div>
                    <div class="input-style-1" v-else-if="field.type === 'select'">
                      <label>{{ field.title }} <span v-if="field.required" class="text-danger">*</span></label>
                      <select v-model="form.required_data[field.name]" class="form-control">
                        <option value="">Select</option>
                        <option v-for="option in field.options || []" :key="option" :value="option">
                          {{ option }}
                        </option>
                      </select>
                    </div>
                    <div class="input-style-1" v-else-if="field.type === 'file'">
                      <label>{{ field.title }} <span v-if="field.required" class="text-danger">*</span></label>
                      <input type="file" class="form-control" @change="onFileChange($event, field.name)" />
                    </div>
                    <div class="input-style-1" v-else>
                      <label>{{ field.title }} <span v-if="field.required" class="text-danger">*</span></label>
                      <input
                        v-model="form.required_data[field.name]"
                        :type="inputType(field.type)"
                        class="form-control"
                        :placeholder="field.placeholder || ''"
                      />
                    </div>
                    <div v-if="form.errors[`required_data.${field.name}`]" class="text-danger text-sm mt-1">
                      {{ form.errors[`required_data.${field.name}`] }}
                    </div>
                  </div>
                </template>
                <div class="col-12">
                  <div class="input-style-1">
                    <label>Coupon Code</label>
                    <input v-model="form.coupon_code" type="text" class="form-control" placeholder="Optional" />
                    <div v-if="form.errors.coupon_code" class="text-danger text-sm mt-1">
                      {{ form.errors.coupon_code }}
                    </div>
                  </div>
                </div>
                <div class="col-12 mt-2">
                  <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                    {{ form.processing ? 'Redirecting...' : submitLabel }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  user: { type: Object, required: true },
  product: { type: Object, required: true },
  qty: { type: Number, required: true },
  requiredFields: { type: Array, default: () => [] },
  paymentMode: { type: String, default: 'sandbox' },
  paymentMethod: { type: String, default: 'uddoktapay' },
  total: { type: Number, required: true },
})

const form = useForm({
  required_data: {},
  coupon_code: '',
})

const paymentMethodLabel = computed(() => {
  if (props.paymentMethod === 'cod') {
    return 'Cash on Delivery'
  }
  return props.paymentMode === 'live' ? 'UddoktaPay (Live)' : 'UddoktaPay (Sandbox)'
})

const submitLabel = computed(() => {
  return props.paymentMethod === 'cod' ? 'Place Order' : 'Proceed to Pay'
})

function inputType(type) {
  if (type === 'email') return 'email'
  if (type === 'phone') return 'tel'
  return 'text'
}

function onFileChange(event, name) {
  form.required_data[name] = event.target.files[0]
}

function submit() {
  form.post('/admin/orders/demo/checkout', {
    forceFormData: true,
  })
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}
</script>

<style scoped>
.summary-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 12px;
}
</style>
