type OwlOptions = {
  items?: number
  nav?: boolean
  dots?: boolean
  loop?: boolean
  margin?: number
  autoplay?: boolean
  autoplayTimeout?: number
  responsive?: Record<string, { items?: number }>
}

type CarouselState = {
  el: HTMLElement
  stageOuter: HTMLElement
  stage: HTMLElement
  items: HTMLElement[]
  options: OwlOptions
  index: number
  timer?: number
  dragging?: boolean
  startX?: number
  startTranslate?: number
}

const carouselMap = new Map<HTMLElement, CarouselState>()

const parseOptions = (value: string | null): OwlOptions => {
  if (!value) {
    return {}
  }
  try {
    const normalized = value.replace(/'/g, '"').replace(/;$/, '')
    return JSON.parse(normalized)
  } catch {
    return {}
  }
}

const getItemsPerView = (options: OwlOptions): number => {
  let items = options.items ?? 1
  const responsive = options.responsive ?? {}
  const width = window.innerWidth
  const breakpoints = Object.keys(responsive)
    .map((key) => Number(key))
    .filter((key) => !Number.isNaN(key))
    .sort((a, b) => a - b)

  for (const point of breakpoints) {
    if (width >= point) {
      const config = responsive[String(point)]
      if (config?.items) {
        items = config.items
      }
    }
  }

  return items
}

const applyAnimation = (el: HTMLElement) => {
  const optionsRaw = el.getAttribute('data-animation-options')
  const options = parseOptions(optionsRaw)
  const name = (options as any).name || 'fadeIn'
  const duration = (options as any).duration || '1.2s'
  const delay = (options as any).delay || '0s'

  el.style.animationDuration = duration
  el.style.animationDelay = delay
  el.classList.add('appear-animation-visible', name)
}

const updateDots = (container: HTMLElement, total: number, index: number) => {
  const dots = Array.from(container.querySelectorAll<HTMLButtonElement>('.owl-dot'))
  dots.forEach((dot, i) => {
    dot.classList.toggle('active', i === index)
  })
  if (dots.length !== total) {
    container.innerHTML = ''
    for (let i = 0; i < total; i += 1) {
      const button = document.createElement('button')
      button.type = 'button'
      button.className = `owl-dot${i === index ? ' active' : ''}`
      const span = document.createElement('span')
      button.appendChild(span)
      container.appendChild(button)
    }
  }
}

const updateNav = (container: HTMLElement, index: number, maxIndex: number, loop?: boolean) => {
  const prev = container.querySelector<HTMLButtonElement>('.owl-prev')
  const next = container.querySelector<HTMLButtonElement>('.owl-next')
  if (loop) {
    if (prev) prev.classList.remove('disabled')
    if (next) next.classList.remove('disabled')
    return
  }
  if (prev) prev.classList.toggle('disabled', index <= 0)
  if (next) next.classList.toggle('disabled', index >= maxIndex)
}

const updateCarousel = (state: CarouselState) => {
  const { stageOuter, stage, items, options } = state
  const perView = Math.max(1, getItemsPerView(options))
  const margin = options.margin ?? 0
  const containerWidth = stageOuter.clientWidth || stageOuter.getBoundingClientRect().width
  const itemWidth = (containerWidth - margin * (perView - 1)) / perView
  const maxIndex = Math.max(0, items.length - perView)

  if (state.index > maxIndex) state.index = maxIndex
  if (state.index < 0) state.index = 0

  items.forEach((item, i) => {
    item.style.width = `${itemWidth}px`
    item.style.marginRight = i === items.length - 1 ? '0px' : `${margin}px`
    item.style.flex = '0 0 auto'
    item.style.boxSizing = 'border-box'
    const isActive = i >= state.index && i < state.index + perView
    item.classList.toggle('active', isActive)
    if (isActive) {
      item.querySelectorAll<HTMLElement>('.slide-animate').forEach((el) => {
        el.classList.add('show-content')
        applyAnimation(el)
      })
    }
  })

  stage.style.width = `${itemWidth * items.length + margin * Math.max(0, items.length - 1)}px`
  stage.style.transform = `translate3d(-${state.index * (itemWidth + margin)}px, 0, 0)`

  const nav = state.el.querySelector<HTMLElement>('.owl-nav')
  if (nav) {
    updateNav(nav, state.index, maxIndex, state.options.loop)
  }
  const dots = state.el.querySelector<HTMLElement>('.owl-dots')
  if (dots) {
    const totalPages = Math.max(1, Math.ceil(items.length / perView))
    const activePage = Math.min(totalPages - 1, Math.floor(state.index / perView))
    updateDots(dots, totalPages, activePage)
  }
}

const buildCarousel = (el: HTMLElement) => {
  if (el.dataset.owlInitialized === 'true') {
    const state = carouselMap.get(el)
    if (state) updateCarousel(state)
    return
  }

  const options = parseOptions(el.getAttribute('data-owl-options'))
  const originalItems = Array.from(el.children) as HTMLElement[]

  const layoutClasses = Array.from(el.classList).filter((cls) => {
    return (
      cls === 'row' ||
      cls.startsWith('cols-') ||
      cls.startsWith('gutter') ||
      cls === 'gutter-no'
    )
  })
  layoutClasses.forEach((cls) => el.classList.remove(cls))
  const stageOuter = document.createElement('div')
  stageOuter.className = 'owl-stage-outer'
  stageOuter.style.overflow = 'hidden'
  stageOuter.style.width = '100%'
  stageOuter.style.position = 'relative'
  const stage = document.createElement('div')
  stage.className = 'owl-stage'
  stage.style.display = 'flex'
  stage.style.position = 'relative'
  stage.style.willChange = 'transform'
  stage.style.transition = 'transform 0.4s ease'
  layoutClasses.forEach((cls) => stage.classList.add(cls))

  const items: HTMLElement[] = []
  originalItems.forEach((item) => {
    const wrapper = document.createElement('div')
    wrapper.className = 'owl-item'
    item.style.width = '100%'
    wrapper.appendChild(item)
    items.push(wrapper)
    stage.appendChild(wrapper)
  })

  el.innerHTML = ''
  stageOuter.appendChild(stage)
  el.appendChild(stageOuter)
  el.classList.add('owl-loaded', 'owl-drag')

  const state: CarouselState = {
    el,
    stageOuter,
    stage,
    items,
    options,
    index: 0
  }
  carouselMap.set(el, state)

  if (options.nav) {
    const nav = document.createElement('div')
    nav.className = 'owl-nav'
    const prev = document.createElement('button')
    prev.type = 'button'
    prev.className = 'owl-prev'
    prev.innerHTML = '<i class="d-icon-angle-left"></i>'
    const next = document.createElement('button')
    next.type = 'button'
    next.className = 'owl-next'
    next.innerHTML = '<i class="d-icon-angle-right"></i>'
    nav.appendChild(prev)
    nav.appendChild(next)
    el.appendChild(nav)
    prev.addEventListener('click', () => {
      const perView = Math.max(1, getItemsPerView(state.options))
      const maxIndex = Math.max(0, state.items.length - perView)
      if (state.options.loop && maxIndex > 0) {
        state.index = state.index <= 0 ? maxIndex : state.index - 1
      } else {
        state.index = Math.max(0, state.index - 1)
      }
      updateCarousel(state)
    })
    next.addEventListener('click', () => {
      const perView = Math.max(1, getItemsPerView(state.options))
      const maxIndex = Math.max(0, state.items.length - perView)
      if (state.options.loop && maxIndex > 0) {
        state.index = state.index >= maxIndex ? 0 : state.index + 1
      } else {
        state.index = Math.min(maxIndex, state.index + 1)
      }
      updateCarousel(state)
    })
  }

  if (options.dots) {
    const dots = document.createElement('div')
    dots.className = 'owl-dots'
    el.appendChild(dots)
    dots.addEventListener('click', (event) => {
      const target = event.target as HTMLElement
      const dot = target.closest('.owl-dot') as HTMLElement | null
      if (!dot) return
      const allDots = Array.from(dots.querySelectorAll('.owl-dot'))
      const dotIndex = allDots.indexOf(dot)
      if (dotIndex >= 0) {
        const perView = Math.max(1, getItemsPerView(state.options))
        state.index = dotIndex * perView
        updateCarousel(state)
      }
    })
  }

  el.dataset.owlInitialized = 'true'
  updateCarousel(state)

  if (options.autoplay) {
    const timeout = options.autoplayTimeout ?? 5000
    state.timer = window.setInterval(() => {
      const perView = Math.max(1, getItemsPerView(state.options))
      const maxIndex = Math.max(0, state.items.length - perView)
      if (state.options.loop && maxIndex > 0) {
        state.index = state.index >= maxIndex ? 0 : state.index + 1
      } else {
        state.index = state.index >= maxIndex ? 0 : state.index + 1
      }
      updateCarousel(state)
    }, timeout)
    stageOuter.addEventListener('mouseenter', () => {
      if (state.timer) {
        window.clearInterval(state.timer)
        state.timer = undefined
      }
    })
    stageOuter.addEventListener('mouseleave', () => {
      if (!state.timer) {
        state.timer = window.setInterval(() => {
          const perView = Math.max(1, getItemsPerView(state.options))
          const maxIndex = Math.max(0, state.items.length - perView)
          if (state.options.loop && maxIndex > 0) {
            state.index = state.index >= maxIndex ? 0 : state.index + 1
          } else {
            state.index = state.index >= maxIndex ? 0 : state.index + 1
          }
          updateCarousel(state)
        }, timeout)
      }
    })
  }

  stageOuter.addEventListener('pointerdown', (event) => {
    state.dragging = true
    state.startX = event.clientX
    state.startTranslate = stage.style.transform
      ? Number(stage.style.transform.match(/-?\\d+\\.?\\d*/)?.[0] ?? 0)
      : 0
    stage.style.transition = 'none'
  })
  stageOuter.addEventListener('pointermove', (event) => {
    if (!state.dragging) return
    const dx = event.clientX - (state.startX ?? 0)
    stage.style.transform = `translate3d(${(state.startTranslate ?? 0) + dx}px, 0, 0)`
  })
  const endDrag = (event: PointerEvent) => {
    if (!state.dragging) return
    state.dragging = false
    const perView = Math.max(1, getItemsPerView(state.options))
    const margin = state.options.margin ?? 0
    const containerWidth = stageOuter.clientWidth || stageOuter.getBoundingClientRect().width
    const itemWidth = (containerWidth - margin * (perView - 1)) / perView
    const dx = event.clientX - (state.startX ?? 0)
    const threshold = itemWidth * 0.2
    const maxIndex = Math.max(0, state.items.length - perView)

    if (dx > threshold) {
      if (state.options.loop && maxIndex > 0) {
        state.index = state.index <= 0 ? maxIndex : state.index - 1
      } else {
        state.index = Math.max(0, state.index - 1)
      }
    } else if (dx < -threshold) {
      if (state.options.loop && maxIndex > 0) {
        state.index = state.index >= maxIndex ? 0 : state.index + 1
      } else {
        state.index = Math.min(maxIndex, state.index + 1)
      }
    }

    stage.style.transition = 'transform 0.4s ease'
    updateCarousel(state)
  }
  stageOuter.addEventListener('pointerup', endDrag)
  stageOuter.addEventListener('pointerleave', endDrag)
}

const initCarousels = () => {
  const carousels = Array.from(document.querySelectorAll<HTMLElement>('.owl-carousel'))
  carousels.forEach((carousel) => buildCarousel(carousel))
}

const refreshCarousels = () => {
  carouselMap.forEach((state) => updateCarousel(state))
}

const initAppearAnimations = () => {
  const items = Array.from(document.querySelectorAll<HTMLElement>('.appear-animate'))
  if (!items.length) return

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries, obs) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return
          const target = entry.target as HTMLElement
          applyAnimation(target)
          obs.unobserve(target)
        })
      },
      { rootMargin: '0px 0px -10% 0px', threshold: 0.1 }
    )

    items.forEach((item) => observer.observe(item))
  } else {
    items.forEach((item) => applyAnimation(item))
  }
}

const initMobileMenu = () => {
  const body = document.body
  const open = () => body.classList.add('mmenu-active')
  const close = () => body.classList.remove('mmenu-active')

  document.querySelectorAll('.mobile-menu-toggle').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      open()
    })
  })
  document.querySelectorAll('.mobile-menu-overlay, .mobile-menu-close').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      close()
    })
  })
}

const initOffCanvas = () => {
  const openDropdown = (selector: string) => {
    document.querySelectorAll(selector).forEach((el) => el.classList.add('opened'))
  }
  const closeDropdown = (selector: string) => {
    document.querySelectorAll(selector).forEach((el) => el.classList.remove('opened'))
  }

  document.querySelectorAll('.cart-toggle').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      openDropdown('.cart-dropdown')
    })
  })
  document.querySelectorAll('.wishlist-toggle').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      openDropdown('.wishlist-dropdown')
    })
  })
  document.querySelectorAll('.cart-dropdown .btn-close, .cart-dropdown .canvas-overlay').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      closeDropdown('.cart-dropdown')
    })
  })
  document.querySelectorAll('.wishlist-dropdown .btn-close, .wishlist-dropdown .canvas-overlay').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      closeDropdown('.wishlist-dropdown')
    })
  })
}

const initSticky = () => {
  const headers = Array.from(document.querySelectorAll<HTMLElement>('.sticky-header'))
  const footers = Array.from(document.querySelectorAll<HTMLElement>('.sticky-footer'))

  const updateOffsets = () => {
    headers.forEach((header) => {
      header.dataset.stickyOffset = String(header.offsetTop + header.offsetHeight)
    })
  }

  const onScroll = () => {
    const y = window.scrollY
    headers.forEach((header) => {
      const offset = Number(header.dataset.stickyOffset || 0)
      header.classList.toggle('fixed', y >= offset)
    })

    footers.forEach((footer) => {
      const shouldFix = window.innerWidth <= 767 && y > 150
      footer.classList.toggle('fixed', shouldFix)
    })
  }

  updateOffsets()
  onScroll()
  window.addEventListener('resize', updateOffsets)
  window.addEventListener('scroll', onScroll, { passive: true })
}

const initTabs = () => {
  document.querySelectorAll('.tab .nav-link').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      const link = event.currentTarget as HTMLAnchorElement
      const targetSelector = link.getAttribute('href')
      if (!targetSelector || !targetSelector.startsWith('#')) return
      event.preventDefault()

      const tab = link.closest('.tab')
      if (!tab) return

      tab.querySelectorAll('.nav-link').forEach((item) => item.classList.remove('active'))
      link.classList.add('active')

      const panes = tab.querySelectorAll<HTMLElement>('.tab-pane')
      panes.forEach((pane) => pane.classList.remove('active', 'in'))
      const target = tab.querySelector<HTMLElement>(targetSelector)
      if (target) target.classList.add('active', 'in')
      refreshCarousels()
    })
  })
}

const initAccordions = () => {
  document.querySelectorAll('.accordion .card-header > a').forEach((el) => {
    if ((el as HTMLElement).dataset.uiBound === 'true') return
    ;(el as HTMLElement).dataset.uiBound = 'true'
    el.addEventListener('click', (event) => {
      event.preventDefault()
      const link = event.currentTarget as HTMLAnchorElement
      const targetSelector = link.getAttribute('href')
      if (!targetSelector || !targetSelector.startsWith('#')) return
      const target = document.querySelector<HTMLElement>(targetSelector)
      if (!target) return

      const isOpen = target.classList.contains('expanded')
      if (isOpen) {
        target.classList.remove('expanded')
        target.classList.add('collapsed')
        target.style.display = 'none'
      } else {
        target.classList.remove('collapsed')
        target.classList.add('expanded')
        target.style.display = 'block'
      }
    })
  })
}

const initScrollTop = () => {
  const btn = document.getElementById('scroll-top')
  if (!btn) return

  const onScroll = () => {
    btn.classList.toggle('show', window.scrollY > 200)
  }
  onScroll()
  if ((btn as HTMLElement).dataset.uiBound !== 'true') {
    ;(btn as HTMLElement).dataset.uiBound = 'true'
    window.addEventListener('scroll', onScroll, { passive: true })
    btn.addEventListener('click', (event) => {
      event.preventDefault()
      window.scrollTo({ top: 0, behavior: 'smooth' })
    })
  }
}

const initAll = () => {
  initAppearAnimations()
  initCarousels()
  initMobileMenu()
  initOffCanvas()
  initSticky()
  initTabs()
  initAccordions()
  initScrollTop()
}

export default defineNuxtPlugin((nuxtApp) => {
  let resizeBound = false
  nuxtApp.hook('page:finish', () => {
    window.requestAnimationFrame(initAll)
  })
  if (!resizeBound) {
    resizeBound = true
    window.addEventListener('resize', () => {
      carouselMap.forEach((state) => updateCarousel(state))
    })
  }
})
