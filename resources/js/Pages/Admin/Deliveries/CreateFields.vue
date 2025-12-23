<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>{{ t('create_required_field') }}</h2>
            <p class="text-sm text-muted">{{ deliveryType.name }} ({{ deliveryType.key }})</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link :href="`/admin/deliveries/${deliveryType.id}/fields`" class="main-btn primary-btn-outline btn-hover">
              {{ t('back') }}
            </Link>
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
                <label>{{ t('field_title') }} <span class="text-danger">*</span></label>
                <input v-model="form.title" type="text" class="form-control" placeholder="e.g. Phone number" />
                <div v-if="form.errors.title" class="text-danger text-sm mt-1">{{ form.errors.title }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('field_key') }} <span class="text-danger">*</span></label>
                <input v-model="form.name" type="text" class="form-control" placeholder="phone" />
                <div v-if="form.errors.name" class="text-danger text-sm mt-1">{{ form.errors.name }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="select-style-1">
                <label>{{ t('field_type') }} <span class="text-danger">*</span></label>
                <div class="select-position">
                  <select v-model="form.type" class="form-control">
                    <option value="text">Text</option>
                    <option value="email">Email</option>
                    <option value="phone">Phone</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select</option>
                    <option value="file">File</option>
                  </select>
                </div>
                <div v-if="form.errors.type" class="text-danger text-sm mt-1">{{ form.errors.type }}</div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('sort_order') }}</label>
                <input v-model.number="form.sort_order" type="number" min="0" class="form-control" />
                <div v-if="form.errors.sort_order" class="text-danger text-sm mt-1">{{ form.errors.sort_order }}</div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check form-switch mt-2">
                <input id="field-required" class="form-check-input" type="checkbox" v-model="form.required" />
                <label class="form-check-label" for="field-required">{{ t('required') }}</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('placeholder') }}</label>
                <input v-model="form.placeholder" type="text" class="form-control" placeholder="Optional hint" />
                <div v-if="form.errors.placeholder" class="text-danger text-sm mt-1">{{ form.errors.placeholder }}</div>
              </div>
            </div>
            <div v-if="showOptions" class="col-md-6">
              <div class="input-style-1">
                <label>{{ t('options') }}</label>
                <textarea
                  v-model="optionsText"
                  class="form-control"
                  rows="3"
                  placeholder="Option A, Option B or one per line"
                ></textarea>
                <small class="text-muted">Separate options with commas or new lines.</small>
                <div v-if="form.errors.options" class="text-danger text-sm mt-1">{{ form.errors.options }}</div>
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
import { computed, ref, watch } from 'vue'

const props = defineProps({
  deliveryType: { type: Object, required: true },
})

const page = usePage()
const messages = computed(() => page.props.i18n?.admin || {})

function t(key) {
  return messages.value[key] || key
}

const form = useForm({
  delivery_type_id: props.deliveryType.id,
  title: '',
  name: '',
  type: 'text',
  required: false,
  placeholder: '',
  options: [],
  sort_order: 0,
})

const optionsText = ref('')
const showOptions = computed(() => form.type === 'select')

watch(
  () => form.type,
  (value) => {
    if (value !== 'select') {
      optionsText.value = ''
      form.options = []
    }
  }
)

function submit() {
  const normalizedOptions = showOptions.value
    ? optionsText.value
        .split(/\r?\n|,/)
        .map((option) => option.trim())
        .filter(Boolean)
    : []

  form.options = normalizedOptions

  form.post('/admin/deliveries/fields', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('title', 'name', 'type', 'required', 'placeholder', 'sort_order')
      form.options = []
      optionsText.value = ''
    },
  })
}
</script>
