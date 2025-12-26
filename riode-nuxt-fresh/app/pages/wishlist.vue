<template>
  <main class="main">
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><a href="#"><i class="d-icon-home"></i></a></li>
                        <li>Wishlist</li>
                    </ul>
                </div>
            </nav>
            <div class="page-content pt-10 pb-10 mb-2">
                <div class="container">
                    <table class="shop-table wishlist-table mt-2 mb-4">
                        <thead>
                            <tr>
                                <th class="product-name"><span>Product</span></th>
                                <th></th>
                                <th class="product-price"><span>Price</span></th>
                                <th class="product-stock-status"><span>Stock status</span></th>
                                <th class="product-add-to-cart"></th>
                                <th class="product-remove"></th>
                            </tr>
                        </thead>
                        <tbody class="wishlist-items-wrapper">
      <WishlistRow v-for="item in wishlistItems" :key="item.id" :item="item" />
    </tbody>
                    </table>
                    <div class="social-links share-on">
                        <h5 class="text-uppercase font-weight-bold mb-0 mr-4 ls-s">Share on:</h5>
                        <a href="#" class="social-link social-icon social-facebook" title="Facebook"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link social-icon social-twitter" title="Twitter"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link social-icon social-pinterest" title="Pinterest"><i
                                class="fab fa-pinterest-p"></i></a>
                        <a href="#" class="social-link social-icon social-email" title="Email"><i
                                class="far fa-envelope"></i></a>
                        <a href="#" class="social-link social-icon social-whatsapp" title="Whatsapp"><i
                                class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

        </main>
</template>

<script setup>
import wishlistData from '~/data/wishlist.json'
import WishlistRow from '~/components/WishlistRow.vue'
const wishlistItems = wishlistData.items

</script>



