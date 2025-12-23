<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('edit_user') }}</h2>
            <p class="text-sm text-muted">{{ user.name }} ({{ user.email }})</p>
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
                <label>{{ t('password') }}</label>
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
                <label>{{ t('profile_image') }}</label>
                <input type="file" class="form-control" @change="onFileChange" />
                <div v-if="form.errors.profile_image" class="text-danger text-sm mt-1">
                  {{ form.errors.profile_image }}
                </div>
              </div>
            </div>
            <div class="col-12" v-if="profileImageUrl">
              <img :src="profileImageUrl" alt="Profile" class="profile-preview" />
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
  user: { type: Object, required: true },
  roles: { type: Array, default: () => [] },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  name: props.user.name || '',
  email: props.user.email || '',
  password: '',
  status: props.user.status || 'active',
  role: props.roles?.[0] || 'Customer',
  profile_image: null,
})

const profileImageUrl = computed(() => {
  if (!props.user.profile_image) return ''
  return `/storage/${props.user.profile_image}`
})

function onFileChange(event) {
  form.profile_image = event.target.files[0]
}

function submit() {
  form.put(`/admin/users/${props.user.id}`, { forceFormData: true })
}
</script>

<style scoped>
.profile-preview {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  object-fit: cover;
  border: 1px solid #e5e7eb;
}
</style>
