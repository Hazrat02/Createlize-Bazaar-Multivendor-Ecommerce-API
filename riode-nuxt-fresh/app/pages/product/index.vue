<template>
  <div></div>
</template>

<script setup>
const { products, pending } = useProducts()
const hasNavigated = ref(false)

watchEffect(async () => {
  if (hasNavigated.value || pending.value) {
    return
  }
  const firstSlug = products.value[0]?.slug
  if (firstSlug) {
    hasNavigated.value = true
    await navigateTo(`/product/${firstSlug}`, { replace: true })
  }
})
definePageMeta({
  layout: 'riode'
})
</script>
