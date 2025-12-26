export type SubCategory = {
  id: number
  category_id: number
  name: string
  slug: string
  image_url: string | null
  icon_url: string | null
}

export type Category = {
  id: number
  name: string
  slug: string
  image_url: string | null
  icon_url: string | null
  subcategories: SubCategory[]
}

const normalizeCategory = (item: Partial<Category>): Category => ({
  id: Number(item.id ?? 0),
  name: item.name ?? 'Category',
  slug: item.slug ?? '',
  image_url: item.image_url ?? null,
  icon_url: item.icon_url ?? null,
  subcategories: []
})

const normalizeSubCategory = (item: Partial<SubCategory>): SubCategory => ({
  id: Number(item.id ?? 0),
  category_id: Number(item.category_id ?? 0),
  name: item.name ?? 'Subcategory',
  slug: item.slug ?? '',
  image_url: item.image_url ?? null,
  icon_url: item.icon_url ?? null
})

const unwrapCollection = <T>(payload: T[] | { data?: T[] } | null | undefined) => {
  if (!payload) {
    return []
  }
  return Array.isArray(payload) ? payload : payload.data ?? []
}

export const useCategories = () => {
  const config = useRuntimeConfig()
  const cachedCategories = useState<Category[]>('categories-cache', () => [])
  const categoriesLoaded = useState<boolean>('categories-loaded', () => false)

  const { data, pending, error } = useAsyncData(
    'categories',
    async () => {
      if (categoriesLoaded.value && cachedCategories.value.length) {
        return cachedCategories.value
      }

      const categoryPayload = await $fetch<Category[] | { data?: Category[] }>(
        `${config.public.apiBase}/categories`
      )
      const normalized = unwrapCollection(categoryPayload).map((item) => normalizeCategory(item))
      const subcategories = await Promise.all(
        normalized.map(async (category) => {
          if (!category.slug) {
            return []
          }

          try {
            const subcategoryPayload = await $fetch<SubCategory[] | { data?: SubCategory[] }>(
              `${config.public.apiBase}/categories/${encodeURIComponent(category.slug)}/subcategories`
            )
            return unwrapCollection(subcategoryPayload).map((item) => normalizeSubCategory(item))
          } catch {
            return []
          }
        })
      )

      cachedCategories.value = normalized.map((category, index) => ({
        ...category,
        subcategories: subcategories[index] ?? []
      }))
      categoriesLoaded.value = true
      return cachedCategories.value
    },
    { immediate: !categoriesLoaded.value }
  )

  const categories = computed(() =>
    cachedCategories.value.length ? cachedCategories.value : data.value ?? []
  )

  return {
    categories,
    pending,
    error
  }
}
