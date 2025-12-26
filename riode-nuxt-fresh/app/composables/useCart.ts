type CartItem = {
  id: number
  slug: string
  name: string
  price: number
  image: string
  qty: number
  href?: string
}

type CartPopupState = {
  visible: boolean
  item: CartItem | null
  qty: number
}

let popupTimer: ReturnType<typeof setTimeout> | null = null

export const useCart = () => {
  const cart = useState<CartItem[]>('cart-items', () => [])
  const hydrated = useState<boolean>('cart-hydrated', () => false)
  const popup = useState<CartPopupState>('cart-popup', () => ({
    visible: false,
    item: null,
    qty: 1
  }))

  const cartCount = computed(() =>
    cart.value.reduce((total, item) => total + item.qty, 0)
  )

  const cartSubtotal = computed(() =>
    cart.value.reduce((total, item) => total + item.price * item.qty, 0)
  )

  const persist = () => {
    if (!process.client || !hydrated.value) {
      return
    }
    localStorage.setItem('riode-cart', JSON.stringify(cart.value))
  }

  const showPopup = (item: CartItem, qty: number) => {
    if (!process.client) {
      return
    }
    popup.value.item = item
    popup.value.qty = qty
    popup.value.visible = true
    if (popupTimer) {
      clearTimeout(popupTimer)
    }
    popupTimer = setTimeout(() => {
      popup.value.visible = false
    }, 2500)
  }

  const addToCart = (product: { id: number; slug: string; name: string; price: number; image: string }, qty = 1) => {
    const quantity = Number(qty)
    const safeQty = Number.isFinite(quantity) && quantity > 0 ? quantity : 1
    const existing = cart.value.find((item) => item.id === product.id)
    const safePrice = Number.isFinite(Number(product.price)) ? Number(product.price) : 0
    const safeImage = product.image || '/images/demos/demo-market1/product/1-318x366.jpg'
    let item: CartItem
    if (existing) {
      existing.qty += safeQty
      item = existing
    } else {
      item = {
        id: product.id,
        slug: product.slug,
        name: product.name,
        price: safePrice,
        image: safeImage,
        qty: safeQty,
        href: `/product/${product.slug}`
      }
      cart.value.push(item)
    }
    persist()
    showPopup(item, safeQty)
  }

  const updateQty = (id: number, qty: number) => {
    const target = cart.value.find((item) => item.id === id)
    if (!target) return
    const next = Number(qty)
    target.qty = Number.isFinite(next) && next > 0 ? Math.floor(next) : 1
  }

  const removeItem = (id: number) => {
    cart.value = cart.value.filter((item) => item.id !== id)
  }

  const clearCart = () => {
    cart.value = []
  }

  onMounted(() => {
    if (!process.client || hydrated.value) {
      return
    }
    const stored = localStorage.getItem('riode-cart')
    if (stored) {
      try {
        const parsed = JSON.parse(stored)
        if (Array.isArray(parsed)) {
          cart.value = parsed.map((item) => ({
            ...item,
            price: Number.isFinite(Number(item.price)) ? Number(item.price) : 0,
            qty: Number.isFinite(Number(item.qty)) && Number(item.qty) > 0 ? Math.floor(Number(item.qty)) : 1,
            image: item.image || '/images/demos/demo-market1/product/1-318x366.jpg',
            href: item.href || (item.slug ? `/product/${item.slug}` : '#')
          }))
        }
      } catch {
        cart.value = []
      }
    }
    hydrated.value = true
  })

  watch(
    cart,
    () => {
      persist()
    },
    { deep: true }
  )

  return {
    cart,
    cartCount,
    cartSubtotal,
    popup,
    addToCart,
    updateQty,
    removeItem,
    clearCart
  }
}
