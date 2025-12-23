<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('edit_category') }}</h2>
            <p class="text-sm text-muted">{{ t('update_category_details') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/categories" class="main-btn primary-btn-outline btn-hover">{{ t('back') }}</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="card-content">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('name') }} <span class="text-danger">*</span></label>
                <input v-model="form.name" type="text" class="form-control" :placeholder="t('category_name_placeholder')" />
                <div v-if="form.errors.name" class="text-danger text-sm mt-1">{{ form.errors.name }}</div>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                {{ form.processing ? t('saving') : t('update') }}
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
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  category: { type: Object, required: true },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  name: props.category.name,
})

function submit() {
  form.put(`/admin/categories/${props.category.id}`)
}
</script>
