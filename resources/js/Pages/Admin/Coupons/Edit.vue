<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Edit Coupon</h2>
            <p class="text-sm text-muted">{{ coupon.code }}</p>
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
      submit-label="Update Coupon"
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
  coupon: { type: Object, required: true },
  categories: { type: Array, default: () => [] },
  subcategories: { type: Array, default: () => [] },
  vendors: { type: Array, default: () => [] },
  products: { type: Array, default: () => [] },
})

const form = useForm({
  code: props.coupon.code || '',
  type: props.coupon.type || 'percentage',
  value: Number(props.coupon.value || 0),
  min_order_amount: props.coupon.min_order_amount,
  max_discount_amount: props.coupon.max_discount_amount,
  start_at: props.coupon.start_at ? props.coupon.start_at.substring(0, 10) : '',
  end_at: props.coupon.end_at ? props.coupon.end_at.substring(0, 10) : '',
  usage_limit_total: props.coupon.usage_limit_total,
  usage_limit_per_user: props.coupon.usage_limit_per_user,
  applicable_scope: props.coupon.applicable_scope || 'all_products',
  applicable_ids: props.coupon.applicable_ids || [],
  allowed_payment_types: props.coupon.allowed_payment_types || 'both',
  is_stackable: !!props.coupon.is_stackable,
  status: props.coupon.status || 'active',
})

function submit() {
  form.put(`/admin/coupons/${props.coupon.id}`)
}
</script>
