<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('edit_subcategory') }}</h2>
            <p class="text-sm text-muted">{{ t('update_subcategory_details') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/subcategories" class="main-btn primary-btn-outline btn-hover">{{ t('back') }}</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="card-content">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-md-6">
              <div class="select-style-1">
                <label>{{ t('category') }} <span class="text-danger">*</span></label>
                <div class="select-position">
                  <select v-model="form.category_id" class="form-control">
                    <option value="" disabled>{{ t('select_category') }}</option>
                    <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                      {{ cat.name }}
                    </option>
                  </select>
                </div>
                <div v-if="form.errors.category_id" class="text-danger text-sm mt-1">{{ form.errors.category_id }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('name') }} <span class="text-danger">*</span></label>
                <input v-model="form.name" type="text" class="form-control" :placeholder="t('subcategory_name_placeholder')" />
                <div v-if="form.errors.name" class="text-danger text-sm mt-1">{{ form.errors.name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check form-switch mt-2">
                <input id="subcategory-active" class="form-check-input" type="checkbox" v-model="form.is_active" />
                <label class="form-check-label" for="subcategory-active">{{ t('active') }}</label>
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
  subcategory: { type: Object, required: true },
  categories: { type: Array, required: true },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  category_id: props.subcategory.category_id,
  name: props.subcategory.name,
  is_active: !!props.subcategory.is_active,
})

function submit() {
  form.put(`/admin/subcategories/${props.subcategory.id}`)
}
</script>
