<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('create_delivery_type') }}</h2>
            <p class="text-sm text-muted">{{ t('add_delivery_type') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/deliveries" class="main-btn primary-btn-outline btn-hover">{{ t('back') }}</Link>
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
                <input v-model="form.name" type="text" class="form-control" placeholder="e.g. Online Delivery" />
                <div v-if="form.errors.name" class="text-danger text-sm mt-1">{{ form.errors.name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('key') }} <span class="text-danger">*</span></label>
                <input v-model="form.key" type="text" class="form-control" placeholder="online_delivery" />
                <div v-if="form.errors.key" class="text-danger text-sm mt-1">{{ form.errors.key }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('sort_order') }}</label>
                <input v-model.number="form.sort_order" type="number" min="0" class="form-control" />
                <div v-if="form.errors.sort_order" class="text-danger text-sm mt-1">{{ form.errors.sort_order }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-check form-switch mt-2">
                <input id="delivery-type-active" class="form-check-input" type="checkbox" v-model="form.is_active" />
                <label class="form-check-label" for="delivery-type-active">{{ t('active') }}</label>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                {{ form.processing ? t('saving') : t('create') }}
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

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  name: '',
  key: '',
  sort_order: 0,
  is_active: true,
})

function submit() {
  form.post('/admin/deliveries')
}
</script>
