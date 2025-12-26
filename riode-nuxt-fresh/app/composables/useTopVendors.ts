export type TopVendorProduct = {
  id: number
  slug: string
  name: string
  image_url: string | null
}

export type TopVendor = {
  id: number
  name: string
  store_name?: string | null
  logo_url: string | null
  product_count: number
  top_products: TopVendorProduct[]
}

type TopVendorResponse = {
  items: TopVendor[]
  from: string
}

export const useTopVendors = (limit = 4) => {
  const config = useRuntimeConfig()
  const cache = useState<Record<string, TopVendorResponse>>('top-vendors-cache', () => ({}))

  const key = `top-weekly-${limit}`
  const { data, pending, error } = useAsyncData(
    key,
    async () => {
      if (cache.value[key]) {
        return cache.value[key]
      }

      const response = await $fetch<TopVendorResponse>(`${config.public.apiBase}/vendors/top-weekly`, {
        query: { limit }
      })

      cache.value[key] = response
      return response
    },
    { immediate: true }
  )

  const vendors = computed(() => data.value?.items ?? cache.value[key]?.items ?? [])

  return {
    vendors,
    pending,
    error
  }
}
