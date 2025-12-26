<template>
  <div class="store-wrapper">
    <div class="store">
      <div class="store-header">
        <figure class="store-banner">
          <img :src="vendor.banner" alt="Vendor" width="447" height="291" style="background-color: #8d9eaa;" />
        </figure>
      </div>
      <div class="store-content">
        <h2 class="store-title">
          <NuxtLink to="/store-listing">{{ vendor.name }}</NuxtLink>
          <span v-if="vendor.featured" class="featured-label">Featured</span>
        </h2>
        <div class="ratings-container">
          <span class="ratings-full" title="Rated 4.65 out of 5">
            <span class="ratings" :style="{ width: vendor.ratingPercent + '%' }"></span>
          </span>
        </div>
        <p>
          {{ vendor.location }}
        </p>
        <div class="store-phone">
          <i class="fa fa-phone"></i>{{ vendor.phone }}
        </div>
      </div>
      <div class="store-footer">
        <figure class="seller-avatar">
          <img :src="vendor.avatar" alt="Vendor avatar" width="64" height="64" />
        </figure>
        <NuxtLink to="/store-listing" class="btn btn-dark btn-link btn-underline">Visit Store<i
          class="d-icon-arrow-right"></i></NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  vendor: {
    type: Object,
    required: true
  }
})
</script>

