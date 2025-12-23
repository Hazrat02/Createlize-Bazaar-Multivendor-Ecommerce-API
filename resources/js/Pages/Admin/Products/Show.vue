<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Product Overview</h2>
            <p class="text-sm text-muted">{{ product.name }}</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="text-end mb-30">
            <Link :href="`/admin/products/${product.id}/edit`" class="main-btn primary-btn btn-hover">
              Edit Product
            </Link>
            <Link href="/admin/products" class="main-btn primary-btn-outline btn-hover ms-2">Back</Link>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-5">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Images</h6>
            <div class="image-preview">
              <img v-if="activeImage" :src="imageUrl(activeImage.path)" :alt="product.name" />
              <div v-else class="image-placeholder">No images</div>
            </div>
            <div class="image-controls mt-3" v-if="product.images.length > 1">
              <button class="main-btn primary-btn-outline btn-hover btn-sm" type="button" @click="prevImage">
                Prev
              </button>
              <button class="main-btn primary-btn-outline btn-hover btn-sm ms-2" type="button" @click="nextImage">
                Next
              </button>
            </div>
            <div class="image-thumbs mt-3" v-if="product.images.length">
              <button
                v-for="(img, idx) in product.images"
                :key="img.id"
                type="button"
                class="thumb"
                :class="{ active: idx === activeIndex }"
                @click="activeIndex = idx"
              >
                <img :src="imageUrl(img.path)" :alt="`Image ${idx + 1}`" />
              </button>
            </div>
            <div class="mt-3" v-if="product.images.length">
              <button
                type="button"
                class="main-btn danger-btn-outline btn-hover btn-sm"
                @click="removeImage(activeImage)"
              >
                Remove Selected Image
              </button>
            </div>
          </div>
        </div>

        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Add Images</h6>
            <form @submit.prevent="uploadImages">
              <div class="input-style-1">
                <label>Upload Images</label>
                <input type="file" class="form-control" multiple @change="onImageChange" />
                <div v-if="imageForm.errors.images" class="text-danger text-sm mt-1">
                  {{ imageForm.errors.images }}
                </div>
              </div>
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="imageForm.processing">
                {{ imageForm.processing ? 'Uploading...' : 'Upload' }}
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Product Details</h6>
            <div class="detail-grid">
              <div>
                <span class="text-sm text-muted">Name</span>
                <div class="fw-semibold">{{ product.name }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Title</span>
                <div class="fw-semibold">{{ product.title || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Slug</span>
                <div class="fw-semibold">{{ product.slug }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Vendor</span>
                <div class="fw-semibold">{{ product.vendor?.name || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Category</span>
                <div class="fw-semibold">{{ product.category?.name || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Subcategory</span>
                <div class="fw-semibold">{{ product.sub_category?.name || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Delivery Type</span>
                <div class="fw-semibold">{{ product.delivery_type?.name || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Currency</span>
                <div class="fw-semibold">{{ product.currency }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Price</span>
                <div class="fw-semibold">{{ formatAmount(product.price) }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Discount</span>
                <div class="fw-semibold">{{ product.discount_percent || 0 }}%</div>
              </div>
              <div>
                <span class="text-sm text-muted">Stock</span>
                <div class="fw-semibold">{{ product.stock ?? '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">SKU</span>
                <div class="fw-semibold">{{ product.sku || '-' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Status</span>
                <div class="fw-semibold">{{ product.is_active ? 'Active' : 'Inactive' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Featured</span>
                <div class="fw-semibold">{{ product.is_featured ? 'Yes' : 'No' }}</div>
              </div>
              <div>
                <span class="text-sm text-muted">Tags</span>
                <div class="fw-semibold">{{ tagsLabel }}</div>
              </div>
            </div>
            <div class="mt-4">
              <span class="text-sm text-muted">Description</span>
              <div class="text-muted mt-1">{{ product.description || '-' }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Link, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

const props = defineProps({
  product: { type: Object, required: true },
})

const activeIndex = ref(0)
const imageForm = useForm({
  images: [],
})

const activeImage = computed(() => props.product.images?.[activeIndex.value] || null)

const tagsLabel = computed(() => {
  if (!props.product.tags || props.product.tags.length === 0) return '-'
  return props.product.tags.join(', ')
})

function onImageChange(event) {
  imageForm.images = Array.from(event.target.files || [])
}

function uploadImages() {
  if (!imageForm.images.length) return
  imageForm.post(`/admin/products/${props.product.id}/images`, {
    forceFormData: true,
    onSuccess: () => {
      imageForm.reset()
    },
  })
}

function removeImage(image) {
  if (!image) return
  if (!confirm('Remove this image?')) return
  router.delete(`/admin/products/${props.product.id}/images/${image.id}`, {
    preserveScroll: true,
    onSuccess: () => {
      activeIndex.value = 0
    },
  })
}

function prevImage() {
  if (!props.product.images.length) return
  activeIndex.value = (activeIndex.value - 1 + props.product.images.length) % props.product.images.length
}

function nextImage() {
  if (!props.product.images.length) return
  activeIndex.value = (activeIndex.value + 1) % props.product.images.length
}

function imageUrl(path) {
  if (!path) return ''
  if (path.startsWith('http')) return path
  return `/storage/${path}`
}

function formatAmount(value) {
  if (value === null || value === undefined) return '-'
  return Number(value).toFixed(2)
}
</script>

<style scoped>
.image-preview {
  width: 100%;
  height: 240px;
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background: #f9fafb;
}

.image-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.image-placeholder {
  color: #9ca3af;
  font-size: 13px;
}

.image-thumbs {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(64px, 1fr));
  gap: 8px;
}

.thumb {
  border: 1px solid transparent;
  border-radius: 8px;
  overflow: hidden;
  padding: 0;
  background: transparent;
}

.thumb img {
  width: 100%;
  height: 56px;
  object-fit: cover;
}

.thumb.active {
  border-color: #4f46e5;
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 14px;
}
</style>
