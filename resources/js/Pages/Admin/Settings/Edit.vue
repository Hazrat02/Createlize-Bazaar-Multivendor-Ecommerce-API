<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Site Settings</h2>
            <p class="text-sm text-muted">Manage brand, currency, and language defaults.</p>
          </div>
        </div>
      </div>
    </div>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-8">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Brand</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Site Name</label>
                    <input v-model="form.site_name" type="text" class="form-control" />
                    <div v-if="form.errors.site_name" class="text-danger text-sm mt-1">{{ form.errors.site_name }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Logo Icon (1:1)</label>
                    <input type="file" class="form-control" @change="onLogoChange" />
                    <div v-if="form.errors.site_logo" class="text-danger text-sm mt-1">{{ form.errors.site_logo }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Logo Brand (1:4)</label>
                    <input type="file" class="form-control" @change="onLogoWideChange" />
                    <div v-if="form.errors.site_logo_wide" class="text-danger text-sm mt-1">
                      {{ form.errors.site_logo_wide }}
                    </div>
                  </div>
                </div>
               <div class="row justify-between align-content-center">
                 <div class="col-6" v-if="logoPreview">
                  <div class="logo-preview">
                    <img :src="logoPreview" alt="Site logo preview" />
                  </div>
                </div>
                <div class="col-6" v-if="logoWidePreview">
                  <div class="logo-wide-preview">
                    <img :src="logoWidePreview" alt="Brand logo preview" />
                  </div>
                </div>
               </div>
              </div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Localization</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="select-style-1">
                    <label>Default Currency</label>
                    <div class="select-position">
                      <select v-model="form.default_currency" class="form-control">
                        <option value="BDT">BDT</option>
                        <option value="USD">USD</option>
                      </select>
                    </div>
                    <div v-if="form.errors.default_currency" class="text-danger text-sm mt-1">
                      {{ form.errors.default_currency }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>USD to BDT Rate</label>
                    <input v-model.number="form.exchange_rate_usd_to_bdt" type="number" min="0" step="0.01" class="form-control" />
                    <div v-if="form.errors.exchange_rate_usd_to_bdt" class="text-danger text-sm mt-1">
                      {{ form.errors.exchange_rate_usd_to_bdt }}
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="select-style-1">
                    <label>Timezone</label>
                    <div class="select-position">
                      <select v-model="form.timezone" class="form-control">
                        <option v-for="zone in timezones" :key="zone" :value="zone">{{ zone }}</option>
                      </select>
                    </div>
                    <div v-if="form.errors.timezone" class="text-danger text-sm mt-1">{{ form.errors.timezone }}</div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="d-block mb-2">Languages</label>
                  <div class="form-check">
                    <input id="lang-en" v-model="form.languages" class="form-check-input" type="checkbox" value="en" />
                    <label class="form-check-label" for="lang-en">English</label>
                  </div>
                  <div class="form-check">
                    <input id="lang-bn" v-model="form.languages" class="form-check-input" type="checkbox" value="bn" />
                    <label class="form-check-label" for="lang-bn">Bangla</label>
                  </div>
                  <div v-if="form.errors.languages" class="text-danger text-sm mt-1">{{ form.errors.languages }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Save Settings</h6>
              <p class="text-sm text-muted">Apply site-wide configuration changes.</p>
              <button type="submit" class="main-btn primary-btn btn-hover mt-3" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save Settings' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  settings: { type: Object, default: () => ({}) },
  timezones: { type: Array, default: () => [] },
})

const form = useForm({
  site_name: props.settings.site_name || '',
  default_currency: props.settings.default_currency || 'BDT',
  exchange_rate_usd_to_bdt: Number(props.settings.exchange_rate_usd_to_bdt || 110),
  timezone: props.settings.timezone || 'Asia/Dhaka',
  languages: props.settings.languages || ['en'],
  site_logo: null,
  site_logo_wide: null,
})

const logoPreview = computed(() => {
  if (form.site_logo) {
    return URL.createObjectURL(form.site_logo)
  }
  if (props.settings.site_logo) {
    return `/storage/${props.settings.site_logo}`
  }
  return ''
})

const logoWidePreview = computed(() => {
  if (form.site_logo_wide) {
    return URL.createObjectURL(form.site_logo_wide)
  }
  if (props.settings.site_logo_wide) {
    return `/storage/${props.settings.site_logo_wide}`
  }
  return ''
})

function onLogoChange(event) {
  form.site_logo = event.target.files[0] || null
}

function onLogoWideChange(event) {
  form.site_logo_wide = event.target.files[0] || null
}

function submit() {
  form.post('/admin/settings', {
    forceFormData: true,
  })
}
</script>

<style scoped>
.logo-preview {
  margin-top: 12px;
  width: 140px;
  height: 140px;
  border: 1px dashed #e5e7eb;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f9fafb;
}

.logo-preview img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.logo-wide-preview {
  margin-top: 12px;
  width: 280px;
  height: 70px;
  border: 1px dashed #e5e7eb;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f9fafb;
}

.logo-wide-preview img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}
</style>
