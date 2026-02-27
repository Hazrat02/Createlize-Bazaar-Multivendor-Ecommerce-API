<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('create_banner') }}</h2>
            <p class="text-sm text-muted">{{ t('add_banner') }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link href="/admin/banners" class="main-btn primary-btn-outline btn-hover">{{ t('back') }}</Link>
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
                <label>{{ t('text_align') }}</label>
                <select v-model="form.text_align" class="form-control">
                  <option value="left">{{ t('left') }}</option>
                  <option value="center">{{ t('center') }}</option>
                  <option value="right">{{ t('right') }}</option>
                </select>
                <div v-if="form.errors.text_align" class="text-danger text-sm mt-1">{{ form.errors.text_align }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('order') }}</label>
                <input v-model.number="form.sort_order" type="number" class="form-control" min="0" />
                <div v-if="form.errors.sort_order" class="text-danger text-sm mt-1">{{ form.errors.sort_order }}</div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('title') }}</label>
                <input v-model="form.title" type="text" class="form-control" />
                <div v-if="form.errors.title" class="text-danger text-sm mt-1">{{ form.errors.title }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('subtitle') }}</label>
                <input v-model="form.subtitle" type="text" class="form-control" />
                <div v-if="form.errors.subtitle" class="text-danger text-sm mt-1">{{ form.errors.subtitle }}</div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('cta_text') }}</label>
                <input v-model="form.cta_text" type="text" class="form-control" />
                <div v-if="form.errors.cta_text" class="text-danger text-sm mt-1">{{ form.errors.cta_text }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('cta_link') }}</label>
                <input v-model="form.cta_link" type="text" class="form-control" />
                <div v-if="form.errors.cta_link" class="text-danger text-sm mt-1">{{ form.errors.cta_link }}</div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('category') }}</label>
                <select v-model="form.category_id" class="form-control">
                  <option :value="null">{{ t('none') }}</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
                <div v-if="form.errors.category_id" class="text-danger text-sm mt-1">{{ form.errors.category_id }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('subcategory') }}</label>
                <select v-model="form.sub_category_id" class="form-control">
                  <option :value="null">{{ t('none') }}</option>
                  <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                    {{ subcategory.name }}
                  </option>
                </select>
                <div v-if="form.errors.sub_category_id" class="text-danger text-sm mt-1">{{ form.errors.sub_category_id }}</div>
              </div>
            </div>
            <div class="col-12">
              <p class="text-sm text-muted">
                {{ t('category_banner_hint') }}
              </p>
            </div>

            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('start_date') }}</label>
                <input v-model="form.starts_at" type="datetime-local" class="form-control" />
                <div v-if="form.errors.starts_at" class="text-danger text-sm mt-1">{{ form.errors.starts_at }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('end_date') }}</label>
                <input v-model="form.ends_at" type="datetime-local" class="form-control" />
                <div v-if="form.errors.ends_at" class="text-danger text-sm mt-1">{{ form.errors.ends_at }}</div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('banner_image') }} <span class="text-danger">*</span></label>
                <input type="file" class="form-control" accept="image/*" @change="onImageChange" />
                <div v-if="form.errors.image" class="text-danger text-sm mt-1">{{ form.errors.image }}</div>
              </div>
            </div>
            <div class="col-md-6 d-flex align-items-center">
              <div class="form-check form-switch mt-4">
                <input class="form-check-input" type="checkbox" id="banner-active" v-model="form.is_active" />
                <label class="form-check-label" for="banner-active">{{ t('active') }}</label>
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

const props = defineProps({
  categories: { type: Array, default: () => [] },
  subcategories: { type: Array, default: () => [] },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  title: '',
  subtitle: '',
  cta_text: '',
  cta_link: '',
  text_align: 'left',
  sort_order: 0,
  is_active: true,
  starts_at: '',
  ends_at: '',
  category_id: null,
  sub_category_id: null,
  image: null,
})

function onImageChange(event) {
  form.image = event.target.files[0] || null
}

function submit() {
  form.post('/admin/banners', { forceFormData: true })
}
</script>
