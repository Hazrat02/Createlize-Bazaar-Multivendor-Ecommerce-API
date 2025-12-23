<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('required_fields') }}</h2>
            <p class="text-sm text-muted">{{ deliveryType.name }} ({{ deliveryType.key }})</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link :href="`/admin/deliveries/${deliveryType.id}/fields/create`" class="main-btn primary-btn btn-hover">
              + {{ t('add_field') }}
            </Link>
            <Link href="/admin/deliveries" class="main-btn primary-btn-outline btn-hover ms-2">{{ t('back') }}</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="title d-flex flex-wrap justify-content-between align-items-center">
        <div class="left">
          <h6 class="text-medium mb-30">{{ t('required_fields') }}</h6>
        </div>
        <div class="right">
          <div class="select-style-1">
            <div class="select-position select-sm">
              <input
                v-model="q"
                type="text"
                class="light-bg form-control"
                :placeholder="t('search_field_placeholder')"
                aria-label="Search field"
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
              <th>{{ t('field_title') }}</th>
              <th>{{ t('field_key') }}</th>
              <th>{{ t('field_type') }}</th>
              <th>{{ t('required') }}</th>
              <th>{{ t('placeholder') }}</th>
              <th>{{ t('options') }}</th>
              <th class="text-end">{{ t('actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(field, idx) in fields.data" :key="field.id">
              <td>{{ (fields.from || 1) + idx }}</td>
              <td class="fw-semibold">{{ field.title }}</td>
              <td class="text-muted">{{ field.name }}</td>
              <td>{{ field.type }}</td>
              <td>
                <span class="status-btn" :class="field.required ? 'success-btn' : 'close-btn'">
                  {{ field.required ? t('required') : t('optional') }}
                </span>
              </td>
              <td class="text-muted">{{ field.placeholder || '-' }}</td>
              <td class="text-muted">{{ formatOptions(field.options) }}</td>
              <td class="text-end">
                <button
                  type="button"
                  class="main-btn danger-btn-outline btn-hover btn-sm"
                  @click="destroyField(field)"
                >
                  {{ t('remove') }}
                </button>
              </td>
            </tr>
            <tr v-if="!fields.data.length">
              <td colspan="8" class="text-center text-muted py-4">{{ t('no_required_fields_found') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <Pagination :links="fields.links" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'

const props = defineProps({
  deliveryType: { type: Object, required: true },
  fields: { type: Object, required: true },
  filters: { type: Object, default: () => ({}) },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const q = ref(props.filters?.q || '')
let searchTimer = null

function applySearch() {
  router.get(
    `/admin/deliveries/${props.deliveryType.id}/fields`,
    { q: q.value || undefined },
    { preserveState: true, replace: true }
  )
}

function clearSearch() {
  q.value = ''
  applySearch()
}

function destroyField(field) {
  if (!confirm(`${t('confirm_remove')} "${field.title}"?`)) return
  router.delete(`/admin/deliveries/fields/${field.id}`, { preserveScroll: true })
}

function formatOptions(options) {
  if (!options || !options.length) return '-'
  return options.join(', ')
}

watch(q, (value) => {
  if (searchTimer) clearTimeout(searchTimer)
  searchTimer = setTimeout(() => {
    router.get(
      `/admin/deliveries/${props.deliveryType.id}/fields`,
      { q: value || undefined },
      { preserveState: true, replace: true }
    )
  }, 300)
})
</script>
