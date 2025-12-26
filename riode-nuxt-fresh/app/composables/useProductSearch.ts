export type ProductSearchItem = {
  id: number
  slug: string
  name: string
  category: string
  image: string
  price: number
  oldPrice: number | null
  ratingPercent: number
  reviewCount: number
  sku: string
  brand: string
  shortDesc: string
  labels?: { text: string; class: string }[]
  href?: string
  colors?: string[]
  sizes?: string[]
  plans?: string[]
}

export type ProductSearchParams = {
  page?: number
  per_page?: number
  category_id?: number
  sub_category_id?: number
  vendor_id?: number
  search?: string
  min_price?: number
  max_price?: number
  colors?: string[]
  sizes?: string[]
  plans?: string[]
  sort?: string
}

type ProductSearchResponse = {
  items: ProductSearchItem[]
  total: number
  per_page: number
  current_page: number
}

const normalizeArray = (value?: string[]) =>
  (value ?? []).map((item) => item.trim()).filter(Boolean)

const normalizeParams = (params: ProductSearchParams) => {
  const normalized = {
    page: params.page ?? 1,
    per_page: params.per_page ?? 15,
    category_id: params.category_id,
    sub_category_id: params.sub_category_id,
    vendor_id: params.vendor_id,
    search: params.search?.trim() || undefined,
    min_price: params.min_price,
    max_price: params.max_price,
    colors: normalizeArray(params.colors),
    sizes: normalizeArray(params.sizes),
    plans: normalizeArray(params.plans),
    sort: params.sort || undefined
  }

  return normalized
}

const buildKey = (params: ReturnType<typeof normalizeParams>) => {
  const keyPayload = {
    ...params,
    colors: params.colors?.slice().sort(),
    sizes: params.sizes?.slice().sort(),
    plans: params.plans?.slice().sort()
  }

  return JSON.stringify(keyPayload)
}

export const useProductSearch = (params: Ref<ProductSearchParams> | ProductSearchParams) => {
  const config = useRuntimeConfig()
  const cache = useState<Record<string, ProductSearchResponse>>('product-search-cache', () => ({}))
  const pending = ref(false)
  const error = ref<unknown>(null)

  const paramsRef = computed(() => unref(params))
  const normalizedParams = computed(() => normalizeParams(paramsRef.value))
  const key = computed(() => buildKey(normalizedParams.value))

  const load = async () => {
    const keyValue = key.value
    if (cache.value[keyValue]) {
      return
    }

    pending.value = true
    error.value = null

    const query: Record<string, string | number | undefined> = {
      page: normalizedParams.value.page,
      per_page: normalizedParams.value.per_page,
      category_id: normalizedParams.value.category_id,
      sub_category_id: normalizedParams.value.sub_category_id,
      vendor_id: normalizedParams.value.vendor_id,
      search: normalizedParams.value.search,
      min_price: normalizedParams.value.min_price,
      max_price: normalizedParams.value.max_price,
      sort: normalizedParams.value.sort
    }

    const colors = normalizedParams.value.colors
    const sizes = normalizedParams.value.sizes
    const plans = normalizedParams.value.plans
    if (colors.length) query.colors = colors.join(',')
    if (sizes.length) query.sizes = sizes.join(',')
    if (plans.length) query.plans = plans.join(',')

    try {
      const response = await $fetch<ProductSearchResponse>(`${config.public.apiBase}/products`, {
        query
      })
      cache.value[keyValue] = response
    } catch (err) {
      error.value = err
    } finally {
      pending.value = false
    }
  }

  watch(
    key,
    () => {
      void load()
    },
    { immediate: true }
  )

  const data = computed<ProductSearchResponse>(() => {
    return cache.value[key.value] ?? {
      items: [],
      total: 0,
      per_page: normalizedParams.value.per_page ?? 15,
      current_page: normalizedParams.value.page ?? 1
    }
  })

  return {
    data,
    pending,
    error
  }
}
