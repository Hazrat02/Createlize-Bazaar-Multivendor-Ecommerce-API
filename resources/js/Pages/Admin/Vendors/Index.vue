<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('vendors_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_vendors') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <button class="main-btn primary-btn btn-hover" type="button" @click="openModal">
              + {{ t('add_vendor') }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('vendors_title') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            <div class="select-position select-sm">
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_vendor_placeholder')"
                aria-label="Search vendors"
              />
            </div>
          </div>
        </div>
      </div>

      <div v-if="q" class="text-end mb-3">
        <button class="main-btn danger-btn-outline btn-hover btn-sm" @click="clearSearch">{{ t('clear') }}</button>
      </div>

      <div class="table-responsive">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th style="width: 80px;">#</th>
              <th>{{ t('vendor') }}</th>
              <th>{{ t('store_name') }}</th>
              <th>{{ t('balance') }}</th>
              <th>{{ t('payout_info') }}</th>
              <th class="min-width">{{ t('status') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(vendor, idx) in vendors.data" :key="vendor.id">
              <td>{{ (vendors.from || 1) + idx }}</td>
              <td>
                <div class="d-flex flex-column">
                  <span class="fw-semibold">{{ vendor.name }}</span>
                  <small class="text-muted">{{ vendor.email }}</small>
                </div>
              </td>
              <td class="text-muted">{{ vendor.vendor_profile?.store_name || '-' }}</td>
              <td class="text-muted">{{ formatAmount(vendor.vendor_profile?.balance) }}</td>
              <td class="text-muted">{{ formatPayoutInfo(vendor.vendor_profile?.payout_info) }}</td>
              <td>
                <span class="status-btn" :class="vendor.status === 'active' ? 'success-btn' : 'close-btn'">
                  {{ vendor.status === 'active' ? t('active') : t('banned') }}
                </span>
              </td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button
                    class="more-btn"
                    type="button"
                    :aria-expanded="openMenuId === vendor.id ? 'true' : 'false'"
                    @click.stop="toggleMenu(vendor.id)"
                  >
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === vendor.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/vendors/${vendor.id}`" class="text-gray">{{ t('view_vendor') }}</Link>
                    </li>
                    <li class="dropdown-item">
                      <Link :href="`/admin/vendors/${vendor.id}/edit`" class="text-gray">{{ t('edit') }}</Link>
                    </li>
                    <li class="dropdown-item" v-if="vendor.status !== 'banned'">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="ban(vendor)">
                        {{ t('ban') }}
                      </button>
                    </li>
                    <li class="dropdown-item" v-else>
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="unban(vendor)">
                        {{ t('unban') }}
                      </button>
                    </li>
                    <li class="dropdown-item">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="removeProfile(vendor)">
                        {{ t('remove') }}
                      </button>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!vendors.data.length">
              <td colspan="7" class="text-center text-muted py-4">{{ t('no_vendors_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="vendors.links" />
    </div>

    <div v-if="modalOpen" class="modal-backdrop">
      <div class="modal-card">
        <div class="modal-header">
          <h5 class="mb-0">{{ t('create_vendor') }}</h5>
          <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-style-1">
            <label>{{ t('search_user') }}</label>
            <input
              v-model="userQuery"
              type="text"
              class="form-control"
              :placeholder="t('search_user_placeholder')"
              @input="searchUsers"
            />
          </div>
          <div class="select-style-1 mt-2">
            <label>{{ t('select_user') }} <span class="text-danger">*</span></label>
            <div class="select-position">
              <select v-model="form.user_id" class="form-control">
                <option value="" disabled>{{ t('select_user') }}</option>
                <option v-for="user in availableUsers" :key="user.id" :value="user.id">
                  {{ user.name }} ({{ user.email }})
                </option>
              </select>
            </div>
            <div v-if="form.errors.user_id" class="text-danger text-sm mt-1">{{ form.errors.user_id }}</div>
          </div>

          <div class="row mt-3">
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('store_name') }} <span class="text-danger">*</span></label>
                <input v-model="form.store_name" type="text" class="form-control" />
                <div v-if="form.errors.store_name" class="text-danger text-sm mt-1">{{ form.errors.store_name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('phone') }}</label>
                <input v-model="form.phone" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('nid') }}</label>
                <input v-model="form.nid" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('balance') }}</label>
                <input v-model.number="form.balance" type="number" min="0" step="0.01" class="form-control" />
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>{{ t('address') }}</label>
                <input v-model="form.address" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>{{ t('payout_info') }}</label>
                <textarea v-model="form.payout_info" rows="3" class="form-control" placeholder='{"bank":"..."}'></textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>{{ t('documents') }}</label>
                <textarea v-model="form.documents" rows="3" class="form-control" placeholder="doc1, doc2"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="main-btn dark-btn-outline btn-hover" type="button" @click="closeModal">{{ t('cancel') }}</button>
          <button class="main-btn primary-btn btn-hover" type="button" :disabled="form.processing" @click="submit">
            {{ form.processing ? t('saving') : t('create') }}
          </button>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, useForm, usePage } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  vendors: { type: Object, required: true },
  availableUsers: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const q = ref(props.filters?.q || '')
const userQuery = ref(props.filters?.user_q || '')
let searchTimer = null
let userSearchTimer = null
const openMenuId = ref(null)
const modalOpen = ref(false)

const form = useForm({
  user_id: '',
  store_name: '',
  nid: '',
  phone: '',
  address: '',
  balance: 0,
  payout_info: '',
  documents: '',
})

function applySearch() {
  router.get('/admin/vendors', { q: q.value || undefined, user_q: userQuery.value || undefined }, { preserveState: true, replace: true })
}

function clearSearch() {
  q.value = ''
  applySearch()
}

function toggleMenu(id) {
  openMenuId.value = openMenuId.value === id ? null : id
}

function handleDocumentClick() {
  openMenuId.value = null
}

function openModal() {
  modalOpen.value = true
}

function closeModal() {
  modalOpen.value = false
}

function submit() {
  if (!form.payout_info) {
    form.payout_info = null
  }
  form.post('/admin/vendors', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset()
      closeModal()
    },
  })
}

function ban(vendor) {
  if (!confirm(`${t('confirm_ban')} "${vendor.name}"?`)) return
  router.post(`/admin/vendors/${vendor.id}/ban`, { preserveScroll: true })
}

function unban(vendor) {
  if (!confirm(`${t('confirm_unban')} "${vendor.name}"?`)) return
  router.post(`/admin/vendors/${vendor.id}/unban`, { preserveScroll: true })
}

function removeProfile(vendor) {
  if (!confirm(`${t('confirm_remove_vendor_profile')} "${vendor.name}"?`)) return
  router.delete(`/admin/vendors/${vendor.id}/profile`, { preserveScroll: true })
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}

function formatPayoutInfo(value) {
  if (!value) return '-'
  if (typeof value === 'string') return value
  return JSON.stringify(value)
}

function searchUsers() {
  if (userSearchTimer) clearTimeout(userSearchTimer)
  userSearchTimer = setTimeout(() => {
    applySearch()
  }, 300)
}

onMounted(() => {
  document.addEventListener('click', handleDocumentClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleDocumentClick)
})

watch(q, (value) => {
  if (searchTimer) clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    router.get('/admin/vendors', { q: value || undefined, user_q: userQuery.value || undefined }, { preserveState: true, replace: true })
  }, 300)
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
  max-width: 840px;
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
  .modal-backdrop {
    align-items: flex-start;
    padding: 16px 12px;
  }

  .modal-card {
    max-height: calc(100vh - 24px);
    padding: 16px;
  }

  .modal-footer {
    flex-direction: column;
    align-items: stretch;
  }
}
</style>
