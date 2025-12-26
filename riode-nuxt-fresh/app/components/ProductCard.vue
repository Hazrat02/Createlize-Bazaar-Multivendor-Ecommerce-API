<template>
  <div class="product">
    <figure class="product-media">
      <NuxtLink :to="product.href || '#'" class="product-link">
        <img :src="product.image" :alt="product.name" width="280" height="315" />
      </NuxtLink>
      <div v-if="product.labels && product.labels.length" class="product-label-group">
        <label v-for="label in product.labels" :key="label.text" :class="label.class">{{ label.text }}</label>
      </div>
      <div class="product-action-vertical">
        <a
          href="#"
          class="btn-product-icon btn-cart"
          data-toggle="modal"
          data-target="#addCartModal"
          title="Add to cart"
          @click.prevent="handleAddToCart"
        ><i class="d-icon-bag"></i></a>
        <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i class="d-icon-heart"></i></a>
      </div>
      <div class="product-action">
        <a href="#" class="btn-product btn-quickview" title="Quick View">Quick View</a>
      </div>
    </figure>
    <div class="product-details">
      <div class="product-cat">
        <NuxtLink to="/shop">{{ product.category }}</NuxtLink>
      </div>
      <h3 class="product-name">
        <NuxtLink :to="product.href || '#'">{{ product.name }}</NuxtLink>
      </h3>
      <div class="product-price">
        <template v-if="product.oldPrice">
          <ins class="new-price">{{ formatPrice(product.price) }}</ins>
          <del class="old-price">{{ formatPrice(product.oldPrice) }}</del>
        </template>
        <template v-else>
          <span class="price">{{ formatPrice(product.price) }}</span>
        </template>
      </div>
      <div class="ratings-container">
        <div class="ratings-full">
          <span class="ratings" :style="{ width: product.ratingPercent + '%' }"></span>
          <span class="tooltiptext tooltip-top"></span>
        </div>
        <NuxtLink :to="product.href || '#'" class="rating-reviews">( {{ product.reviewCount }} reviews )</NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  product: {
    type: Object,
    required: true
  }
})

const { addToCart } = useCart()

const handleAddToCart = () => {
  addToCart({
    id: props.product.id,
    slug: props.product.slug,
    name: props.product.name,
    price: props.product.price,
    image: props.product.image
  })
}

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}
</script>

