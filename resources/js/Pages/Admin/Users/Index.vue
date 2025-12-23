<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('users_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_users') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/users/create" class="main-btn primary-btn btn-hover">
              + {{ t('add_user') }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('users_title') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            <div class="select-position select-sm">
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_user_placeholder')"
                aria-label="Search users"
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
              <th>{{ t('user') }}</th>
              <th>{{ t('role') }}</th>
              <th class="min-width">{{ t('status') }}</th>
              <th>{{ t('created') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, idx) in users.data" :key="user.id">
              <td>{{ (users.from || 1) + idx }}</td>
              <td>
                <div class="d-flex flex-column">
                  <span class="fw-semibold">{{ user.name }}</span>
                  <small class="text-muted">{{ user.email }}</small>
                </div>
              </td>
              <td class="text-muted">{{ formatRole(user.roles) }}</td>
              <td>
                <span class="status-btn" :class="user.status === 'active' ? 'success-btn' : 'close-btn'">
                  {{ user.status === 'active' ? t('active') : t('banned') }}
                </span>
              </td>
              <td class="text-muted">{{ formatDate(user.created_at) }}</td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button
                    class="more-btn"
                    type="button"
                    :aria-expanded="openMenuId === user.id ? 'true' : 'false'"
                    @click.stop="toggleMenu(user.id)"
                  >
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === user.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/users/${user.id}`" class="text-gray">{{ t('view_user') }}</Link>
                    </li>
                    <li class="dropdown-item">
                      <Link :href="`/admin/users/${user.id}/edit`" class="text-gray">{{ t('edit') }}</Link>
                    </li>
                    <li class="dropdown-item" v-if="user.status !== 'banned'">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="ban(user)">
                        {{ t('ban') }}
                      </button>
                    </li>
                    <li class="dropdown-item" v-else>
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="unban(user)">
                        {{ t('unban') }}
                      </button>
                    </li>
                    <li class="dropdown-item">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="destroy(user)">
                        {{ t('remove') }}
                      </button>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!users.data.length">
              <td colspan="6" class="text-center text-muted py-4">{{ t('no_users_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="users.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  users: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const q = ref(props.filters?.q || '')
let searchTimer = null
const openMenuId = ref(null)

function applySearch() {
  router.get('/admin/users', { q: q.value || undefined }, { preserveState: true, replace: true })
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

function ban(user) {
  if (!confirm(`${t('confirm_ban')} "${user.name}"?`)) return
  router.post(`/admin/users/${user.id}/ban`, { preserveScroll: true })
}

function unban(user) {
  if (!confirm(`${t('confirm_unban')} "${user.name}"?`)) return
  router.post(`/admin/users/${user.id}/unban`, { preserveScroll: true })
}

function destroy(user) {
  if (!confirm(`${t('confirm_remove')} "${user.name}"?`)) return
  router.delete(`/admin/users/${user.id}`, { preserveScroll: true })
}

function formatRole(roles) {
  if (!roles || !roles.length) return '-'
  return roles.map((role) => role.name).join(', ')
}

function formatDate(value) {
  if (!value) return '-'
  return new Date(value).toLocaleDateString()
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
    router.get('/admin/users', { q: value || undefined }, { preserveState: true, replace: true })
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
</style>
