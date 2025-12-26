<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Profile</h2>
            <p class="text-sm text-muted">Manage your admin profile and password.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-7">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Profile Details</h6>
            <form @submit.prevent="submitProfile">
              <div class="row">
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Name</label>
                    <input v-model="profileForm.name" type="text" class="form-control" />
                    <div v-if="profileForm.errors.name" class="text-danger text-sm mt-1">
                      {{ profileForm.errors.name }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Email</label>
                    <input v-model="profileForm.email" type="email" class="form-control" />
                    <div v-if="profileForm.errors.email" class="text-danger text-sm mt-1">
                      {{ profileForm.errors.email }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Profile Image</label>
                    <input type="file" class="form-control" @change="onImageChange" />
                    <div v-if="profileForm.errors.profile_image" class="text-danger text-sm mt-1">
                      {{ profileForm.errors.profile_image }}
                    </div>
                  </div>
                </div>
                <div class="col-12" v-if="avatarPreview">
                  <div class="avatar-preview">
                    <img :src="avatarPreview" alt="Profile image" />
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="main-btn primary-btn btn-hover" :disabled="profileForm.processing">
                    {{ profileForm.processing ? 'Saving...' : 'Update Profile' }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Change Password</h6>
            <form @submit.prevent="submitPassword">
              <div class="input-style-1">
                <label>Current Password</label>
                <input v-model="passwordForm.current_password" type="password" class="form-control" />
                <div v-if="passwordForm.errors.current_password" class="text-danger text-sm mt-1">
                  {{ passwordForm.errors.current_password }}
                </div>
              </div>
              <div class="input-style-1">
                <label>New Password</label>
                <input v-model="passwordForm.password" type="password" class="form-control" />
                <div v-if="passwordForm.errors.password" class="text-danger text-sm mt-1">
                  {{ passwordForm.errors.password }}
                </div>
              </div>
              <div class="input-style-1">
                <label>Confirm New Password</label>
                <input v-model="passwordForm.password_confirmation" type="password" class="form-control" />
              </div>
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="passwordForm.processing">
                {{ passwordForm.processing ? 'Updating...' : 'Update Password' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  user: { type: Object, required: true },
})

const profileForm = useForm({
  name: props.user.name || '',
  email: props.user.email || '',
  profile_image: null,
})

const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
})

const avatarPreview = computed(() => {
  if (profileForm.profile_image) {
    return URL.createObjectURL(profileForm.profile_image)
  }
  if (props.user.profile_image) {
    return `/storage/${props.user.profile_image}`
  }
  return ''
})

function onImageChange(event) {
  profileForm.profile_image = event.target.files[0] || null
}

function submitProfile() {
  profileForm.post('/admin/profile', {
    forceFormData: true,
  })
}

function submitPassword() {
  passwordForm.post('/admin/profile/password', {
    preserveScroll: true,
    onSuccess: () => {
      passwordForm.reset()
    },
  })
}
</script>

<style scoped>
.avatar-preview {
  margin-top: 12px;
  width: 120px;
  height: 120px;
  border: 1px dashed #e5e7eb;
  border-radius: 999px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f9fafb;
}

.avatar-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
