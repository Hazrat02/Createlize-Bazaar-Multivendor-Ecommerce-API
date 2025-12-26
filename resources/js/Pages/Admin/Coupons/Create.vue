<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Create Coupon</h2>
            <p class="text-sm text-muted">Create a new discount coupon.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/coupons" class="main-btn primary-btn-outline btn-hover">Back</Link>
          </div>
        </div>
      </div>
    </div>

    <CouponForm
      :form="form"
      submit-label="Create Coupon"
      :categories="categories"
      :subcategories="subcategories"
      :vendors="vendors"
      :products="products"
      :submit="submit"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import CouponForm from '@/Pages/Admin/Coupons/CouponForm.vue'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
  categories: { type: Array, default: () => [] },
  subcategories: { type: Array, default: () => [] },
  vendors: { type: Array, default: () => [] },
  products: { type: Array, default: () => [] },
})

const form = useForm({
  code: '',
  type: 'percentage',
  value: 0,
  min_order_amount: null,
  max_discount_amount: null,
  start_at: '',
  end_at: '',
  usage_limit_total: null,
  usage_limit_per_user: null,
  applicable_scope: 'all_products',
  applicable_ids: [],
  allowed_payment_types: 'both',
  is_stackable: false,
  status: 'active',
})

function submit() {
  form.post('/admin/coupons')
}
</script>
