<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('create_user') }}</h2>
            <p class="text-sm text-muted">{{ t('add_user') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/users" class="main-btn primary-btn-outline btn-hover">{{ t('back') }}</Link>
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
                <input v-model="form.name" type="text" class="form-control" />
                <div v-if="form.errors.name" class="text-danger text-sm mt-1">{{ form.errors.name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('email') }} <span class="text-danger">*</span></label>
                <input v-model="form.email" type="email" class="form-control" />
                <div v-if="form.errors.email" class="text-danger text-sm mt-1">{{ form.errors.email }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('password') }} <span class="text-danger">*</span></label>
                <input v-model="form.password" type="password" class="form-control" />
                <div v-if="form.errors.password" class="text-danger text-sm mt-1">{{ form.errors.password }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="select-style-1">
                <label>{{ t('status') }} <span class="text-danger">*</span></label>
                <div class="select-position">
                  <select v-model="form.status" class="form-control">
                    <option value="active">{{ t('active') }}</option>
                    <option value="banned">{{ t('banned') }}</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="select-style-1">
                <label>{{ t('role') }} <span class="text-danger">*</span></label>
                <div class="select-position">
                  <select v-model="form.role" class="form-control">
                    <option value="Admin">Admin</option>
                    <option value="Vendor">Vendor</option>
                    <option value="Customer">Customer</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('profile_image') }} <span class="text-danger">*</span></label>
                <input type="file" class="form-control" @change="onFileChange" />
                <div v-if="form.errors.profile_image" class="text-danger text-sm mt-1">
                  {{ form.errors.profile_image }}
                </div>
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
  email: '',
  password: '',
  status: 'active',
  role: 'Customer',
  profile_image: null,
})

function onFileChange(event) {
  form.profile_image = event.target.files[0]
}

function submit() {
  form.post('/admin/users', { forceFormData: true })
}
</script>
