<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>SEO Settings</h2>
            <p class="text-sm text-muted">Manage site-wide SEO metadata.</p>
          </div>
        </div>
      </div>
    </div>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-8">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Meta Tags</h6>
              <div class="row">
                <div class="col-12">
                  <div class="input-style-1">
                    <label>Meta Title</label>
                    <input v-model="form.meta_title" type="text" class="form-control" />
                    <div v-if="form.errors.meta_title" class="text-danger text-sm mt-1">
                      {{ form.errors.meta_title }}
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="input-style-1">
                    <label>Meta Description</label>
                    <textarea v-model="form.meta_description" class="form-control" rows="3"></textarea>
                    <div v-if="form.errors.meta_description" class="text-danger text-sm mt-1">
                      {{ form.errors.meta_description }}
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="input-style-1">
                    <label>Meta Keywords</label>
                    <input v-model="form.meta_keywords" type="text" class="form-control" placeholder="keyword1, keyword2" />
                    <div v-if="form.errors.meta_keywords" class="text-danger text-sm mt-1">
                      {{ form.errors.meta_keywords }}
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="input-style-1">
                    <label>Open Graph Image</label>
                    <input type="file" class="form-control" @change="onOgChange" />
                    <div v-if="form.errors.og_image" class="text-danger text-sm mt-1">
                      {{ form.errors.og_image }}
                    </div>
                  </div>
                  <div v-if="ogPreview" class="og-preview">
                    <img :src="ogPreview" alt="OG preview" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Save</h6>
              <p class="text-sm text-muted">Apply SEO changes across the site.</p>
              <button type="submit" class="main-btn primary-btn btn-hover mt-3" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save SEO' }}
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
import { computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  seo: { type: Object, default: () => ({}) },
})

const form = useForm({
  meta_title: props.seo.meta_title || '',
  meta_description: props.seo.meta_description || '',
  meta_keywords: props.seo.meta_keywords || '',
  og_image: null,
})

const ogPreview = computed(() => {
  if (form.og_image) {
    return URL.createObjectURL(form.og_image)
  }
  if (props.seo.og_image) {
    return `/storage/${props.seo.og_image}`
  }
  return ''
})

function onOgChange(event) {
  form.og_image = event.target.files[0] || null
}

function submit() {
  form.post('/admin/seo', {
    forceFormData: true,
  })
}
</script>

<style scoped>
.og-preview {
  margin-top: 12px;
  width: 100%;
  max-width: 360px;
  height: 180px;
  border: 1px dashed #e5e7eb;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f9fafb;
}

.og-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
