<template>
  <tr>
    <td class="product-thumbnail">
      <NuxtLink :to="item.href || '#'">
        <figure>
          <img :src="item.image" width="100" height="100" :alt="item.name" />
        </figure>
      </NuxtLink>
    </td>
    <td class="product-name">
      <NuxtLink :to="item.href || '#'">{{ item.name }}</NuxtLink>
    </td>
    <td class="product-price">
      <span class="amount">{{ formatPrice(item.price) }}</span>
    </td>
    <td class="product-stock-status">
      <span :class="item.stock === 'In Stock' ? 'wishlist-in-stock' : 'wishlist-out-stock'">{{ item.stock }}</span>
    </td>
    <td class="product-add-to-cart">
      <NuxtLink :to="item.href || '#'" class="btn-product btn-primary"><span>Select Options</span></NuxtLink>
    </td>
    <td class="product-remove">
      <a href="#" class="remove" title="Remove this product"><i class="fas fa-times"></i></a>
    </td>
  </tr>
</template>

<script setup>
const props = defineProps({
  item: {
    type: Object,
    required: true
  }
})

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}
</script>
