<template>
  <div>

    <div class="page-wrapper">
        <h1 class="d-none">{{ siteName }} - Responsive eCommerce HTML Template</h1>
        <header class="header">
            <div class="header-top">
                <div class="container">
                    <div class="header-left">
                        <p class="welcome-msg ls-normal">Welcome to {{ siteName }} store message or remove it!</p>
                    </div>
                    <div class="header-right">
                        <div class="dropdown">
                            <a href="#currency">USD</a>
                            <ul class="dropdown-box">
                                <li><a href="#USD">USD</a></li>
                                <li><a href="#EUR">EUR</a></li>
                            </ul>
                        </div>
                        <!-- End DropDown Menu -->
                        <div class="dropdown ml-5">
                            <a href="#language">ENG</a>
                            <ul class="dropdown-box">
                                <li>
                                    <a href="#USD">ENG</a>
                                </li>
                                <li>
                                    <a href="#EUR">FRH</a>
                                </li>
                            </ul>
                        </div>
                        <!-- End DropDown Menu -->
                        <span class="divider"></span>
                        <NuxtLink to="/store-listing" class="contact d-lg-show"><i class="d-icon-map"></i>Vendors</NuxtLink>
                        <a href="#" class="help d-lg-show"><i class="d-icon-info"></i> My Account</a>
                        <a class="login-link" href="#" data-toggle="login-modal"><i
                                class="d-icon-user"></i>Sign in</a>
                        <span class="delimiter">/</span>
                        <a class="register-link ml-0" href="#" data-toggle="login-modal">Register</a>
                        <!-- End of Login -->
                    </div>
                </div>
            </div>
            <!-- End HeaderTop -->
            <div class="header-middle sticky-header fix-top sticky-content">
                <div class="container">
                    <div class="header-left mr-4">
                        <a href="#" class="mobile-menu-toggle">
                            <i class="d-icon-bars2"></i>
                        </a>
                        <NuxtLink to="/" class="logo">
                            <img :src="siteLogoWide" :alt="siteName" width="153" height="44" />
                        </NuxtLink>
                        <!-- End Logo -->

                        <div class="header-search hs-expanded">
                            <form action="#" class="input-wrapper" @submit.prevent="submitSearch">
                                <div class="select-box">
                                    <select v-model="searchCategory" name="cat" class="cat">
                                        <option value="all-cat">All Categories</option>
                                        <option v-for="category in categories" :key="category.slug || category.id"
                                            :value="category.slug">
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                                <input v-model="searchInput" type="text" class="form-control" name="search"
                                    autocomplete="off"
                                    placeholder="Search..." required />
                                <button class="btn btn-search" type="submit">
                                    <i class="d-icon-search"></i>
                                </button>
                            </form>
                        </div>
                        <!-- End Header Search -->
                    </div>
                    <div class="header-right">
                        <div class="icon-box icon-box-side">
                            <div class="icon-box-icon mr-0 mr-lg-2">
                                <i class="d-icon-phone"></i>
                            </div>
                            <div class="icon-box-content d-lg-show">
                                <h4 class="icon-box-title text-dark text-normal">
                                    <a href="/cdn-cgi/l/email-protection#c0b2a9afa4a580ada1a9aceea3afad" class="text-primary d-inline-block">Live chat</a>
                                    or:</h4>
                                <p><a href="tel:#">0(800) 123-456</a></p>
                            </div>
                        </div>
                        <span class="divider mr-4"></span>
                        <div class="dropdown compare-dropdown off-canvas mr-xl-7 mr-4">
                            <a href="#" class="compare compare-toggle mr-0">
                                <i class="d-icon-compare"></i>
                            </a>
                            <div class="canvas-overlay"></div>
                            <!-- End Compare Toggle -->
                            <div class="dropdown-box scrollable">
                                <div class="canvas-header">
                                    <h4 class="canvas-title">Compare</h4>
                                    <a href="#" class="btn btn-dark btn-link btn-icon-right btn-close">close<i
                                            class="d-icon-arrow-right"></i><span class="sr-only">Compare</span></a>
                                </div>
                                <div class="products scrollable">
                                    <div class="product product-compare">
                                        <figure class="product-media">
                                            <NuxtLink to="/product">
                                                <img src="/images/compare/product-1.jpg" alt="product" width="80"
                                                    height="88" />
                                            </NuxtLink>
                                            <button class="btn btn-link btn-close">
                                                <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                            </button>
                                        </figure>
                                        <div class="product-detail">
                                            <NuxtLink to="/product" class="product-name">Riode White Trends</NuxtLink>
                                            <div class="price-box">
                                                <span class="product-price">$21.00
                                                    <del class="old-price pl-1">$40.00</del>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End of Compare Product -->
                                    <div class="product product-compare">
                                        <figure class="product-media">
                                            <NuxtLink to="/product">
                                                <img src="/images/compare/product-2.jpg" alt="product" width="80"
                                                    height="88" />
                                            </NuxtLink>
                                            <button class="btn btn-link btn-close">
                                                <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                            </button>
                                        </figure>
                                        <div class="product-detail">
                                            <NuxtLink to="/product" class="product-name">Dark Blue Women’s
                                                Leomora Hat</NuxtLink>
                                            <div class="price-box">
                                                <span class="product-price">$118.00
                                                    <del class="old-price pl-1">$158.99</del>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of Compare Product -->
                                </div>
                                <NuxtLink to="/compare" class="btn btn-dark compare-btn mt-4"><span>Go To Compare
                                        List</span></NuxtLink>
                                <!-- End of Products  -->
                            </div>
                            <!-- End Dropdown Box -->
                        </div>
                        <div class="dropdown wishlist wishlist-dropdown off-canvas">
                            <NuxtLink to="/wishlist" class="wishlist-toggle">
                                <i class="d-icon-heart"></i>
                            </NuxtLink>
                            <div class="canvas-overlay"></div>
                            <!-- End Wishlist Toggle -->
                            <div class="dropdown-box scrollable">
                                <div class="canvas-header">
                                    <h4 class="canvas-title">wishlist</h4>
                                    <a href="#" class="btn btn-dark btn-link btn-icon-right btn-close">close<i
                                            class="d-icon-arrow-right"></i><span class="sr-only">wishlist</span></a>
                                </div>
                                <div class="products scrollable">
                                    <div class="product product-wishlist">
                                        <figure class="product-media">
                                            <NuxtLink to="/product">
                                                <img src="/images/wishlist/product-1.jpg" width="100" height="100"
                                                    alt="product" />
                                            </NuxtLink>
                                            <button class="btn btn-link btn-close">
                                                <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                            </button>
                                        </figure>
                                        <div class="product-detail">
                                            <NuxtLink to="/product" class="product-name">Girl's Dark Bag</NuxtLink>
                                            <div class="price-box">
                                                <span class="product-price">$84.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of wishlist Product -->
                                    <div class="product product-wishlist">
                                        <figure class="product-media">
                                            <NuxtLink to="/product">
                                                <img src="/images/wishlist/product-2.jpg" width="100" height="100"
                                                    alt="product" />
                                            </NuxtLink>
                                            <button class="btn btn-link btn-close">
                                                <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                            </button>
                                        </figure>
                                        <div class="product-detail">
                                            <NuxtLink to="/product" class="product-name">Women's Fashional Comforter
                                            </NuxtLink>
                                            <div class="price-box">
                                                <span class="product-price">$84.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End of wishlist Product -->
                                    <div class="product product-wishlist">
                                        <figure class="product-media">
                                            <NuxtLink to="/product">
                                                <img src="/images/wishlist/product-3.jpg" width="100" height="100"
                                                    alt="product" />
                                            </NuxtLink>
                                            <button class="btn btn-link btn-close">
                                                <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                            </button>
                                        </figure>
                                        <div class="product-detail">
                                            <NuxtLink to="/product" class="product-name">Wide Knickerbockers</NuxtLink>
                                            <div class="price-box">
                                                <span class="product-price">$84.00</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- End of wishlist Product -->
                                </div>
                                <NuxtLink to="/wishlist" class="btn btn-dark wishlist-btn mt-4"><span>Go To
                                        Wishlist</span></NuxtLink>
                                <!-- End of Products  -->
                            </div>
                            <!-- End Dropdown Box -->
                        </div>
                        <span class="divider"></span>
                        <div class="dropdown cart-dropdown type2 off-canvas mr-0 mr-lg-2">
                            <a href="#" class="cart-toggle label-block link">
                                <div class="cart-label d-lg-show">
                                    <span class="cart-name">Shopping Cart:</span>
                                    <span class="cart-price">{{ formatPrice(cartSubtotal) }}</span>
                                </div>
                                <i class="d-icon-bag"><span class="cart-count">{{ cartCount }}</span></i>
                            </a>
                            <div class="canvas-overlay"></div>
                            <!-- End Cart Toggle -->
                            <div class="dropdown-box">
                                <div class="canvas-header">
                                    <h4 class="canvas-title">Shopping Cart</h4>
                                    <a href="#" class="btn btn-dark btn-link btn-icon-right btn-close">close<i
                                            class="d-icon-arrow-right"></i><span class="sr-only">Cart</span></a>
                                </div>
                                <div class="products scrollable">
                                    <div v-if="!cart.length" class="text-center text-muted py-4">
                                        Your cart is empty.
                                    </div>
                                    <div v-for="item in cart" :key="item.id" class="product product-cart">
                                        <figure class="product-media">
                                            <NuxtLink :to="item.href || `/product/${item.slug}`">
                                                <img :src="item.image" :alt="item.name" width="80"
                                                    height="88" />
                                            </NuxtLink>
                                            <button class="btn btn-link btn-close" @click.prevent="removeItem(item.id)">
                                                <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                            </button>
                                        </figure>
                                        <div class="product-detail">
                                            <NuxtLink :to="item.href || `/product/${item.slug}`" class="product-name">{{ item.name }}</NuxtLink>
                                            <div class="price-box">
                                                <span class="product-quantity">{{ item.qty }}</span>
                                                <span class="product-price">{{ formatPrice(item.price) }}</span>
                                            </div>
                                        </div>
                                    </div>
</div>
                                <!-- End of Products  -->
                                <div class="cart-total">
                                    <label>Subtotal:</label>
                                    <span class="price">{{ formatPrice(cartSubtotal) }}</span>
                                </div>
                                <!-- End of Cart Total -->
                                <div class="cart-action">
                                    <NuxtLink to="/cart" class="btn btn-dark btn-link">View Cart</NuxtLink>
                                    <NuxtLink to="/checkout" class="btn btn-dark"><span>Go To Checkout</span></NuxtLink>
                                </div>
                                <!-- End of Cart Action -->
                            </div>
                            <!-- End Dropdown Box -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-bottom pb-0">
                <div class="container">
                    <nav class="menu category-menu">
                        <div v-for="item in categoryMenuItems" :key="item.key" class="category category-icon">
                            <NuxtLink :to="categoryLink(item)">
                                <figure class="categroy-media">
                                    <img v-if="item.iconUrl" :src="item.iconUrl" :alt="item.name" width="32" height="32"
                                        style="width: 2.2rem; height: 2.2rem; object-fit: contain;" />
                                    <i v-else :class="item.icon"></i>
                                </figure>
                                <div class="category-content">
                                    <h4 class="category-name">{{ item.name }}</h4>
                                </div>
                            </NuxtLink>
                        </div>
                    </nav>
                </div>
            </div>
        </header>
        <!-- End Header -->

        <main class="main">
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb">
                        <li><NuxtLink to="/"><i class="d-icon-home"></i></NuxtLink></li>
                        <li>{{ siteName }} Shop</li>
                    </ul>
                </div>
            </nav>
            <div class="page-content mb-10 pb-2">
                <div class="container">
                   
                    <div class="brand-wrapper mb-8">
                        <div class="owl-carousel owl-theme row cols-xl-7 cols-lg-6 cols-md-4 cols-sm-3 cols-2"
                            data-owl-options="{
                            'nav': false,
                            'dots': false,
                            'magin': 0,
                            'responsive': {
                                '0': {
                                    'items': 2
                                },
                                '576': {
                                    'items': 3
                                },
                                '768': {
                                    'items': 4
                                },
                                '992': {
                                    'items': 6
                                },
                                '1200': {
                                    'items': 7
                                }
                            }
                        }">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/1.jpg" alt="Brand" width="197"
                                    height="93" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/2.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/3.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/4.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/5.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/6.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                            <figure>
                                <img src="/images/demos/demo-market1/brand/shop/7.jpg" alt="Brand" width="213"
                                    height="100" />
                            </figure>
                        </div>
                    </div>
                    <!-- End Brand -->
                    <div class="row cols-xl-8 cols-lg-6 cols-md-4 cols-sm-3 cols-2">
                        <div v-for="item in shopCategoryIcons" :key="item.key" class="category-wrap mb-4">
                            <div class="category category-icon">
                                <NuxtLink :to="categoryLink(item)">
                                    <figure class="categroy-media">
                                        <img v-if="item.iconUrl" :src="item.iconUrl" :alt="item.name" width="32"
                                            height="32" style="width: 2.2rem; height: 2.2rem; object-fit: contain;" />
                                        <i v-else :class="item.icon"></i>
                                    </figure>
                                    <div :class="item.contentClass">
                                        <h4 class="category-name">{{ item.name }}</h4>
                                    </div>
                                </NuxtLink>
                            </div>
                        </div>
                    </div>
                    <!-- End Category icon -->
                    <nav class="toolbox toolbox-horizontal sticky-toolbox sticky-content fix-top pt-2" data-top="1174">
                        <aside class="sidebar sidebar-fixed shop-sidebar">
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="d-icon-times"></i></a>
                            <div class="sidebar-content toolbox-left">
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Size</a>
                                    <ul class="filter-items">
                                        <li v-for="size in availableSizes" :key="size">
                                            <a href="#" :class="{ active: selectedSizes.includes(size) }"
                                                @click.prevent="toggleListFilter('sizes', size)">
                                                {{ size }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Color</a>
                                    <ul class="filter-items">
                                        <li v-for="color in availableColors" :key="color">
                                            <a href="#" :class="{ active: selectedColors.includes(color) }"
                                                @click.prevent="toggleListFilter('colors', color)">
                                                {{ color }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="availablePlans.length" class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Plan</a>
                                    <ul class="filter-items">
                                        <li v-for="plan in availablePlans" :key="plan">
                                            <a href="#" :class="{ active: selectedPlans.includes(plan) }"
                                                @click.prevent="toggleListFilter('plans', plan)">
                                                {{ plan }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="toolbox-item select-menu">
                                    <a class="select-menu-toggle" href="#">Select Price</a>
                                    <ul class="filter-items filter-price">
                                        <li v-for="range in priceRanges" :key="range.label">
                                            <a href="#" :class="{ active: isPriceRangeSelected(range) }"
                                                @click.prevent="applyPriceRange(range)">
                                                {{ range.label }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                        <div class="toolbox-left">
                            <a href="#"
                                class="toolbox-item left-sidebar-toggle btn btn-sm btn-outline btn-primary btn-rounded btn-icon-right d-lg-none">
                                Filter<i class="d-icon-arrow-right"></i></a>
                            <div class="toolbox-item toolbox-sort select-menu">
                                <select v-model="sort" name="orderby" class="form-control ls-normal">
                                    <option value="default">Default sorting</option>
                                    <option value="popularity">Most popular</option>
                                    <option value="rating">Average rating</option>
                                    <option value="date">Latest</option>
                                    <option value="price-low">Sort forward price low</option>
                                    <option value="price-high">Sort forward price high</option>
                                    <option value="">Clear custom sort</option>
                                </select>
                            </div>
                        </div>
                        <div class="toolbox-right">
                            <div class="toolbox-item toolbox-show select-box text-dark">
                                <label>show :</label>
                                <select v-model.number="perPage" name="count" class="form-control">
                                    <option v-for="count in perPageOptions" :key="count" :value="count">
                                        {{ count }}
                                    </option>
                                </select>
                            </div>
                            <div class="toolbox-item toolbox-layout">
                                <a href="#" class="d-icon-mode-list btn-layout"></a>
                                <NuxtLink to="/shop" class="d-icon-mode-grid btn-layout active"></NuxtLink>
                            </div>
                        </div>
                    </nav>
                    <!-- End Toolbox -->
                    <div class="select-items">
                        <a href="#" class="filter-clean text-primary" @click.prevent="clearFilters">Clean All</a>
                    </div>
                    <div class="row product-wrapper cols-xl-5 cols-lg-4 cols-md-3 cols-2">
                        <div v-for="product in products" :key="product.id" class="product-wrap">
                            <ProductCard :product="product" />
                        </div>
                        <div v-if="!products.length && !productsPending" class="col-12 text-center py-6 text-muted">
                            No products found.
                        </div>
                    </div>
                    <!-- End Product -->
                    <nav class="toolbox toolbox-pagination">
                        <p class="show-info d-block">Showing<span>{{ showingFrom }}-{{ showingTo }} of {{ total }}</span> Products</p>
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: currentPage <= 1 }">
                                <a class="page-link page-link-prev" href="#" aria-label="Previous"
                                    @click.prevent="goToPage(currentPage - 1)">
                                    <i class="d-icon-arrow-left"></i>Prev
                                </a>
                            </li>
                            <li v-for="page in paginationPages" :key="page" class="page-item"
                                :class="{ active: page === currentPage }">
                                <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                            </li>
                            <li class="page-item" :class="{ disabled: currentPage >= pageCount }">
                                <a class="page-link page-link-next" href="#" aria-label="Next"
                                    @click.prevent="goToPage(currentPage + 1)">
                                    Next<i class="d-icon-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

             <div class="shop-boxed-banner banner mb-8 mb-lg-7"
                        style="background-image: url('/images/demos/demo-market1/banner/shopbanner.jpg'); background-color: #ECEDEF;">
                        <div class="banner-content">
                            <h4 class="banner-subtitle font-weight-semi-bold ls-m text-uppercase text-secondary mb-3">
                                Winter Season's</h4>
                            <h1 class="banner-title font-weight-bold ls-m mb-6">Discover Our Ski Equipment</h1>
                            <a href="#" class="btn btn-dark btn-outline btn-rounded">Shop Now<i
                                    class="d-icon-arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- End Shop banner-->

        </main>
        <!-- End Main -->

        <footer class="footer">
            <div class="container">
                <div class="footer-top">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <NuxtLink to="/" class="logo-footer">
                                <img :src="siteLogoWide" :alt="siteName" width="153" height="44" />
                            </NuxtLink>
                            <!-- End FooterLogo -->
                        </div>
                        <div class="col-lg-4 widget-newsletter mb-4 mb-lg-0">
                            <h4 class="widget-title ls-m">Subscribe to our Newsletter</h4>
                            <p>Get all the latest information on Events, Sales and Offers.</p>
                        </div>
                        <div class="col-lg-5 widget-newsletter">
                            <form action="#" class="input-wrapper-inline mx-auto mx-lg-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email address here..." required />
                                <button class="btn btn-primary btn-rounded ml-2" type="submit">subscribe<i
                                        class="d-icon-arrow-right"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End FooterTop -->
                <div class="footer-middle">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="widget widget-info">
                                <h4 class="widget-title">Contact Info</h4>
                                <ul class="widget-body">
                                    <li>
                                        <label>Phone:</label>
                                        <a href="tel:#">Toll Free (123) 456-7890</a>
                                    </li>
                                    <li>
                                        <label>Email:</label>
                                        <a href="/cdn-cgi/l/email-protection#761b171f1a36041f1912135815191b"><span class="__cf_email__" data-cfemail="bdcfd4d2d9d8fdd0dcd4d193ded2d0">[email&#160;protected]</span></a>
                                    </li>
                                    <li>
                                        <label>Address:</label>
                                        <a href="#">123 Street, City, Country</a>
                                    </li>
                                    <li>
                                        <label>WORKING DAYS / HOURS:</label>
                                    </li>
                                    <li>
                                        <a href="#">Mon - Sun / 9:00 AM - 8:00 PM</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Widget -->
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>
                                <ul class="widget-body">
                                    <li>
                                        <NuxtLink to="/about-us">Track My Order</NuxtLink>
                                    </li>
                                    <li>
                                        <a href="#">View Cart</a>
                                    </li>
                                    <li>
                                        <a href="#">Sign in</a>
                                    </li>
                                    <li>
                                        <a href="#">My Wishlist</a>
                                    </li>
                                    <li>
                                        <a href="#">Privacy Policy</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Widget -->
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="widget">
                                <h4 class="widget-title">About Us</h4>
                                <ul class="widget-body">
                                    <li>
                                        <NuxtLink to="/about-us">About Us</NuxtLink>
                                    </li>
                                    <li>
                                        <a href="#">Order History</a>
                                    </li>
                                    <li>
                                        <a href="#">Returns</a>
                                    </li>
                                    <li>
                                        <a href="#">Custom Service</a>
                                    </li>
                                    <li>
                                        <a href="#">Terms &amp; Condition</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Widget -->
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4>
                                <ul class="widget-body">
                                    <li>
                                        <a href="#">Payment Methods</a>
                                    </li>
                                    <li>
                                        <a href="#">Money-back Guarantee!</a>
                                    </li>
                                    <li>
                                        <a href="#">Products Returns</a>
                                    </li>
                                    <li>
                                        <a href="#">Support Center</a>
                                    </li>
                                    <li>
                                        <a href="#">Shipping</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="widget widget-instagram pl-lg-10 mb-0 mb-md-6">
                                <h4 class="widget-title">Instagram</h4>
                                <figure class="widget-body row">
                                    <div class="col-3">
                                        <img src="/images/instagram/01.jpg" alt="instagram 1" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/02.jpg" alt="instagram 2" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/03.jpg" alt="instagram 3" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/04.jpg" alt="instagram 4" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/05.jpg" alt="instagram 5" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/06.jpg" alt="instagram 6" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/07.jpg" alt="instagram 7" width="64" height="64" />
                                    </div>
                                    <div class="col-3">
                                        <img src="/images/instagram/08.jpg" alt="instagram 8" width="64" height="64" />
                                    </div>
                                </figure>
                            </div>
                            <!-- End Instagram -->
                        </div>
                    </div>
                </div>
                <!-- End FooterMiddle -->
                <div class="footer-main">
                    <div class="widget widget-category">
                        <div v-for="category in footerCategories" :key="category.key" class="category-box">
                            <h6 class="category-name">{{ category.name }}:</h6>
                            <a v-for="subcategory in category.subcategories" :key="subcategory.slug || subcategory.id" href="#">
                                {{ subcategory.name }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="footer-left">
                        <figure class="payment">
                            <img src="/images/payment.png" alt="payment" width="159" height="29" />
                        </figure>
                    </div>
                    <div class="footer-center">
                        <p class="copyright">{{ siteName }} eCommerce &copy; 2021. All Rights Reserved</p>
                    </div>
                    <div class="footer-right">
                        <div class="social-links">
                            <a href="#" class="social-link social-facebook fab fa-facebook-f"></a>
                            <a href="#" class="social-link social-twitter fab fa-twitter"></a>
                            <a href="#" class="social-link social-linkedin fab fa-linkedin-in"></a>
                        </div>
                    </div>
                </div>
                <!-- End FooterBottom -->
            </div>
        </footer>
        <!-- End Footer -->
    </div>


    <!-- Sticky Footer -->
    <div class="sticky-footer sticky-content fix-bottom">
        <NuxtLink to="/" class="sticky-link">
            <i class="d-icon-home"></i>
            <span>Home</span>
        </NuxtLink>
        <NuxtLink to="/market-shop" class="sticky-link">
            <i class="d-icon-volume"></i>
            <span>Categories</span>
        </NuxtLink>
        <NuxtLink to="/wishlist" class="sticky-link">
            <i class="d-icon-heart"></i>
            <span>Wishlist</span>
        </NuxtLink>
        <NuxtLink to="/account" class="sticky-link">
            <i class="d-icon-user"></i>
            <span>Account</span>
        </NuxtLink>
        <div class="header-search hs-toggle dir-up">
            <a href="#" class="search-toggle sticky-link">
                <i class="d-icon-search"></i>
                <span>Search</span>
            </a>
            <form action="#" class="input-wrapper" @submit.prevent="submitSearch">
                <input v-model="searchInput" type="text" class="form-control" name="search" autocomplete="off"
                    placeholder="Search your keyword..." required />
                <button class="btn btn-search" type="submit">
                    <i class="d-icon-search"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- Scroll Top -->
    <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"><i class="d-icon-arrow-up"></i></a>

    <!-- MobileMenu -->
    <div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay">
        </div>
        <!-- End of Overlay -->
        <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>
        <!-- End of CloseButton -->
        <div class="mobile-menu-container scrollable">
            <form action="#" class="input-wrapper" @submit.prevent="submitSearch">
                <input v-model="searchInput" type="text" class="form-control" name="search" autocomplete="off"
                    placeholder="Search your keyword..." required />
                <button class="btn btn-search" type="submit">
                    <i class="d-icon-search"></i>
                </button>
            </form>
            <!-- End of Search Form -->
            <ul class="mobile-menu mmenu-anim">
                <li>
                    <NuxtLink to="/">Home</NuxtLink>
                </li>
                <li>
                    <NuxtLink to="/market-shop">Categories</NuxtLink>
                    <ul>
                        <li>
                            <a href="#">
                                Variations 1
                            </a>
                            <ul>
                                <li><a href="#">Classic Filter</a></li>
                                <li><a href="#">Left Toggle Filter</a></li>
                                <li><a href="#">Right Toggle Sidebar</a></li>
                                <li><a href="#">Horizontal Filter </a>
                                </li>
                                <li><a href="#">Navigation Filter</a></li>

                                <li><a href="#">Off-Canvas Filter </a></li>
                                <li><a href="#">Top Banner</a></li>
                                <li><a href="#">Inner Top Banner</a></li>
                                <li><a href="#">With Bottom Block</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                Variations 2
                            </a>
                            <ul>
                                <li><a href="#">3 Columns Mode</a></li>
                                <li><a href="#">4 Columns Mode</a></li>
                                <li><a href="#">5 Columns Mode</a></li>
                                <li><a href="#">6 Columns Mode</a></li>
                                <li><a href="#">7 Columns Mode</a></li>
                                <li><a href="#">8 Columns Mode</a></li>
                                <li><a href="#">List Mode</a></li>
                                <li><a href="#">Pagination</a></li>
                                <li><a href="#">Infinite Ajaxscroll </a></li>
                                <li><a href="#">Loadmore Button</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">
                                Variations 3
                            </a>
                            <ul>
                                <li><a href="#">Category Grid Shop</a></li>
                                <li><a href="#">Category + Products</a></li>
                                <li><a href="#">Shop Default 1 </a>
                                </li>
                                <li><a href="#">Shop Default 2</a></li>
                                <li><a href="#">Shop Default 3</a></li>
                                <li><a href="#">Shop Default 4</a></li>
                                <li><a href="#">Shop Default 5</a></li>
                                <li><a href="#">Shop Default 6</a></li>
                                <li><a href="#">Shop Default 7</a></li>
                                <li><a href="#">Shop Default 8</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Products</a>
                    <ul>
                        <li>
                            <a href="#">Product Pages</a>
                            <ul>
                                <li><a href="#">Simple Product</a></li>
                                <li><a href="#">Featured &amp; On Sale</a></li>
                                <li><NuxtLink to="/product">Variable Product</NuxtLink></li>
                                <li><a href="#">Variation Swatch
                                        Product</a></li>
                                <li><a href="#">Grouped Product </a></li>
                                <li><a href="#">External Product</a></li>
                                <li><a href="#">In Stock Product</a></li>
                                <li><a href="#">Out of Stock Product</a></li>
                                <li><a href="#">Upsell Products</a></li>
                                <li><a href="#">Cross Sell Products</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Product Layouts</a>
                            <ul>
                                <li><a href="#">Vertical Thumb</a></li>
                                <li><a href="#">Horizontal Thumb</a></li>
                                <li><a href="#">Gallery Type</a></li>
                                <li><a href="#">Grid Images</a></li>
                                <li><a href="#">Masonry Images</a></li>
                                <li><a href="#">Sticky Info</a></li>
                                <li><a href="#">Left & Right Sticky</a></li>
                                <li><a href="#">With Left Sidebar</a></li>
                                <li><a href="#">With Right Sidebar</a></li>
                                <li><a href="#">Full Width Layout </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Product Features</a>
                            <ul>
                                <li><a href="#">Sale Countdown</a></li>
                                <li><a href="#">Hurry Up Notification </a></li>
                                <li><a href="#">Attribute Guide </a></li>
                                <li><a href="#">Add Cart Sticky</a></li>
                                <li><a href="#">Labels on Thumbnail</a>
                                </li>
                                <li><a href="#">More Description
                                        Tabs</a></li>
                                <li><a href="#">Data In Accordion</a></li>
                                <li><a href="#">Data Inside</a></li>
                                <li><a href="#">Video Thumbnail </a>
                                </li>
                                <li><a href="#">360 Degree Thumbnail </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Pages</a>
                    <ul>
                        <li><NuxtLink to="/about-us">About</NuxtLink></li>
                        <li><NuxtLink to="/contact-us">Contact Us</NuxtLink></li>
                        <li><NuxtLink to="/account">Login</NuxtLink></li>
                        <li><NuxtLink to="/faq">FAQs</NuxtLink></li>
                        <li><NuxtLink to="/error-404">Error 404</NuxtLink>
                            <ul>
                                <li><NuxtLink to="/error-404">Error 404-1</NuxtLink></li>
                                <li><a href="#">Error 404-2</a></li>
                                <li><a href="#">Error 404-3</a></li>
                                <li><a href="#">Error 404-4</a></li>
                            </ul>
                        </li>
                        <li><NuxtLink to="/coming-soon">Coming Soon</NuxtLink></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Blog</a>
                    <ul>
                        <li><a href="#">Classic</a></li>
                        <li><a href="#">Listing</a></li>
                        <li>
                            <a href="#">Grid</a>
                            <ul>
                                <li><a href="#">Grid 2 columns</a></li>
                                <li><a href="#">Grid 3 columns</a></li>
                                <li><a href="#">Grid 4 columns</a></li>
                                <li><a href="#">Grid sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Masonry</a>
                            <ul>
                                <li><a href="#">Masonry 2 columns</a></li>
                                <li><a href="#">Masonry 3 columns</a></li>
                                <li><a href="#">Masonry 4 columns</a></li>
                                <li><a href="#">Masonry sidebar</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Mask</a>
                            <ul>
                                <li><a href="#">Blog mask grid</a></li>
                                <li><a href="#">Blog mask masonry</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Single Post</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Elements</a>
                    <ul>
                        <li>
                            <a href="#">Elements 1</a>
                            <ul>
                                <li><a href="#">Accordions</a></li>
                                <li><a href="#">Alert &amp; Notification</a></li>

                                <li><a href="#">Banner Effect

                                    </a></li>
                                <li><a href="#">Banner
                                    </a></li>
                                <li><a href="#">Blog Posts</a></li>
                                <li><a href="#">Breadcrumb
                                    </a></li>
                                <li><a href="#">Buttons</a></li>
                                <li><a href="#">Call to Action</a></li>
                                <li><a href="#">Countdown
                                    </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Elements 2</a>
                            <ul>
                                <li><a href="#">Counter </a></li>
                                <li><a href="#">Creative Grid

                                    </a></li>
                                <li><a href="#">Entrance Effect

                                    </a></li>
                                <li><a href="#">Floating

                                    </a></li>
                                <li><a href="#">Hotspot

                                    </a></li>
                                <li><a href="#">Icon Boxes</a></li>
                                <li><a href="#">Icons</a></li>
                                <li><a href="#">Image box

                                    </a></li>
                                <li><a href="#">Instagrams</a></li>

                            </ul>
                        </li>
                        <li>
                            <a href="#">Elements 3</a>
                            <ul>

                                <li><a href="#">Product Category</a></li>
                                <li><a href="#">Products</a></li>
                                <li><a href="#">Products + Banner

                                    </a></li>
                                <li><a href="#">Products + Grid

                                    </a></li>
                                <li><a href="#">Product Single

                                    </a>
                                </li>
                                <li><a href="#">Products + Tab

                                    </a></li>
                                <li><a href="#">Single Product

                                    </a></li>
                                <li><a href="#">Slider

                                    </a></li>
                                <li><a href="#">Social Icons </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Elements 4</a>
                            <ul>
                                <li><a href="#">Subcategory

                                    </a></li>
                                <li><a href="#">Svg Floating

                                    </a></li>
                                <li><a href="#">Tabs</a></li>
                                <li><a href="#">Testimonials
                                    </a></li>
                                <li><a href="#">Title</a></li>
                                <li><a href="#">Typography</a></li>
                                <li><a href="#">Vendor

                                    </a></li>
                                <li><a href="#">Video

                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="https://1.envato.market/DdLk5">Buy {{ siteName }}!</a></li>
            </ul>
        </div>
    </div>
    <!-- sticky icons-->
	<div class="sticky-icons-wrapper">
		<div class="sticky-icon-links">
			<ul>
				<li><a href="#" class="demo-toggle"><i class="fas fa-home"></i><span>Demos</span></a></li>
				<li><a href="#"><i class="fas fa-info-circle"></i><span>Documentation</span></a>
				</li>
				<li><a href="https://themeforest.net/downloads/"><i class="fas fa-star"></i><span>Reviews</span></a>
				</li>
				<li><a href="https://d-themes.com/buynow/riodehtml"><i class="fas fa-shopping-cart"></i><span>Buy
							now!</span></a></li>
			</ul>
		</div>
		<div class="demos-list">
			<div class="demos-overlay"></div>
			<a class="demos-close" href="#"><i class="close-icon"></i></a>
			<div class="demos-content scrollable scrollable-light">
				<h3 class="demos-title">Demos</h3>
				<div class="demos">
				</div>
			</div>
		</div>
	</div>
	<!-- Plugins JS File -->
    
    
    
    
    
    
    
    
    <!-- Main JS File -->
    


  </div>
</template>

<script setup>
const { cart, cartCount, cartSubtotal, removeItem } = useCart()
const { categories } = useCategories()
const { settings } = useSiteSettings()

const siteName = computed(() => settings.value.site_name || 'Riode')
const siteLogoWide = computed(
  () =>
    settings.value.site_logo_wide_url ||
    settings.value.site_logo_url ||
    '/images/demos/demo-market1/logo.png'
)

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}

const categoryMenuIcons = [
  'd-icon-desktop',
  'd-icon-handbag',
  'd-icon-t-shirt2',
  'd-icon-camera2',
  'd-icon-gamepad2',
  'd-icon-officebag',
  'd-icon-mobile',
  'd-icon-bridge-lamp',
  'd-icon-headphone',
  'd-icon-memory',
  'd-icon-cook'
]

const categoryMenuItems = computed(() => {
  const items = categories.value.slice(0, categoryMenuIcons.length).map((category, index) => ({
    ...category,
    icon: categoryMenuIcons[index],
    iconUrl: category.icon_url ?? null,
    key: category.slug || String(category.id)
  }))

  items.push({
    id: -1,
    name: 'All Categories',
    slug: 'all',
    icon: 'd-icon-category',
    iconUrl: null,
    key: 'all'
  })

  return items
})

const shopCategoryIcons = computed(() => {
  const iconMap = [
    { icon: 'd-icon-t-shirt1', contentClass: 'category-content' },
    { icon: 'd-icon-sofa', contentClass: 'category-content' },
    { icon: 'd-icon-basketball1', contentClass: 'category-content' },
    { icon: 'd-icon-babycare', contentClass: 'category-babycare' },
    { icon: 'd-icon-camera1', contentClass: 'category-content' },
    { icon: 'd-icon-gamepad1', contentClass: 'category-babycare' },
    { icon: 'd-icon-headphone', contentClass: 'category-content' },
    { icon: 'd-icon-mobile', contentClass: 'category-content' }
  ]

  return categories.value.slice(0, iconMap.length).map((category, index) => ({
    ...category,
    ...iconMap[index],
    iconUrl: category.icon_url ?? null,
    key: category.slug || String(category.id)
  }))
})

const footerCategories = computed(() =>
  categories.value.slice(0, 6).map((category) => ({
    ...category,
    key: category.slug || String(category.id),
    subcategories: (category.subcategories ?? []).slice(0, 12)
  }))
)

const route = useRoute()
const router = useRouter()

const parseQueryString = (value) => {
  if (Array.isArray(value)) return value[0] || ''
  return value ? String(value) : ''
}

const parseNumber = (value) => {
  const parsed = Number(value)
  return Number.isFinite(parsed) ? parsed : null
}

const parseList = (value) => {
  if (Array.isArray(value)) return value.map((item) => String(item).trim()).filter(Boolean)
  if (!value) return []
  return String(value)
    .split(',')
    .map((item) => item.trim())
    .filter(Boolean)
}

const categoryId = computed(() => {
  const direct = parseNumber(route.query.category_id)
  if (direct) return direct

  const slug = parseQueryString(route.query.category)
  if (!slug) return null
  return categories.value.find((item) => item.slug === slug)?.id ?? null
})

const subCategoryId = computed(() => {
  const direct = parseNumber(route.query.sub_category_id)
  if (direct) return direct

  const slug = parseQueryString(route.query.subcategory)
  if (!slug) return null
  const found = categories.value
    .flatMap((category) => category.subcategories ?? [])
    .find((subcategory) => subcategory.slug === slug)
  return found?.id ?? null
})

const vendorId = computed(() => {
  const direct = parseNumber(route.query.vendor_id)
  if (direct) return direct
  return parseNumber(route.query.vendor)
})

const searchTerm = computed(() => parseQueryString(route.query.search))
const searchInput = ref('')
const searchCategory = ref('all-cat')
const selectedColors = computed(() => parseList(route.query.colors))
const selectedSizes = computed(() => parseList(route.query.sizes))
const selectedPlans = computed(() => parseList(route.query.plans))
const currentPage = computed(() => parseNumber(route.query.page) || 1)
const minPrice = computed(() => parseNumber(route.query.min_price))
const maxPrice = computed(() => parseNumber(route.query.max_price))

watch(
  searchTerm,
  (value) => {
    searchInput.value = value || ''
  },
  { immediate: true }
)

watch(
  [() => route.query.category, categoryId, categories],
  () => {
    const slug = parseQueryString(route.query.category)
    if (slug) {
      searchCategory.value = slug
      return
    }
    if (categoryId.value) {
      const found = categories.value.find((item) => item.id === categoryId.value)
      searchCategory.value = found?.slug || 'all-cat'
      return
    }
    searchCategory.value = 'all-cat'
  },
  { immediate: true }
)

const sort = computed({
  get: () => parseQueryString(route.query.sort) || 'default',
  set: (value) => {
    const next = value && value !== 'default' ? value : undefined
    updateQuery({ sort: next, page: 1 })
  }
})

const perPage = computed({
  get: () => parseNumber(route.query.per_page) || 15,
  set: (value) => {
    updateQuery({ per_page: value, page: 1 })
  }
})

const filters = computed(() => ({
  page: currentPage.value,
  per_page: perPage.value,
  category_id: categoryId.value ?? undefined,
  sub_category_id: subCategoryId.value ?? undefined,
  vendor_id: vendorId.value ?? undefined,
  search: searchTerm.value || undefined,
  min_price: minPrice.value ?? undefined,
  max_price: maxPrice.value ?? undefined,
  colors: selectedColors.value,
  sizes: selectedSizes.value,
  plans: selectedPlans.value,
  sort: sort.value !== 'default' ? sort.value : undefined
}))

const { data: productData, pending: productsPending } = useProductSearch(filters)
const products = computed(() => productData.value.items ?? [])
const total = computed(() => Number(productData.value.total ?? 0))
const pageCount = computed(() => Math.max(1, Math.ceil(total.value / perPage.value)))
const showingFrom = computed(() =>
  total.value === 0 ? 0 : (currentPage.value - 1) * perPage.value + 1
)
const showingTo = computed(() => Math.min(total.value, currentPage.value * perPage.value))

const perPageOptions = [10, 15, 20, 30]

const priceRanges = [
  { label: 'All Prices', min: null, max: null },
  { label: '$0.00 - $50.00', min: 0, max: 50 },
  { label: '$50.00 - $100.00', min: 50, max: 100 },
  { label: '$100.00 - $200.00', min: 100, max: 200 },
  { label: '$200.00+', min: 200, max: null }
]

const availableColors = computed(() => {
  const unique = new Set()
  products.value.forEach((product) => (product.colors ?? []).forEach((color) => unique.add(color)))
  return unique.size ? Array.from(unique) : ['Black', 'Blue', 'Brown', 'Green']
})

const availableSizes = computed(() => {
  const unique = new Set()
  products.value.forEach((product) => (product.sizes ?? []).forEach((size) => unique.add(size)))
  return unique.size ? Array.from(unique) : ['Extra Large', 'Large', 'Medium', 'Small']
})

const availablePlans = computed(() => {
  const unique = new Set()
  products.value.forEach((product) => (product.plans ?? []).forEach((plan) => unique.add(plan)))
  return Array.from(unique)
})

const paginationPages = computed(() => {
  const totalPages = pageCount.value
  const current = currentPage.value
  const pages = new Set([1, totalPages, current - 1, current, current + 1])
  return Array.from(pages)
    .filter((page) => page >= 1 && page <= totalPages)
    .sort((a, b) => a - b)
})

const updateQuery = (changes) => {
  const next = { ...route.query, ...changes }
  Object.keys(next).forEach((key) => {
    const value = next[key]
    if (value === undefined || value === null || value === '') {
      delete next[key]
    }
  })
  router.push({ query: next })
}

const submitSearch = () => {
  const term = searchInput.value.trim()
  const category = searchCategory.value !== 'all-cat' ? searchCategory.value : undefined
  updateQuery({
    search: term || undefined,
    category,
    category_id: category ? undefined : route.query.category_id,
    sub_category_id: category ? undefined : route.query.sub_category_id,
    page: 1
  })
}

const toggleListFilter = (key, value) => {
  const current =
    key === 'colors'
      ? selectedColors.value
      : key === 'sizes'
      ? selectedSizes.value
      : selectedPlans.value
  const exists = current.includes(value)
  const next = exists ? current.filter((item) => item !== value) : [...current, value]
  updateQuery({ [key]: next.length ? next.join(',') : undefined, page: 1 })
}

const applyPriceRange = (range) => {
  updateQuery({
    min_price: range.min ?? undefined,
    max_price: range.max ?? undefined,
    page: 1
  })
}

const isPriceRangeSelected = (range) => {
  const currentMin = minPrice.value ?? null
  const currentMax = maxPrice.value ?? null
  return currentMin === (range.min ?? null) && currentMax === (range.max ?? null)
}

const clearFilters = () => {
  updateQuery({
    colors: undefined,
    sizes: undefined,
    plans: undefined,
    min_price: undefined,
    max_price: undefined,
    sort: undefined,
    page: 1
  })
}

const goToPage = (page) => {
  const nextPage = Math.min(Math.max(1, page), pageCount.value)
  if (nextPage === currentPage.value) return
  updateQuery({ page: nextPage })
}

const categoryLink = (item) => {
  if (!item?.slug || item.slug === 'all') {
    return '/market-shop'
  }
  return { path: '/market-shop', query: { category: item.slug } }
}

useHead({
  bodyAttrs: { class: 'market1-shop market' }
})
definePageMeta({
  alias: ['/market-shop']
})
</script>

<style scoped>
:deep(.product-wrapper .product-media) {
  width: 238px;
  height: 267px;
}

:deep(.product-wrapper .product-media img) {
  width: 238px;
  height: 267px;
  object-fit: cover;
}
</style>











