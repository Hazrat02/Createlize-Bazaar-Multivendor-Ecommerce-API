<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Edit Product</h2>
            <p class="text-sm text-muted">{{ product.name }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link :href="`/admin/products/${product.id}`" class="main-btn primary-btn-outline btn-hover">
              Overview
            </Link>
            <Link href="/admin/products" class="main-btn primary-btn-outline btn-hover ms-2">Back</Link>
          </div>
        </div>
      </div>
    </div>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-8">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Basic Information</h6>
              <div class="row">
                <div class="col-md-6">
                <div class="input-style-1">
                  <label>Name</label>
                  <input v-model="form.name" type="text" class="form-control" @input="clearError('name')" />
                  <div v-if="showErrors && form.errors.name" class="text-danger text-sm mt-1">{{ form.errors.name }}</div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-style-1">
                  <label>Title</label>
                  <input v-model="form.title" type="text" class="form-control" @input="clearError('title')" />
                  <div v-if="showErrors && form.errors.title" class="text-danger text-sm mt-1">{{ form.errors.title }}</div>
                </div>
                </div>
                <div class="col-12">
                <div class="input-style-1">
                  <label>Description</label>
                  <textarea
                    v-model="form.description"
                    class="form-control"
                    rows="4"
                    @input="clearError('description')"
                  ></textarea>
                  <div v-if="showErrors && form.errors.description" class="text-danger text-sm mt-1">
                    {{ form.errors.description }}
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Pricing</h6>
              <div class="row">
                <div class="col-md-4">
                <div class="input-style-1">
                  <label>Price</label>
                  <input v-model.number="form.price" type="number" min="0" step="0.01" class="form-control" />
                    <div v-if="showErrors && form.errors.price" class="text-danger text-sm mt-1">
                      {{ form.errors.price }}
                    </div>
                </div>
                </div>
                <div class="col-md-4">
                  <div class="select-style-1">
                    <label>Currency</label>
                    <div class="select-position">
                  <select v-model="form.currency" class="form-control" @change="clearError('currency')">
                    <option value="BDT">BDT</option>
                    <option value="USD">USD</option>
                  </select>
                    </div>
                    <div v-if="showErrors && form.errors.currency" class="text-danger text-sm mt-1">
                      {{ form.errors.currency }}
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                <div class="input-style-1">
                  <label>Discount (%)</label>
                  <input v-model.number="form.discount_percent" type="number" min="0" max="100" class="form-control" />
                    <div v-if="showErrors && form.errors.discount_percent" class="text-danger text-sm mt-1">
                      {{ form.errors.discount_percent }}
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-style-1">
                  <label>Stock</label>
                  <input v-model.number="form.stock" type="number" min="0" class="form-control" />
                    <div v-if="showErrors && form.errors.stock" class="text-danger text-sm mt-1">
                      {{ form.errors.stock }}
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                <div class="input-style-1">
                  <label>SKU</label>
                  <input v-model="form.sku" type="text" class="form-control" @input="clearError('sku')" />
                    <div v-if="showErrors && form.errors.sku" class="text-danger text-sm mt-1">{{ form.errors.sku }}</div>
                </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Existing Images</h6>
              <div v-if="product.images.length" class="existing-images">
                <div v-for="image in product.images" :key="image.id" class="existing-image">
                  <img :src="imageUrl(image.path)" :alt="product.name" />
                  <button type="button" class="btn btn-sm btn-outline-danger" @click="removeImage(image)">
                    Remove
                  </button>
                </div>
              </div>
              <div v-else class="text-sm text-muted">No images uploaded.</div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Add More Images</h6>
              <div class="input-style-1">
                <label>Upload Images</label>
                <input type="file" class="form-control" multiple @change="onImageChange" />
                <div v-if="showErrors && form.errors.images" class="text-danger text-sm mt-1">{{ form.errors.images }}</div>
              </div>
              <div v-if="selectedImageNames.length" class="text-sm text-muted">
                Selected: {{ selectedImageNames.join(', ') }}
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Classification</h6>
              <div class="select-style-1">
                <label>Vendor</label>
                <div class="select-position">
                  <select v-model.number="form.vendor_id" class="form-control" @change="clearError('vendor_id')">
                    <option value="">Select vendor</option>
                    <option v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">
                      {{ vendor.name }} ({{ vendor.email }})
                    </option>
                  </select>
                </div>
                <div v-if="showErrors && form.errors.vendor_id" class="text-danger text-sm mt-1">
                  {{ form.errors.vendor_id }}
                </div>
              </div>
              <div class="select-style-1">
                <label>Category</label>
                <div class="select-position">
                  <select v-model.number="form.category_id" class="form-control" @change="clearError('category_id')">
                    <option value="">Select category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                </div>
                <div v-if="showErrors && form.errors.category_id" class="text-danger text-sm mt-1">
                  {{ form.errors.category_id }}
                </div>
              </div>
              <div class="select-style-1">
                <label>Subcategory</label>
                <div class="select-position">
                  <select v-model.number="form.sub_category_id" class="form-control" @change="clearError('sub_category_id')">
                    <option value="">Select subcategory</option>
                    <option v-for="subcategory in filteredSubcategories" :key="subcategory.id" :value="subcategory.id">
                      {{ subcategory.name }}
                    </option>
                  </select>
                </div>
                <div v-if="showErrors && form.errors.sub_category_id" class="text-danger text-sm mt-1">
                  {{ form.errors.sub_category_id }}
                </div>
              </div>
              <div class="select-style-1">
                <label>Delivery Type</label>
                <div class="select-position">
                  <select v-model.number="form.delivery_type_id" class="form-control" @change="clearError('delivery_type_id')">
                    <option value="">Select delivery</option>
                    <option v-for="delivery in deliveryTypes" :key="delivery.id" :value="delivery.id">
                      {{ delivery.name }}
                    </option>
                  </select>
                </div>
                <div v-if="showErrors && form.errors.delivery_type_id" class="text-danger text-sm mt-1">
                  {{ form.errors.delivery_type_id }}
                </div>
              </div>
                <div class="input-style-1">
                  <label>Tags</label>
                  <input v-model="form.tags" type="text" class="form-control" @input="clearError('tags')" />
                <div v-if="showErrors && form.errors.tags" class="text-danger text-sm mt-1">{{ form.errors.tags }}</div>
                </div>
              <div class="form-check mt-3">
                <input id="is_active" v-model="form.is_active" class="form-check-input" type="checkbox" />
                <label class="form-check-label" for="is_active">Active</label>
              </div>
              <div class="form-check mt-2">
                <input id="is_featured" v-model="form.is_featured" class="form-check-input" type="checkbox" />
                <label class="form-check-label" for="is_featured">Featured</label>
              </div>
              <button type="submit" class="main-btn primary-btn btn-hover mt-4" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Update Product' }}
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
import { Link, router, useForm } from '@inertiajs/vue3'
import { computed, onMounted, ref } from 'vue'

const props = defineProps({
  product: { type: Object, required: true },
  vendors: { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
  subcategories: { type: Array, default: () => [] },
  deliveryTypes: { type: Array, default: () => [] },
})

const form = useForm({
  vendor_id: props.product.vendor_id || '',
  category_id: props.product.category_id || '',
  sub_category_id: props.product.sub_category_id || '',
  delivery_type_id: props.product.delivery_type_id || '',
  name: props.product.name || '',
  title: props.product.title || '',
  description: props.product.description || '',
  price: props.product.price || 0,
  currency: props.product.currency || 'BDT',
  discount_percent: props.product.discount_percent || 0,
  stock: props.product.stock,
  sku: props.product.sku || '',
  tags: (props.product.tags || []).join(', '),
  is_active: !!props.product.is_active,
  is_featured: !!props.product.is_featured,
  images: [],
  _method: 'put',
})

const selectedImageNames = ref([])
const hasSubmitted = ref(false)
const showErrors = computed(() => hasSubmitted.value)

const filteredSubcategories = computed(() => {
  if (!form.category_id) return props.subcategories
  return props.subcategories.filter((sub) => sub.category_id === Number(form.category_id))
})

function onImageChange(event) {
  const files = Array.from(event.target.files || [])
  form.images = files
  selectedImageNames.value = files.map((file) => file.name)
}

function submit() {
  hasSubmitted.value = true
  form.post(`/admin/products/${props.product.id}`, {
    forceFormData: true,
  })
}

function clearError(field) {
  form.clearErrors(field)
}

function removeImage(image) {
  if (!confirm('Remove this image?')) return
  router.delete(`/admin/products/${props.product.id}/images/${image.id}`, {
    preserveScroll: true,
  })
}

function imageUrl(path) {
  if (!path) return ''
  if (path.startsWith('http')) return path
  return `/storage/${path}`
}

onMounted(() => {
  form.clearErrors()
  hasSubmitted.value = false
})
</script>

<style scoped>
.existing-images {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 12px;
}

.existing-image {
  border: 1px solid #e5e7eb;
  border-radius: 10px;
  overflow: hidden;
  padding: 8px;
  text-align: center;
  background: #fff;
}

.existing-image img {
  width: 100%;
  height: 120px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 8px;
}
</style>
