<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('categories_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_categories') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/categories/create" class="main-btn primary-btn btn-hover">
              + {{ t('add_category') }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('categories_title') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_category_placeholder')"
                aria-label="Search categories"
              />
           
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
                <th>{{ t('name') }}</th>
                <th>{{ t('slug') }}</th>
                <th class="min-width">{{ t('status') }}</th>
                <th class="min-width">{{ t('active') }}</th>
                <th style="" class="text-end">{{ t('actions') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(cat, idx) in categories.data" :key="cat.id">
                <td>{{ (categories.from || 1) + idx }}</td>
                <td class="fw-semibold">{{ cat.name }}</td>
                <td class="text-muted">{{ cat.slug }}</td>
                <td>
                    <span class="status-btn" :class="cat.is_active ? 'success-btn' : 'close-btn'">
                      {{ cat.is_active ? t('active') : t('inactive') }}
                    </span>
                </td>
                <td>
                  <div class="form-check form-switch">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      :id="`category-active-${cat.id}`"
                      :checked="!!cat.is_active"
                      @change="toggleActive(cat, $event)"
                    />
                  </div>
                </td>
                <td class="text-end">
                  <div class="action d-inline-block" style="position: relative;">
                    <button
                      class="more-btn"
                      type="button"
                      :aria-expanded="openMenuId === cat.id ? 'true' : 'false'"
                      @click.stop="toggleMenu(cat.id)"
                    >
                      <i class="lni lni-more-alt"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === cat.id }">
                      <li class="dropdown-item">
                        <Link :href="`/admin/categories/${cat.id}/edit`" class="text-gray">{{ t('edit') }}</Link>
                      </li>
                      <li class="dropdown-item">
                        <a type="button" class="text-gray bg-transparent border-0 p-0" @click="destroy(cat)">
                          {{ t('remove') }}
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              <tr v-if="!categories.data.length">
                <td colspan="6" class="text-center text-muted py-4">{{ t('no_categories_found') }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <Pagination :links="categories.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  categories: { type: Object, required: true },
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
  router.get('/admin/categories', { q: q.value || undefined }, { preserveState: true, replace: true })
}

function clearSearch() {
  q.value = ''
  applySearch()
}

function destroy(cat) {
  if (!confirm(`${t('confirm_delete_category')} "${cat.name}"?`)) return
  router.delete(`/admin/categories/${cat.id}`, { preserveScroll: true })
}

function toggleActive(cat, event) {
  const isActive = event.target.checked ? 1 : 0
  router.put(
    `/admin/categories/${cat.id}`,
    { name: cat.name, is_active: isActive },
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
    router.get('/admin/categories', { q: value || undefined }, { preserveState: true, replace: true })
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
