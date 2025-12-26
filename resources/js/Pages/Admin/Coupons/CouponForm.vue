<template>
  <form @submit.prevent="submit">
    <div class="row">
      <div class="col-lg-8">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Coupon Details</h6>
            <div class="row">
              <div class="col-md-6">
                <div class="input-style-1">
                  <label>Code</label>
                  <input v-model="form.code" type="text" class="form-control" placeholder="SAVE20" />
                  <div v-if="form.errors.code" class="text-danger text-sm mt-1">{{ form.errors.code }}</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="select-style-1">
                  <label>Type</label>
                  <div class="select-position">
                    <select v-model="form.type" class="form-control">
                      <option value="percentage">Percentage</option>
                      <option value="fixed">Fixed</option>
                    </select>
                  </div>
                  <div v-if="form.errors.type" class="text-danger text-sm mt-1">{{ form.errors.type }}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-style-1">
                  <label>Value</label>
                  <input v-model.number="form.value" type="number" min="0" step="0.01" class="form-control" />
                  <div v-if="form.errors.value" class="text-danger text-sm mt-1">{{ form.errors.value }}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-style-1">
                  <label>Min Order Amount</label>
                  <input v-model.number="form.min_order_amount" type="number" min="0" step="0.01" class="form-control" />
                  <div v-if="form.errors.min_order_amount" class="text-danger text-sm mt-1">
                    {{ form.errors.min_order_amount }}
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-style-1">
                  <label>Max Discount Amount</label>
                  <input v-model.number="form.max_discount_amount" type="number" min="0" step="0.01" class="form-control" />
                  <div v-if="form.errors.max_discount_amount" class="text-danger text-sm mt-1">
                    {{ form.errors.max_discount_amount }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-style-1">
                  <label>Start Date</label>
                  <input v-model="form.start_at" type="date" class="form-control" />
                  <div v-if="form.errors.start_at" class="text-danger text-sm mt-1">{{ form.errors.start_at }}</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-style-1">
                  <label>End Date</label>
                  <input v-model="form.end_at" type="date" class="form-control" />
                  <div v-if="form.errors.end_at" class="text-danger text-sm mt-1">{{ form.errors.end_at }}</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-style-1">
                  <label>Total Usage Limit</label>
                  <input v-model.number="form.usage_limit_total" type="number" min="1" class="form-control" />
                  <div v-if="form.errors.usage_limit_total" class="text-danger text-sm mt-1">
                    {{ form.errors.usage_limit_total }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-style-1">
                  <label>Usage Limit Per User</label>
                  <input v-model.number="form.usage_limit_per_user" type="number" min="1" class="form-control" />
                  <div v-if="form.errors.usage_limit_per_user" class="text-danger text-sm mt-1">
                    {{ form.errors.usage_limit_per_user }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="select-style-1">
                  <label>Applicable Scope</label>
                  <div class="select-position">
                    <select v-model="form.applicable_scope" class="form-control">
                      <option value="all_products">All Products</option>
                      <option value="category">Category</option>
                      <option value="sub_category">Subcategory</option>
                      <option value="vendor">Vendor</option>
                      <option value="specific_products">Specific Products</option>
                    </select>
                  </div>
                  <div v-if="form.errors.applicable_scope" class="text-danger text-sm mt-1">
                    {{ form.errors.applicable_scope }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="select-style-1">
                  <label>Allowed Payment Types</label>
                  <div class="select-position">
                    <select v-model="form.allowed_payment_types" class="form-control">
                      <option value="both">Both</option>
                      <option value="online_only">Online Only</option>
                      <option value="cod_only">COD Only</option>
                    </select>
                  </div>
                  <div v-if="form.errors.allowed_payment_types" class="text-danger text-sm mt-1">
                    {{ form.errors.allowed_payment_types }}
                  </div>
                </div>
              </div>
              <div class="col-12" v-if="showApplicableList">
                <div class="card-style mt-3">
                  <div class="card-content">
                    <h6 class="text-medium mb-3">Select Applicable Items</h6>
                    <div class="applicable-grid">
                      <label v-for="item in applicableItems" :key="item.id" class="form-check">
                        <input
                          type="checkbox"
                          class="form-check-input"
                          :value="item.id"
                          v-model="form.applicable_ids"
                        />
                        <span class="form-check-label">{{ itemLabel(item) }}</span>
                      </label>
                    </div>
                    <div v-if="form.errors.applicable_ids" class="text-danger text-sm mt-2">
                      {{ form.errors.applicable_ids }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card-style mb-30">
          <div class="card-content">
            <h6 class="text-medium mb-3">Status</h6>
            <div class="select-style-1">
              <label>Status</label>
              <div class="select-position">
                <select v-model="form.status" class="form-control">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                </select>
              </div>
              <div v-if="form.errors.status" class="text-danger text-sm mt-1">{{ form.errors.status }}</div>
            </div>
            <div class="form-check mt-3">
              <input id="is_stackable" v-model="form.is_stackable" class="form-check-input" type="checkbox" />
              <label class="form-check-label" for="is_stackable">Stackable with other coupons</label>
            </div>
            <button type="submit" class="main-btn primary-btn btn-hover mt-4" :disabled="form.processing">
              {{ form.processing ? 'Saving...' : submitLabel }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  form: { type: Object, required: true },
  submitLabel: { type: String, required: true },
  categories: { type: Array, default: () => [] },
  subcategories: { type: Array, default: () => [] },
  vendors: { type: Array, default: () => [] },
  products: { type: Array, default: () => [] },
  submit: { type: Function, required: true },
})

const showApplicableList = computed(() => props.form.applicable_scope !== 'all_products')

const applicableItems = computed(() => {
  switch (props.form.applicable_scope) {
    case 'category':
      return props.categories
    case 'sub_category':
      return props.subcategories
    case 'vendor':
      return props.vendors
    case 'specific_products':
      return props.products
    default:
      return []
  }
})

function itemLabel(item) {
  if (!item) return '-'
  if (item.title) return `${item.title || item.name}`
  if (item.email) return `${item.name} (${item.email})`
  return item.name
}
</script>

<style scoped>
.applicable-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 8px;
  max-height: 220px;
  overflow-y: auto;
}
</style>
