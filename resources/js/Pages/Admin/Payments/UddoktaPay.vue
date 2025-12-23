<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Payment Manage: UddoktaPay</h2>
            <p class="text-sm text-muted">Sandbox/Live settings</p>
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="card-content">
        <form @submit.prevent="submit">
          <div class="row">
            <div class="col-md-4">
              <div class="select-style-1">
                <label>Mode</label>
                <div class="select-position">
                  <select v-model="form.mode" class="form-control">
                    <option value="sandbox">Sandbox</option>
                    <option value="live">Live</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Sandbox Base URL</label>
                <input v-model="form.sandbox_base_url" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="input-style-1">
                <label>Sandbox API Key</label>
                <input v-model="form.sandbox_api_key" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Sandbox Secret</label>
                <input v-model="form.sandbox_secret" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Redirect URL</label>
                <input v-model="form.redirect_url" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Cancel URL</label>
                <input v-model="form.cancel_url" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Live Base URL</label>
                <input v-model="form.live_base_url" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Live API Key</label>
                <input v-model="form.live_api_key" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>Live Secret</label>
                <input v-model="form.live_secret" type="text" class="form-control" />
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
  mode: props.settings.mode || 'sandbox',
  sandbox_base_url: props.settings.sandbox_base_url || 'https://sandbox.uddoktapay.com',
  sandbox_api_key: props.settings.sandbox_api_key || '',
  sandbox_secret: props.settings.sandbox_secret || '',
  redirect_url: props.settings.redirect_url || '',
  cancel_url: props.settings.cancel_url || '',
  live_base_url: props.settings.live_base_url || '',
  live_api_key: props.settings.live_api_key || '',
  live_secret: props.settings.live_secret || '',
})

function submit() {
  form.post('/admin/payments/uddoktapay')
}
</script>
