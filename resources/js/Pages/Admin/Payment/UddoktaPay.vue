<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>Payment Manage (UddoktaPay)</h2>
          </div>
        </div>
        <div class="col-md-6">
          <div class="title d-flex justify-content-md-end">
            
          </div>
        </div>
      </div>
    </div>

    <div class="card-style mb-30">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th><h6>ID</h6></th>
              <th><h6>Name</h6></th>
              <th><h6>Status</h6></th>
              <th><h6>Action</h6></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in rows" :key="row.id">
              <td>{ row.id }</td>
              <td>{ row.name }</td>
              <td>
                <span class="status-btn" :class="row.status ? 'active-btn' : 'close-btn'">
                  { row.status ? 'Active' : 'Inactive' }
                </span>
              </td>
              <td>
                <div class="action">
                  <a :href="row.edit_url" class="text-primary">Edit</a>
                </div>
              </td>
            </tr>
            <tr v-if="rows.length === 0">
              <td colspan="4" class="text-center text-sm text-muted">No data</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const rows = computed(() => page.props.rows || [])
</script>
