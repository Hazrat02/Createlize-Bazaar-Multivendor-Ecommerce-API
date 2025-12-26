type ProductLabel = {
  text: string
  class: string
}

export type Product = {
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
  labels?: ProductLabel[]
  href?: string
}

const defaultGallery = [
  {
    image: '/images/product/product-1-1-580x652.jpg',
    zoom: '/images/product/product-1-1-800x900.jpg',
    thumb: '/images/product/product-1-1-109x122.jpg',
    alt: 'Product image 1'
  },
  {
    image: '/images/product/product-1-2-580x652.jpg',
    zoom: '/images/product/product-1-2-800x900.jpg',
    thumb: '/images/product/product-1-2-109x122.jpg',
    alt: 'Product image 2'
  },
  {
    image: '/images/product/product-1-3-580x652.jpg',
    zoom: '/images/product/product-1-3-800x900.jpg',
    thumb: '/images/product/product-1-3-109x122.jpg',
    alt: 'Product image 3'
  },
  {
    image: '/images/product/product-1-4-580x652.jpg',
    zoom: '/images/product/product-1-4-800x900.jpg',
    thumb: '/images/product/product-1-4-109x122.jpg',
    alt: 'Product image 4'
  }
]

const formatPrice = (value: number) => `$${value.toFixed(2)}`

const fallbackImage = '/images/demos/demo-market1/product/1-318x366.jpg'

const normalizeProduct = (item: Partial<Product>): Product => ({
  id: Number(item.id ?? 0),
  slug: item.slug ?? '',
  name: item.name ?? 'Product',
  category: item.category ?? 'Uncategorized',
  image: item.image || fallbackImage,
  price: Number(item.price ?? 0),
  oldPrice: item.oldPrice === null || item.oldPrice === undefined ? null : Number(item.oldPrice),
  ratingPercent: Number(item.ratingPercent ?? 80),
  reviewCount: Number(item.reviewCount ?? 0),
  sku: item.sku ?? 'SKU-0000',
  brand: item.brand ?? 'Createlize',
  shortDesc:
    item.shortDesc ??
    'A reliable everyday item with a clean, modern finish and practical details.',
  labels: item.labels ?? [],
  href: item.href ?? (item.slug ? `/product/${item.slug}` : '#')
})

export const useProducts = () => {
  const config = useRuntimeConfig()
  const { data, pending, error } = useAsyncData('products', async () => {
    return await $fetch<{ items: Product[]; total: number }>(`${config.public.apiBase}/products`, {
      query: { per_page: 200 }
    })
  })

  const products = computed<Product[]>(() =>
    (data.value?.items ?? []).map((item) => normalizeProduct(item))
  )

  const total = computed(() => Number(data.value?.total ?? products.value.length))

  const sliceSection = (start: number, count: number) =>
    products.value.slice(start, start + count).filter(Boolean)

  const homeSections = computed(() => ({
    dealMain: products.value[0] ?? normalizeProduct({}),
    dealList: sliceSection(1, 8),
    gridA: sliceSection(9, 8),
    gridB: sliceSection(17, 8),
    gridCPrimary: sliceSection(25, 8),
    gridCSecondary: sliceSection(33, 5),
    recent: sliceSection(38, 8)
  }))

  const getProductBySlug = (slug: string | undefined) => {
    if (!slug) {
      return products.value[0] ?? normalizeProduct({})
    }
    return products.value.find((product) => product.slug === slug) ?? normalizeProduct({})
  }

  return {
    products,
    total,
    pending,
    error,
    homeSections,
    defaultGallery,
    formatPrice,
    getProductBySlug
  }
}
