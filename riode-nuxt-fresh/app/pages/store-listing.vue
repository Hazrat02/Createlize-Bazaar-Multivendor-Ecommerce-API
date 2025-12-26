<template>
  <main class="main">
            <div class="page-content mb-10 pb-10">
                <div class="container">
                    <nav class="breadcrumb-nav">
                        <ul class="breadcrumb">
                            <li><NuxtLink to="/"><i class="d-icon-home"></i></NuxtLink></li>
                            <li>Store List</li>
                        </ul>
                    </nav>
                    <div class="toolbox">
                        <div class="toolbox-left mb-4 mb-md-0">
                            <a href="#" class="toolbox-item btn btn-outline btn-dark 
                                btn-rounded btn-icon-left form-toggle-btn"><i class="d-icon-filter-2"></i>Filter</a>
                            <p class="store-count">Total store showing: {{ vendors.length }}</p>
                        </div>
                        <div class="toolbox-right">
                            <div class="toolbox-item toolbox-sort select-box text-dark">
                                <label class="d-block">Sort By:</label>
                                <select name="orderby" class="form-control">
                                    <option value="default" selected="selected">Most Recent</option>
                                    <option value="popularity">Most Popular</option>
                                </select>
                            </div>
                            <div class="toolbox-item toolbox-layout">
                                <NuxtLink to="/store-listing" class="d-icon-mode-grid btn-layout active"></NuxtLink>
                                <a href="#" class="d-icon-mode-list btn-layout"></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-wrapper">
                        <form action="#" class="input-wrapper-inline">
                            <input type="email" class="form-control" name="vendor" id="vendor"
                                placeholder="Search Vendors" required="">
                            <button class="btn btn-dark btn-rounded" type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="row cols-lg-3 cols-sm-2 cols-1 mt-4">
  <VendorCard v-for="vendor in vendors" :key="vendor.id" :vendor="vendor" />
</div>
                </div>
            </div>

        </main>
</template>

<script setup>
import vendorsData from '~/data/vendors.json'
import VendorCard from '~/components/VendorCard.vue'
const vendors = vendorsData.items
useHead({
  bodyAttrs: { class: 'store-listing market' }
})
definePageMeta({
  layout: 'riode'
})
</script>



