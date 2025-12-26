<template>
  <tr>
    <td class="product-thumbnail">
      <figure>
        <NuxtLink :to="item.href || `/product/${item.slug}`">
          <img :src="item.image" width="100" height="100" :alt="item.name" />
        </NuxtLink>
      </figure>
    </td>
    <td class="product-name">
      <div class="product-name-section">
        <NuxtLink :to="item.href || `/product/${item.slug}`">{{ item.name }}</NuxtLink>
      </div>
    </td>
    <td class="product-subtotal">
      <span class="amount">{{ formatPrice(item.price) }}</span>
    </td>
    <td class="product-quantity">
      <div class="input-group">
        <button class="quantity-minus d-icon-minus" type="button" @click="changeQty(-1)"></button>
        <input
          class="quantity form-control"
          type="number"
          min="1"
          max="1000000"
          :value="item.qty"
          @input="onQtyInput"
        />
        <button class="quantity-plus d-icon-plus" type="button" @click="changeQty(1)"></button>
      </div>
    </td>
    <td class="product-price">
      <span class="amount">{{ formatPrice(item.price * item.qty) }}</span>
    </td>
    <td class="product-close">
      <a href="#" class="product-remove" title="Remove this product" @click.prevent="removeItem">
        <i class="fas fa-times"></i>
      </a>
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

const emit = defineEmits(['update-qty', 'remove'])

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}

const changeQty = (delta) => {
  const next = Math.max(1, Number(props.item.qty || 1) + delta)
  emit('update-qty', { id: props.item.id, qty: next })
}

const onQtyInput = (event) => {
  const raw = Number(event.target.value)
  const next = Number.isFinite(raw) && raw > 0 ? Math.floor(raw) : 1
  emit('update-qty', { id: props.item.id, qty: next })
}

const removeItem = () => {
  emit('remove', props.item.id)
}
</script>
