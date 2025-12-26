<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Coupons</h2>
            <p class="text-sm text-muted">Manage discount coupons.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/coupons/create" class="main-btn primary-btn btn-hover">+ Add Coupon</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="table-responsive">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Code</th>
              <th>Type</th>
              <th>Value</th>
              <th>Status</th>
              <th>Valid</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(coupon, idx) in coupons.data" :key="coupon.id">
              <td>{{ (coupons.from || 1) + idx }}</td>
              <td class="fw-semibold">{{ coupon.code }}</td>
              <td class="text-muted">{{ coupon.type }}</td>
              <td class="text-muted">{{ formatValue(coupon) }}</td>
              <td>
                <span class="status-btn" :class="coupon.status === 'active' ? 'success-btn' : 'close-btn'">
                  {{ coupon.status }}
                </span>
              </td>
              <td class="text-muted">{{ formatDate(coupon.start_at) }} → {{ formatDate(coupon.end_at) }}</td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button class="more-btn" type="button" @click.stop="toggleMenu(coupon.id)">
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === coupon.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/coupons/${coupon.id}/edit`" class="text-gray">Edit</Link>
                    </li>
                    <li class="dropdown-item">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="destroy(coupon)">
                        Remove
                      </button>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!coupons.data.length">
              <td colspan="7" class="text-center text-muted py-4">No coupons found.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="coupons.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref } from 'vue'

const props = defineProps({
  coupons: { type: Object, required: true },
})

const openMenuId = ref(null)

function toggleMenu(id) {
  openMenuId.value = openMenuId.value === id ? null : id
}

function handleDocumentClick() {
  openMenuId.value = null
}

function destroy(coupon) {
  if (!confirm(`Remove coupon "${coupon.code}"?`)) return
  router.delete(`/admin/coupons/${coupon.id}`, { preserveScroll: true })
}

function formatDate(value) {
  if (!value) return '-'
  return new Date(value).toLocaleDateString()
}

function formatValue(coupon) {
  if (!coupon) return '-'
  if (coupon.type === 'percentage') return `${Number(coupon.value).toFixed(2)}%`
  return Number(coupon.value).toFixed(2)
}

onMounted(() => {
  document.addEventListener('click', handleDocumentClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleDocumentClick)
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
