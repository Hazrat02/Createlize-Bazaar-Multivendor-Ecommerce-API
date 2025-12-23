<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>SMTP Manage</h2>
            <p class="text-sm text-muted">Configure mail delivery and templates</p>
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
                <label>Mailer</label>
                <input v-model="form.mailer" type="text" class="form-control" placeholder="smtp" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Host</label>
                <input v-model="form.host" type="text" class="form-control" placeholder="smtp.example.com" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Port</label>
                <input v-model.number="form.port" type="number" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Username</label>
                <input v-model="form.username" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Password</label>
                <input v-model="form.password" type="password" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Encryption</label>
                <input v-model="form.encryption" type="text" class="form-control" placeholder="tls" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>From address</label>
                <input v-model="form.from_address" type="email" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>From name</label>
                <input v-model="form.from_name" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>Template subject</label>
                <input v-model="form.template_subject" type="text" class="form-control" />
                <small class="text-muted">Use {{name}}, {{email}}, {{subject}}</small>
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>Template body (HTML)</label>
                <textarea v-model="form.template_body" rows="6" class="form-control"></textarea>
                <small class="text-muted">Use {{message}} to include the admin message.</small>
              </div>
            </div>
            <div class="col-12">
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save' }}
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
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  settings: { type: Object, default: () => ({}) },
})

const form = useForm({
  mailer: props.settings.mailer || 'smtp',
  host: props.settings.host || '',
  port: props.settings.port || 587,
  username: props.settings.username || '',
  password: props.settings.password || '',
  encryption: props.settings.encryption || 'tls',
  from_address: props.settings.from_address || '',
  from_name: props.settings.from_name || '',
  template_subject: props.settings.template_subject || '',
  template_body: props.settings.template_body || '',
})

function submit() {
  form.post('/admin/smtp')
}
</script>
