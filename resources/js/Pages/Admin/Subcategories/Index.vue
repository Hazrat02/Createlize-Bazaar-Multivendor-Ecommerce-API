<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('subcategories_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_subcategories') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/subcategories/create" class="main-btn primary-btn btn-hover">
              + {{ t('add_subcategory') }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('subcategories_title') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            <div class="select-position select-sm">
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_subcategory_placeholder')"
                aria-label="Search subcategories"
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
              <th>{{ t('subcategory') }}</th>
              <th>{{ t('category') }}</th>
              <th>{{ t('slug') }}</th>
              <th class="min-width">{{ t('status') }}</th>
              <th class="min-width">{{ t('active') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(sub, idx) in subcategories.data" :key="sub.id">
              <td>{{ (subcategories.from || 1) + idx }}</td>
              <td class="fw-semibold">{{ sub.name }}</td>
              <td class="text-muted">{{ sub.category?.name || '-' }}</td>
              <td class="text-muted">{{ sub.slug }}</td>
              <td>
                <span class="status-btn" :class="sub.is_active ? 'success-btn' : 'close-btn'">
                  {{ sub.is_active ? t('active') : t('inactive') }}
                </span>
              </td>
              <td>
                <div class="form-check form-switch">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    :id="`subcategory-active-${sub.id}`"
                    :checked="!!sub.is_active"
                    @change="toggleActive(sub, $event)"
                  />
                </div>
              </td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button
                    class="more-btn"
                    type="button"
                    :aria-expanded="openMenuId === sub.id ? 'true' : 'false'"
                    @click.stop="toggleMenu(sub.id)"
                  >
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === sub.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/subcategories/${sub.id}/edit`" class="text-gray">{{ t('edit') }}</Link>
                    </li>
                    <li class="dropdown-item">
                      <button type="button" class="text-gray bg-transparent border-0 p-0" @click="destroy(sub)">
                        {{ t('remove') }}
                      </button>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!subcategories.data.length">
              <td colspan="7" class="text-center text-muted py-4">{{ t('no_subcategories_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="subcategories.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { onMounted, onUnmounted, ref, watch, computed } from 'vue'

const props = defineProps({
  subcategories: { type: Object, required: true },
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
  router.get('/admin/subcategories', { q: q.value || undefined }, { preserveState: true, replace: true })
}

function clearSearch() {
  q.value = ''
  applySearch()
}

function destroy(sub) {
  if (!confirm(`${t('confirm_remove')} "${sub.name}"?`)) return
  router.delete(`/admin/subcategories/${sub.id}`, { preserveScroll: true })
}

function toggleActive(sub, event) {
  const isActive = event.target.checked ? 1 : 0
  router.put(
    `/admin/subcategories/${sub.id}`,
    { name: sub.name, category_id: sub.category_id, is_active: isActive },
    { preserveScroll: true, preserveState: true }
  )
}

function toggleMenu(id) {
  openMenuId.value = openMenuId.value === id ? null : id
}

function handleDocumentClick() {
  openMenuId.value = null
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
    router.get('/admin/subcategories', { q: value || undefined }, { preserveState: true, replace: true })
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
