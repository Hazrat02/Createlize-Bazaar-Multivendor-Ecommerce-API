<template>
  <nav v-if="links && links.length > 3" aria-label="Pagination" class="mt-3">
    <ul class="pagination justify-content-end mb-0">
      <li
        v-for="(link, i) in links"
        :key="i"
        class="page-item"
        :class="{ active: link.active, disabled: !link.url }"
      >
        <Link
          class="page-link"
          :href="link.url || ''"
          preserve-scroll
          v-html="link.label"
        />
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  links: {
    type: Array,
    default: () => [],
  },
})
</script>
