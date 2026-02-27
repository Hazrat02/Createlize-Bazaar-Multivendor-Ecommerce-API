<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('banners_title') }}</h2>
            <p class="text-sm text-muted">{{ t('manage_banners') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/banners/create" class="main-btn primary-btn btn-hover">
              + {{ t('add_banner') }}
            </Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('banners_title') }}</h6>
        </div>
        <div class="right d-flex flex-wrap gap-2">
          <input
            v-model="q"
            type="text"
            class="light-bg form-control"
            :placeholder="t('search_banner_placeholder')"
            aria-label="Search banners"
          />
        </div>
      </div>
      <div v-if="q" class="text-end mb-3">
        <button class="main-btn danger-btn-outline btn-hover btn-sm" @click="clearSearch">
          {{ t('clear') }}
        </button>
      </div>

      <div class="table-responsive">
        <table class="table top-selling-table">
          <thead>
            <tr>
              <th style="width: 70px;">#</th>
              <th>{{ t('title') }}</th>
              <th>{{ t('order') }}</th>
              <th>{{ t('active') }}</th>
              <th class="min-width">{{ t('schedule') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(banner, idx) in banners.data" :key="banner.id">
              <td>{{ (banners.from || 1) + idx }}</td>
              <td class="fw-semibold">
                {{ banner.title || t('untitled') }}
                <div v-if="banner.subtitle" class="text-muted text-sm">{{ banner.subtitle }}</div>
              </td>
              <td>{{ banner.sort_order }}</td>
              <td>
                <span class="status-btn" :class="banner.is_active ? 'success-btn' : 'close-btn'">
                  {{ banner.is_active ? t('active') : t('inactive') }}
                </span>
              </td>
              <td class="text-muted text-sm">
                {{ formatSchedule(banner.starts_at, banner.ends_at) }}
              </td>
              <td class="text-end">
                <div class="action d-inline-block" style="position: relative;">
                  <button
                    class="more-btn"
                    type="button"
                    :aria-expanded="openMenuId === banner.id ? 'true' : 'false'"
                    @click.stop="toggleMenu(banner.id)"
                  >
                    <i class="lni lni-more-alt"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" :class="{ show: openMenuId === banner.id }">
                    <li class="dropdown-item">
                      <Link :href="`/admin/banners/${banner.id}/edit`" class="text-gray">{{ t('edit') }}</Link>
                    </li>
                    <li class="dropdown-item">
                      <a type="button" class="text-gray bg-transparent border-0 p-0" @click="destroy(banner)">
                        {{ t('remove') }}
                      </a>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr v-if="!banners.data.length">
              <td colspan="6" class="text-center text-muted py-4">{{ t('no_banners_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="banners.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  banners: { type: Object, required: true },
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
  router.get(
    '/admin/banners',
    { q: q.value || undefined },
    { preserveState: true, replace: true }
  )
}

function clearSearch() {
  q.value = ''
  applySearch()
}

function destroy(banner) {
  if (!confirm(`${t('confirm_delete_banner')} "${banner.title || t('untitled')}"?`)) return
  router.delete(`/admin/banners/${banner.id}`, { preserveScroll: true })
}

function toggleMenu(id) {
  openMenuId.value = openMenuId.value === id ? null : id
}

function handleDocumentClick() {
  openMenuId.value = null
}

function formatSchedule(start, end) {
  if (!start && !end) return t('always_on')
  const pieces = []
  if (start) pieces.push(new Date(start).toLocaleDateString())
  if (end) pieces.push(new Date(end).toLocaleDateString())
  return pieces.join(' - ')
}

onMounted(() => {
  document.addEventListener('click', handleDocumentClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleDocumentClick)
})

watch(q, () => {
  if (searchTimer) clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    applySearch()
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
