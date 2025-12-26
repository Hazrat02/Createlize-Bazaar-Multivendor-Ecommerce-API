<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('edit_vendor') }}</h2>
            <p class="text-sm text-muted">{{ vendor.name }} ({{ vendor.email }})</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link :href="`/admin/vendors/${vendor.id}`" class="main-btn primary-btn-outline btn-hover">{{ t('back') }}</Link>
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
                <label>{{ t('store_name') }} <span class="text-danger">*</span></label>
                <input v-model="form.store_name" type="text" class="form-control" />
                <div v-if="form.errors.store_name" class="text-danger text-sm mt-1">{{ form.errors.store_name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('vendor_logo') }}</label>
                <input type="file" class="form-control" accept="image/*" @change="onLogoChange" />
                <div v-if="form.errors.logo" class="text-danger text-sm mt-1">{{ form.errors.logo }}</div>
                <div v-if="logoPreview" class="mt-2">
                  <img :src="logoPreview" alt="Vendor logo" style="max-width: 120px; height: auto;" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('phone') }}</label>
                <input v-model="form.phone" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('nid') }}</label>
                <input v-model="form.nid" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('balance') }}</label>
                <input v-model.number="form.balance" type="number" min="0" step="0.01" class="form-control" />
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>{{ t('address') }}</label>
                <input v-model="form.address" type="text" class="form-control" />
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>{{ t('payout_info') }}</label>
                <textarea v-model="form.payout_info" rows="3" class="form-control" placeholder='{"bank":"..."}'></textarea>
                <div v-if="form.errors.payout_info" class="text-danger text-sm mt-1">{{ form.errors.payout_info }}</div>
              </div>
            </div>
            <div class="col-12">
              <div class="input-style-1">
                <label>{{ t('documents') }}</label>
                <textarea v-model="form.documents" rows="3" class="form-control" placeholder="doc1, doc2"></textarea>
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
  vendor: { type: Object, required: true },
  vendorProfile: { type: Object, default: null },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  store_name: props.vendorProfile?.store_name || '',
  nid: props.vendorProfile?.nid || '',
  phone: props.vendorProfile?.phone || '',
  address: props.vendorProfile?.address || '',
  balance: props.vendorProfile?.balance ?? 0,
  payout_info: props.vendorProfile?.payout_info ? JSON.stringify(props.vendorProfile.payout_info) : '',
  documents: props.vendorProfile?.documents ? props.vendorProfile.documents.join(', ') : '',
  logo: null,
})

const logoPreview = computed(() => {
  if (form.logo) return URL.createObjectURL(form.logo)
  if (props.vendorProfile?.logo_path) return `/storage/${props.vendorProfile.logo_path}`
  return ''
})

function onLogoChange(event) {
  form.logo = event.target.files[0] || null
}

function submit() {
  if (!form.payout_info) {
    form.payout_info = null
  }
  form
    .transform((data) => ({ ...data, _method: 'put' }))
    .post(`/admin/vendors/${props.vendor.id}/profile`, { forceFormData: true })
}
</script>
