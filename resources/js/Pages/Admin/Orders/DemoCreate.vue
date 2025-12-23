<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Create Demo Order</h2>
            <p class="text-sm text-muted">Select a customer and product to start checkout.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/orders" class="main-btn primary-btn-outline btn-hover">Back</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="card-content">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-md-6">
              <div class="select-style-1">
                <label>Customer</label>
                <div class="select-position">
                  <select v-model="form.user_id" class="form-control">
                    <option value="">Select customer</option>
                    <option v-for="user in users" :key="user.id" :value="user.id">
                      {{ user.name }} ({{ user.email }})
                    </option>
                  </select>
                </div>
                <div v-if="form.errors.user_id" class="text-danger text-sm mt-1">{{ form.errors.user_id }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="select-style-1">
                <label>Product</label>
                <div class="select-position">
                  <select v-model="form.product_id" class="form-control">
                    <option value="">Select product</option>
                    <option v-for="product in products" :key="product.id" :value="product.id">
                      {{ product.display_name }}
                    </option>
                  </select>
                </div>
                <div v-if="form.errors.product_id" class="text-danger text-sm mt-1">{{ form.errors.product_id }}</div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Qty</label>
                <input v-model.number="form.qty" type="number" min="1" class="form-control" />
                <div v-if="form.errors.qty" class="text-danger text-sm mt-1">{{ form.errors.qty }}</div>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                {{ form.processing ? 'Continue...' : 'Continue to Checkout' }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  users: { type: Array, default: () => [] },
  products: { type: Array, default: () => [] },
})

const form = useForm({
  user_id: '',
  product_id: '',
  qty: 1,
})

function submit() {
  form.post('/admin/orders/demo')
}
</script>
