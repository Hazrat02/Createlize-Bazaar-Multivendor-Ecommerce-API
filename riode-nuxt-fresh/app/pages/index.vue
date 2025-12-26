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
                                <button class="btn btn-search" type="submit" title="submit-button">
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
                                    <a href="/cdn-cgi/l/email-protection#7002191f1415301d11191c5e131f1d"
                                        class="text-primary d-inline-block">Live chat</a>
                                    or:
                                </h4>
                                <p><a href="tel:#">0(800) 123-456</a></p>
                            </div>
                        </div>
                        <span class="divider mr-4"></span>
                        <div class="dropdown compare-dropdown off-canvas mr-xl-7 mr-4">
                            <a href="#" class="compare compare-toggle mr-0" title="compare">
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
                                            <NuxtLink to="/product" class="product-name">Dark Blue Women?s
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
                            <NuxtLink to="/wishlist" class="wishlist-toggle" title="wishlist">
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

            <div class="header-bottom">
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
            <section class="intro-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mb-4">
                            <div class="owl-carousel owl-theme owl-dot-inner row gutter-no cols-1 animation-slider"
                                data-owl-options="{
                                'nav': false,
                                'dots': true,
                                'autoplay': false,
                                'items': 1
                            }">
                                <div class="banner banner-fixed content-middle intro-slide intro-slide1 banner-radius">
                                    <figure>
                                        <img src="/images/demos/demo-market1/slides/1.jpg" alt="Banner" width="1030"
                                            height="450" style="background-color: #fefefe;" />
                                    </figure>
                                    <div class="banner-content">
                                        <div class="slide-animate" data-animation-options="{
                                            'name': 'fadeInLeftShorter', 'duration': '1s'
                                        }">
                                            <h5 class="banner-subtitle text-capitalize font-weight-normal">Lifestyle
                                                Collection</h5>
                                            <h3 class="banner-title text-uppercase font-weight-bold ls-m">for Ski
                                                Clothes</h3>
                                            <div
                                                class="banner-price-info font-weight-semi-bold text-body text-uppercase ls-m">
                                                Sale Up To <span class="text-primary">30% Off</span>
                                            </div>
                                            <NuxtLink to="/market-shop" class="btn btn-dark btn-outline btn-rounded">
                                                Shop Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner banner-fixed content-middle intro-slide intro-slide2 banner-radius">
                                    <figure>
                                        <img src="/images/demos/demo-market1/slides/2.jpg" alt="Banner" width="1030"
                                            height="450" style="background-color: #e2e2e3;" />
                                    </figure>
                                    <div class="banner-content text-right">
                                        <div class="slide-animate" data-animation-options="{
                                            'name': 'fadeInRightShorter', 'duration': '1s'
                                        }">
                                            <h5 class="banner-subtitle text-capitalize font-weight-normal">Find Your
                                                Trending</h5>
                                            <h3 class="banner-title text-uppercase font-weight-bold ls-m">Autumn style
                                            </h3>
                                            <div
                                                class="banner-price-info font-weight-semi-bold text-dark text-uppercase ls-m">
                                                Get Up To <span class="text-primary">20% Off</span>
                                            </div>
                                            <p class="text-dark font-weight-normal">* Only until the end of this week
                                            </p>
                                            <NuxtLink to="/market-shop" class="btn btn-dark btn-outline btn-rounded">
                                                Shop Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                        </div>
                                    </div>
                                </div>
                                <div class="banner banner-fixed content-middle intro-slide intro-slide3 banner-radius">
                                    <figure>
                                        <img src="/images/demos/demo-market1/slides/3.jpg" alt="Banner" width="1030"
                                            height="450" style="background-color: #d8dee4;" />
                                    </figure>
                                    <div class="banner-content">
                                        <div class="slide-animate" data-animation-options="{
                                            'name': 'fadeInLeftShorter', 'duration': '1s'
                                        }">
                                            <h5 class="banner-subtitle text-capitalize font-weight-normal mb-1">
                                                Must-Haves</h5>
                                            <h3 class="banner-title text-uppercase font-weight-bold ls-m">for the season
                                            </h3>
                                            <div
                                                class="banner-price-info font-weight-semi-bold text-dark text-uppercase ls-m">
                                                Start At <span class="text-primary">$230.00</span>
                                            </div>
                                            <p class="text-dark font-weight-normal">* Get Plus Discount Buying Fashion
                                            </p>
                                            <NuxtLink to="/market-shop" class="btn btn-dark btn-outline btn-rounded">
                                                Shop Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="row cols-lg-1 cols-sm-2 cols-1">
                                <div class="intro-banner mb-4">
                                    <div class="banner banner-fixed content-middle banner-radius overlay-zoom">
                                        <figure>
                                            <img src="/images/demos/demo-market1/banner/1.jpg" alt="Intro Banner"
                                                width="330" height="215" style="background-color: #232323;" />
                                        </figure>
                                        <div class="banner-content">
                                            <h3 class="banner-title font-weight-bold text-white ls-m">Electronics</h3>
                                            <div class="product-count text-uppercase text-white font-weight-semi-bold">6
                                                Products</div>
                                            <span class="divider bg-white"></span>
                                            <NuxtLink to="/market-shop" class="btn btn-white btn-link btn-underline ls-m">
                                                Shop Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-banner mb-4">
                                    <div class="banner banner-fixed content-middle banner-radius overlay-zoom">
                                        <figure>
                                            <img src="/images/demos/demo-market1/banner/2.jpg" alt="Intro Banner"
                                                width="330" height="215" style="background-color: #eca5a9;" />
                                        </figure>
                                        <div class="banner-content">
                                            <h3 class="banner-title font-weight-bold text-white ls-m">Accessories</h3>
                                            <div class="product-count text-uppercase text-white font-weight-semi-bold">3
                                                Products</div>
                                            <span class="divider bg-white"></span>
                                            <NuxtLink to="/market-shop" class="btn btn-white btn-link btn-underline ls-m">
                                                Shop Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="service-wrapper mt-2 mb-10">
                        <div class="owl-carousel owl-theme row cols-lg-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                            'nav': false,
                            'dots': false,
                            'responsive': {
                                '0': {
                                    'items': 1
                                },
                                '576': {
                                    'items': 2
                                },
                                '992': {
                                    'items': 3
                                },
                                '1306': {
                                    'items': 4
                                }
                            }
                        }">
                            <div class="icon-box icon-box-side icon-box1">
                                <i class="icon-box-icon d-icon-truck"></i>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize lh-1">Free Shipping &amp;
                                        Return
                                    </h4>
                                    <p class="lh-1">Free shipping on orders over $99</p>
                                </div>
                            </div>

                            <div class="icon-box icon-box-side icon-box2">
                                <i class="icon-box-icon d-icon-service"></i>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize lh-1">Customer Support 24/7
                                    </h4>
                                    <p class="lh-1">Instant access to perfect support</p>
                                </div>
                            </div>

                            <div class="icon-box icon-box-side icon-box3">
                                <i class="icon-box-icon d-icon-secure"></i>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize lh-1">100% Secured Payment
                                    </h4>
                                    <p class="lh-1">We ensure secure payment!</p>
                                </div>
                            </div>

                            <div class="icon-box icon-box-side icon-box4">
                                <i class="icon-box-icon d-icon-money"></i>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize lh-1">Money Back Guarantee
                                    </h4>
                                    <p class="lh-1">Any back within 30 days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="product-deals-wrapper mb-10 pb-6">
                <div class="container">
                    <h2 class="title title-line title-underline with-link">
                        Deals Of The Day
                        <NuxtLink to="/market-shop" class="btn btn-dark btn-link text-capitalize font-weight-semi-bold btn-more">More Products<i
                                class="d-icon-arrow-right"></i></NuxtLink>
                    </h2>
                    <div class="row grid-type">
                        <div class="product-single-wrap">
                            <div class="product product-single">
                                <div class="row product-gallery align-items-center mb-0">
                                    <div class="col-md-6 p-relative mb-4 mb-md-0">
                                        <div class="">
                                            <figure class="product-image">
                                                <img :src="dealMain.image" :data-zoom-image="dealMain.image"
                                                    :alt="dealMain.name" width="800" height="900">
                                            </figure>
                                        </div>
                                        <div class="countdown-container d-flex align-items-center font-weight-semi-bold 
                                            text-white x-50 w-100 justify-content-center flex-wrap">
                                            <label class="text-white text-capitalize mr-1">Off Ends In:</label>
                                            <div class="product-countdown countdown-compact" data-format="DHMS"
                                                data-until="+10d" data-relative="true" data-compact="true">00:00:00
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="product-details pb-0 pl-0">
                                            <h2 class="product-name font-weight-semi-bold">
                                                <NuxtLink :to="`/product/${dealMain.slug}`">{{ dealMain.name }}</NuxtLink>
                                            </h2>
                                            <div class="product-price mb-2">
                                                <span class="price">{{ formatPrice(dealMain.price) }}</span>
                                                <del v-if="dealMain.oldPrice" class="old-price pl-1">{{
                                                    formatPrice(dealMain.oldPrice)
                                                }}</del>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings"
                                                        :style="{ width: `${dealMain.ratingPercent}%` }"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="#product-tab-reviews" class="link-to-tab rating-reviews">(
                                                    {{ dealMain.reviewCount }} reviews )</a>
                                            </div>
                                            <div class="product-form product-color">
                                                <label>Screen Size:</label>
                                                <div class="product-form-group">
                                                    <div class="product-variations">
                                                        <a class="size" href="#">24 Inch</a>
                                                        <a class="size" href="#">52 Inch</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-form product-size">
                                                <label>Resolution:</label>
                                                <div class="product-form-group">
                                                    <div class="product-variations">
                                                        <a class="button" href="#">HD</a>
                                                        <a class="button" href="#">HD 1080</a>
                                                        <a class="button" href="#">HD 720</a>
                                                        <a class="button" href="#">WSXGA</a>
                                                        <a class="button" href="#">WXGA</a>
                                                    </div>
                                                    <a href="#" class="product-variation-clean">Clean All</a>
                                                </div>
                                            </div>
                                            <div class="product-variation-price">
                                                <span>$239.00</span>
                                            </div>
                                            <div class="product-form product-qty mb-0">
                                                <div class="product-form-group">
                                                    <div class="input-group mr-2 mb-0">
                                                        <button class="quantity-minus d-icon-minus"
                                                            title="quantity"></button>
                                                        <input class="quantity form-control" type="number" min="1"
                                                            max="1000000" title="quantity">
                                                        <button class="quantity-plus d-icon-plus"
                                                            title="quantity"></button>
                                                    </div>
                                                    <button class="btn-product btn-cart text-normal ls-normal font-weight-semi-bold mb-0"
                                                        @click.prevent="addToCart(dealMain)"><i
                                                            class="d-icon-bag"></i>Add to
                                                        Cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-wrap" v-for="product in dealList" :key="product.id">
                            <div class="product product-list-sm">
                                <NuxtLink :to="`/product/${product.slug}`" class="product-media">
                                    <figure>
                                        <img :src="product.image" :alt="product.name" width="165" height="184">
                                    </figure>
                                </NuxtLink>
                                <div class="product-details">
                                    <h3 class="product-name">
                                        <NuxtLink :to="`/product/${product.slug}`">{{ product.name }}</NuxtLink>
                                    </h3>
                                    <div class="product-price">
                                        <ins v-if="product.oldPrice" class="new-price">{{ formatPrice(product.price)
                                            }}</ins>
                                        <del v-if="product.oldPrice" class="old-price">{{ formatPrice(product.oldPrice)
                                            }}</del>
                                        <span v-else class="price">{{ formatPrice(product.price) }}</span>
                                    </div>
                                    <div class="ratings-container">
                                        <div class="ratings-full">
                                            <span class="ratings"
                                                :style="{ width: `${product.ratingPercent}%` }"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                        <a href="#" class="rating-reviews">( {{ product.reviewCount }} reviews )</a>
                                    </div>
                                    <div class="count-text">Only <strong>{{ 100 + product.id }}</strong> Left</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="grey-section pt-8 pb-4">
                <div class="container">
                    <div class="row cols-xl-5 cols-lg-4 cols-md-3 cols-sm-2 cols-1">
                        <div v-for="item in ellipseCategories" :key="item.key" class="category category-ellipse mb-4">
                            <figure class="category-media mr-2">
                                <NuxtLink :to="categoryLink(item)">
                                    <img :src="item.imageUrl" :alt="item.name" width="100" height="100">
                                </NuxtLink>
                            </figure>
                            <div class="category-content pt-0 text-left">
                                <h4 class="category-name font-weight-normal ls-s">
                                    <NuxtLink :to="categoryLink(item)">{{ item.name }}</NuxtLink>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="category-wrapper mt-10 pt-6 mb-10 pb-8">
                <div class="container">
                    <div class="owl-carousel owl-theme row cols-lg-3 cols-md-2 cols-1" data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '576': {
                                'items': 1
                            },
                            '768': {
                                'items': 2
                            },
                            '992': {
                                'items': 3,
                                'dots': false
                            }
                        }
                    }">
                        <div class="banner banner-fixed category-banner1 content-middle banner-radius">
                            <figure>
                                <img src="/images/demos/demo-market1/category/11.png" alt="Category Banner" width="446"
                                    height="180" style="background-color: #e2e2e2;" />
                            </figure>
                            <div class="banner-content">
                                <h4 class="banner-subtitle font-weight-semi-bold text-uppercase ls-s">New Collection
                                </h4>
                                <h3 class="banner-title font-weight-normal ls-m">Get up to <strong
                                        class="text-uppercase">20% Off</strong></h3>
                                <span class="divider bg-dark"></span>
                                <NuxtLink to="/market-shop" class="btn btn-dark btn-link btn-underline">Shop Now<i
                                        class="d-icon-arrow-right"></i></NuxtLink>
                            </div>
                        </div>
                        <div class="banner banner-fixed category-banner2 content-middle banner-radius">
                            <figure>
                                <img src="/images/demos/demo-market1/category/12.png" alt="Category Banner" width="446"
                                    height="180" style="background-color: #373a3e;" />
                            </figure>
                            <div class="banner-content">
                                <h4 class="banner-subtitle text-white font-weight-semi-bold text-uppercase ls-s">
                                    Trending seller</h4>
                                <h3 class="banner-title text-white font-weight-normal ls-m">Fingerprints <strong
                                        class="text-uppercase">Padlock</strong></h3>
                                <span class="divider bg-white"></span>
                                <NuxtLink to="/market-shop" class="btn btn-white btn-link btn-underline">Discover<i
                                        class="d-icon-arrow-right"></i></NuxtLink>
                            </div>
                        </div>
                        <div class="banner banner-fixed category-banner1 content-middle banner-radius">
                            <figure>
                                <img src="/images/demos/demo-market1/category/13.png" alt="Category Banner" width="446"
                                    height="180" style="background-color: #d7d6d3;" />
                            </figure>
                            <div class="banner-content">
                                <h4 class="banner-subtitle font-weight-semi-bold text-uppercase ls-s">New Arrivals</h4>
                                <h3 class="banner-title font-weight-normal ls-m">SmartWatch <strong
                                        class="text-uppercase">Deals</strong></h3>
                                <span class="divider bg-dark"></span>
                                <NuxtLink to="/market-shop" class="btn btn-dark btn-link btn-underline">Shop Now<i
                                        class="d-icon-arrow-right"></i></NuxtLink>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-10 pb-7">
                <div class="container">
                    <h2 class="title title-line title-underline">Top Weekly Vendors</h2>
                    <div class="owl-carousel owl-theme row cols-xl-4 cols-lg-3 cols-md-2 cols-1" data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '576': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 3
                            },
                            '1200': {
                                'items': 4,
                                'dots': false
                            }
                        }
                    }">
                        <div v-for="vendor in topVendors" :key="vendor.id" class="vendor-widget">
                            <div class="vendor-details">
                                <figure class="vendor-logo">
                                    <NuxtLink :to="vendorLink(vendor)">
                                        <img style="width: 40px;" :src="vendor.logo_url || vendorFallbackLogo" alt="Vendor logo" width="70"
                                            height="70" />
                                    </NuxtLink>
                                </figure>
                                <div class="vendor-personal">
                                    <h4 class="vendor-name">
                                        <NuxtLink :to="vendorLink(vendor)">{{ vendor.store_name || vendor.name }}</NuxtLink>
                                        <span class="vendor-products-count">( {{ vendor.product_count }} Products )</span>
                                    </h4>
                                    <div class="ratings-container mb-0">
                                        <div class="ratings-full">
                                            <span class="ratings" style="width:100%"></span>
                                            <span class="tooltiptext tooltip-top"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="vendor-products grid-type gutter-xs">
                                <div v-for="(product, index) in vendor.top_products" :key="product.id"
                                    class="vendor-product">
                                    <figure class="product-media">
                                        <NuxtLink :to="`/product/${product.slug}`">
                                            <img :src="product.image_url || vendorFallbackProduct" :alt="product.name"
                                                :width="index === 0 ? 217 : 108" :height="index === 0 ? 245 : 120" />
                                        </NuxtLink>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-10 pb-6">
                <div class="container">
                    <h2 class="title title-line title-underline with-link">
                        Consumer Electric
                        <NuxtLink to="/market-shop" class="btn btn-dark btn-link font-weight-semi-bold text-capitalize btn-more">More Products<i
                                class="d-icon-arrow-right"></i></NuxtLink>
                    </h2>
                    <div class="product-wrapper products-grid row">
                        <div class="banner-wrapper">
                            <div class="banner banner-fixed content-top banner-radius" style="background-image: url(/images/demos/demo-market1/banner/3.jpg);
                            background-color: #313131;">
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-white text-uppercase">New Collection</h4>
                                    <h3 class="banner-title text-white font-weight-bold ls-m">Electronic Deals</h3>
                                    <div class="banner-price-info text-white font-weight-semi-bold ls-m">
                                        Starting at<strong class="text-secondary">$350.00</strong>
                                    </div>
                                    <NuxtLink to="/market-shop" class="btn btn-white btn-outline btn-rounded">Shop Now<i
                                            class="d-icon-arrow-right"></i></NuxtLink>
                                </div>
                            </div>
                        </div>
                        <div class="product text-center" v-for="product in gridAProducts" :key="product.id">
                            <figure class="product-media">
                                <NuxtLink :to="`/product/${product.slug}`">
                                    <img :src="product.image" :alt="product.name" width="238" height="267" />
                                </NuxtLink>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" @click.prevent="addToCart(product)" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                            class="d-icon-heart"></i></a>
                                    <a href="#" class="btn-product-icon btn-quickview" title="Quick View"><i
                                            class="d-icon-search"></i></a>
                                    <a href="#" class="btn-product-icon btn-compare" data-toggle="modal"
                                        data-target="#addCompareModal" title="Compare"><i
                                            class="d-icon-compare"></i></a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <h4 class="product-name">
                                    <NuxtLink :to="`/product/${product.slug}`">{{ product.name }}</NuxtLink>
                                </h4>
                                <div class="product-price">
                                    <ins v-if="product.oldPrice" class="new-price">{{ formatPrice(product.price)
                                        }}</ins>
                                    <del v-if="product.oldPrice" class="old-price">{{ formatPrice(product.oldPrice)
                                        }}</del>
                                    <span v-else class="price">{{ formatPrice(product.price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="category-grid mb-10 pb-3">
                <div class="container">
                    <div class="row cols-md-2 cols-1">
                        <div class="banner-wrap mb-4">
                            <div class="banner banner-fixed content-middle text-right banner-radius">
                                <figure>
                                    <img src="/images/demos/demo-market1/category/14.jpg" alt="Category Banner"
                                        width="680" height="240" style="background-color: #e1e2e2;" />
                                </figure>
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-uppercase text-body ls-s">Best Seller</h4>
                                    <h3 class="banner-title font-weight-bold ls-m">Wireless Speaker &amp;<br>
                                        <span class="font-weight-normal text-uppercase">Smartphone</span>
                                    </h3>
                                    <div class="banner-price-info font-weight-semi-bold text-body ls-m">
                                        Starting at<strong class="font-weight-bold text-secondary">$190.00</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="banner-wrap mb-4">
                            <div class="banner banner-fixed content-middle banner-radius">
                                <figure>
                                    <img src="/images/demos/demo-market1/category/15.jpg" alt="Category Banner"
                                        width="680" height="240" style="background-color: #2a292d;" />
                                </figure>
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-uppercase text-white ls-s">New Arrivals</h4>
                                    <h3 class="banner-title font-weight-bold text-white ls-m">Highly Recommend<br>
                                        <span class="font-weight-normal text-uppercase">Lifestyle Shoes</span>
                                    </h3>
                                    <div class="banner-price-info font-weight-semi-bold text-white ls-m">
                                        From<strong class="font-weight-bold text-secondary">$70.00</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-10 pb-6">
                <div class="container">
                    <h2 class="title title-line title-underline with-link">
                        Clothing &amp; Apparel
                        <NuxtLink to="/market-shop" class="btn btn-dark btn-link font-weight-semi-bold text-capitalize btn-more">More Products<i
                                class="d-icon-arrow-right"></i></NuxtLink>
                    </h2>
                    <div class="product-wrapper products-grid row">
                        <div class="banner-wrapper">
                            <div class="banner banner-fixed content-bottom banner-radius" style="background-image: url(/images/demos/demo-market1/banner/4.jpg);
                            background-color: #61615e;">
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-white text-uppercase">Special Event</h4>
                                    <h3 class="banner-title text-white font-weight-bold ls-m">Mid Season Sale</h3>
                                    <div class="banner-price-info text-white font-weight-semi-bold ls-m">
                                        Sale up to<strong class="text-secondary">20% Off</strong>
                                    </div>
                                    <NuxtLink to="/market-shop" class="btn btn-white btn-outline btn-rounded">Shop Now<i
                                            class="d-icon-arrow-right"></i></NuxtLink>
                                </div>
                            </div>
                        </div>
                                                <div class="product text-center" v-for="product in gridBProducts" :key="product.id">
                            <figure class="product-media">
                                <NuxtLink :to="`/product/${product.slug}`">
                                    <img :src="product.image" :alt="product.name" width="238" height="267" />
                                </NuxtLink>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" @click.prevent="addToCart(product)" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                            class="d-icon-heart"></i></a>
                                    <a href="#" class="btn-product-icon btn-quickview" title="Quick View"><i
                                            class="d-icon-search"></i></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><i
                                            class="d-icon-compare"></i></a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <h4 class="product-name">
                                    <NuxtLink :to="`/product/${product.slug}`">{{ product.name }}</NuxtLink>
                                </h4>
                                <div class="product-price">
                                    <ins v-if="product.oldPrice" class="new-price">{{ formatPrice(product.price)
                                        }}</ins>
                                    <del v-if="product.oldPrice" class="old-price">{{ formatPrice(product.oldPrice)
                                        }}</del>
                                    <span v-else class="price">{{ formatPrice(product.price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="banner-section mb-10 pb-7">
                <div class="container">
                    <div class="banner banner-radius"
                        style="background-image: url(/images/demos/demo-market1/banner/5.jpg); background-color: #2f2d2c;">
                        <div class="banner-content content-left mr-4">
                            <h3 class="banner-title text-white text-uppercase font-weight-bold ls-m">Today?s Special
                            </h3>
                            <p class="text-white font-weight-normal ls-m">New collection release spring season</p>
                            <NuxtLink to="/market-shop" class="btn btn-primary btn-link btn-underline">View All
                                Collection<i class="d-icon-arrow-right"></i></NuxtLink>
                        </div>
                        <div class="banner-content content-right">
                            <div class="owl-carousel owl-theme row cols-1" data-owl-options="{
                                'nav': true,
                                'dots': false,
                                'items': 1
                            }">
                                <div class="banner-item text-center">
                                    <h4 class="item-subtitle text-white text-uppercase font-weight-bold ls-m">On Shoes
                                    </h4>
                                    <h3 class="item-title text-primary ls-m">Up to 30% Off</h3>
                                    <NuxtLink to="/market-shop" class="btn btn-white btn-link btn-slide-right">Shop
                                        Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                </div>
                                <div class="banner-item text-center">
                                    <h4 class="item-subtitle text-white text-uppercase font-weight-bold ls-m">On
                                        Sneakers</h4>
                                    <h3 class="item-title text-primary ls-m">Up to 20% Off</h3>
                                    <NuxtLink to="/market-shop" class="btn btn-white btn-link btn-slide-right">Shop
                                        Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-10 pb-7">
                <div class="container">
                    <h2 class="title title-line title-underline with-link">
                        Food &amp; Kitchen
                        <NuxtLink to="/market-shop" class="btn btn-dark btn-link font-weight-semi-bold text-capitalize btn-more">More Products<i
                                class="d-icon-arrow-right"></i></NuxtLink>
                    </h2>
                    <div class="product-wrapper products-grid row">
                        <div class="banner-wrapper">
                            <div class="banner banner-fixed content-top banner-radius" style="background-image: url(/images/demos/demo-market1/banner/6.jpg);
                            background-color: #313131;">
                                <div class="banner-content">
                                    <h4 class="banner-subtitle text-white text-uppercase">Top Weekly Seller</h4>
                                    <h3 class="banner-title text-white font-weight-bold ls-m">New Groceries</h3>
                                    <div class="banner-price-info text-white font-weight-semi-bold ls-m">
                                        From Only<strong class="text-secondary">$185.00</strong>
                                    </div>
                                    <NuxtLink to="/market-shop" class="btn btn-white btn-outline btn-rounded">Shop Now<i
                                            class="d-icon-arrow-right"></i></NuxtLink>
                                </div>
                            </div>
                        </div>
                                                <div class="product text-center" v-for="product in gridCPrimaryProducts" :key="product.id">
                            <figure class="product-media">
                                <NuxtLink :to="`/product/${product.slug}`">
                                    <img :src="product.image" :alt="product.name" width="238" height="267" />
                                </NuxtLink>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" @click.prevent="addToCart(product)" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                            class="d-icon-heart"></i></a>
                                    <a href="#" class="btn-product-icon btn-quickview" title="Quick View"><i
                                            class="d-icon-search"></i></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><i
                                            class="d-icon-compare"></i></a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <h4 class="product-name">
                                    <NuxtLink :to="`/product/${product.slug}`">{{ product.name }}</NuxtLink>
                                </h4>
                                <div class="product-price">
                                    <ins v-if="product.oldPrice" class="new-price">{{ formatPrice(product.price)
                                        }}</ins>
                                    <del v-if="product.oldPrice" class="old-price">{{ formatPrice(product.oldPrice)
                                        }}</del>
                                    <span v-else class="price">{{ formatPrice(product.price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-10 pb-3">
                <div class="container">
                    <h2 class="title title-line title-underline with-link">
                        Best Selling
                        <NuxtLink to="/market-shop" class="btn btn-dark btn-link font-weight-semi-bold text-capitalize btn-more">More Products<i
                                class="d-icon-arrow-right"></i></NuxtLink>
                    </h2>
                    <div class="owl-carousel owl-theme row cols-xl-5 cols-lg-4 cols-md-3 cols-2" data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'margin': 20,
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
                                'items': 5
                            }
                        }
                    }">
                                                <div class="product text-center" v-for="product in gridCSecondaryProducts" :key="product.id">
                            <figure class="product-media">
                                <NuxtLink :to="`/product/${product.slug}`">
                                    <img :src="product.image" :alt="product.name" width="260" height="293" />
                                </NuxtLink>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart" @click.prevent="addToCart(product)" data-toggle="modal"
                                        data-target="#addCartModal" title="Add to cart"><i class="d-icon-bag"></i></a>
                                    <a href="#" class="btn-product-icon btn-wishlist" title="Add to wishlist"><i
                                            class="d-icon-heart"></i></a>
                                    <a href="#" class="btn-product-icon btn-quickview" title="Quick View"><i
                                            class="d-icon-search"></i></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><i
                                            class="d-icon-compare"></i></a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <h3 class="product-name">
                                    <NuxtLink :to="`/product/${product.slug}`">{{ product.name }}</NuxtLink>
                                </h3>
                                <div class="product-price">
                                    <ins v-if="product.oldPrice" class="new-price">{{ formatPrice(product.price)
                                        }}</ins>
                                    <del v-if="product.oldPrice" class="old-price">{{ formatPrice(product.oldPrice)
                                        }}</del>
                                    <span v-else class="price">{{ formatPrice(product.price) }}</span>
                                </div>
                                <div class="ratings-container">
                                    <div class="ratings-full">
                                        <span class="ratings" :style="{ width: `${product.ratingPercent}%` }"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                    <a href="#" class="rating-reviews">( {{ product.reviewCount }} reviews )</a>
                                </div>
                                <div class="count-text">Only <strong>{{ 10 + product.id }}</strong> Left</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="newsletter-section mb-10 pb-7">
                <div class="container">
                    <div class="banner banner-radius" style="background-image: url(/images/demos/demo-market1/banner/7.jpg);
                        background-color: #1c2225;">
                        <div class="banner-content">
                        <h4 class="banner-title text-white mt-0 mt-md-3 ls-m">Download {{ siteName }} App Now!</h4>
                            <p class="text-white">Shopping fastly and easily more with our app. Get a link to download
                                the app on your phone.</p>
                            <form action="#" method="get" class="input-wrapper input-wrapper-inline">
                                <input type="email" class="form-control" name="email" placeholder="Enter Your Email..."
                                    required="">
                                <button class="btn btn-primary" type="submit">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="brand-wrapper mb-10 pb-7">
                <div class="container">
                    <h2 class="title title-line title-underline">Featured Brands</h2>
                    <div class="row cols-lg-6 cols-md-4 cols-sm-3 cols-2 gutter-xs">
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/1.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/2.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/3.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/4.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/5.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/6.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/7.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/8.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/9.jpg" alt="Brand" width="228" height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/10.jpg" alt="Brand" width="228"
                                    height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/11.jpg" alt="Brand" width="228"
                                    height="100" />
                            </figure>
                        </div>
                        <div class="image-wrap">
                            <figure>
                                <img src="/images/demos/demo-market1/brand/12.jpg" alt="Brand" width="228"
                                    height="100" />
                            </figure>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-10 pb-2">
                <div class="container">
                    <h2 class="title title-line title-underline">From Our Blog</h2>
                    <div class="owl-carousel owl-theme row cols-lg-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '576': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 4
                            }
                        }
                    }">
                        <div class="post post-sm text-center overlay-zoom">
                            <figure class="post-media banner-radius">
                                <a href="#">
                                    <img src="/images/demos/demo-market1/blog/1.jpg" width="330" height="240"
                                        alt="post" />
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    by <a href="#" class="post-author">John Doe</a>
                                    | <a href="#" class="post-comment"><span>1</span> Comments</a>
                                </div>
                                <h4 class="post-title"><a href="#">We want to be different, and Fashion
                                        gives me that outlet to do</a></h4>
                                <a href="#"
                                    class="btn btn-link btn-underline btn-primary font-weight-semi-bold">Read
                                    More<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="post post-sm text-center overlay-zoom">
                            <figure class="post-media banner-radius">
                                <a href="#">
                                    <img src="/images/demos/demo-market1/blog/2.jpg" width="330" height="240"
                                        alt="post" />
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    by <a href="#" class="post-author">John Doe</a>
                                    | <a href="#" class="post-comment"><span>1</span> Comments</a>
                                </div>
                                <h4 class="post-title"><a href="#">Explore Fashion For Women In</a></h4>
                                <a href="#"
                                    class="btn btn-link btn-underline btn-primary font-weight-semi-bold">Read
                                    More<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="post post-sm text-center overlay-zoom">
                            <figure class="post-media banner-radius">
                                <a href="#">
                                    <img src="/images/demos/demo-market1/blog/3.jpg" width="330" height="240"
                                        alt="post" />
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    by <a href="#" class="post-author">John Doe</a>
                                    | <a href="#" class="post-comment"><span>1</span> Comments</a>
                                </div>
                                <h4 class="post-title"><a href="#">Fashion tells about who you are from
                                        external point of view</a></h4>
                                <a href="#"
                                    class="btn btn-link btn-underline btn-primary font-weight-semi-bold">Read
                                    More<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="post post-sm text-center overlay-zoom">
                            <figure class="post-media banner-radius">
                                <a href="#">
                                    <img src="/images/demos/demo-market1/blog/4.jpg" width="330" height="240"
                                        alt="post" />
                                </a>
                            </figure>
                            <div class="post-details">
                                <div class="post-meta">
                                    by <a href="#" class="post-author">John Doe</a>
                                    | <a href="#" class="post-comment"><span>1</span> Comments</a>
                                </div>
                                <h4 class="post-title"><a href="#">Just found the ultimate denim
                                        dresses</a></h4>
                                <a href="#"
                                    class="btn btn-link btn-underline btn-primary font-weight-semi-bold">Read
                                    More<i class="d-icon-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="recent-product mb-10 pb-8">
                <div class="container">
                    <h2 class="title title-line title-underline">Your Recently Viewed Products</h2>
                    <div class="owl-carousel owl-theme row cols-xl-8 cols-lg-6 cols-md-5 cols-sm-3 cols-2"
                        data-owl-options="{
                        'nav': false,
                        'dots': true,
                        'margin': 20,
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
                                'items': 8
                            }
                        }
                    }">
                                                <NuxtLink v-for="product in recentProducts" :key="product.id" :to="`/product/${product.slug}`">
                            <figure>
                                <img :src="product.image" :alt="product.name" width="155" height="174" />
                            </figure>
                        </NuxtLink>
                    </div>
                </div>
            </section>

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
                                        <a href="/cdn-cgi/l/email-protection#bfd2ded6d3ffcdd6d0dbda91dcd0d2"><span
                                                class="__cf_email__"
                                                data-cfemail="c8baa1a7acad88a5a9a1a4e6aba7a5">[email&#160;protected]</span></a>
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
                            <a v-for="subcategory in category.subcategories" :key="subcategory.slug || subcategory.id"
                                href="#">
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
                            <a href="#" title="social-link" class="social-link social-facebook fab fa-facebook-f"></a>
                            <a href="#" title="social-link" class="social-link social-twitter fab fa-twitter"></a>
                            <a href="#" title="social-link" class="social-link social-linkedin fab fa-linkedin-in"></a>
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
                <button class="btn btn-search" type="submit" title="submit-button">
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
                <button class="btn btn-search" type="submit" title="submit-button">
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
                <li><a href="https://1.envato.market/DdLk5" rel="noreferrer">Buy {{ siteName }}!</a></li>
            </ul>
        </div>
    </div>
    <!-- newsletter-popup type5 -->
    <div class="newsletter-popup newsletter-pop5 mfp-hide" id="newsletter-popup">
        <figure>
            <img src="/images/newsletter-popup5.png" width="500" height="570" alt="newsletter5" />
        </figure>
        <div class="newsletter-content p-absolute">
            <h2 class="font-weight-semi-bold ls-m mb-2">Sign up to <span class="font-weight-bolder">RIODE</span></h2>
            <p class="text-body">Get timely updates from your favorite products.</p>
            <form action="#" method="get" class="input-wrapper input-wrapper-inline input-wrapper-round">
                <input type="email" class="form-control email" name="email" id="email2"
                    placeholder="Email address here..." required="">
                <button class="btn btn-dark" type="submit">SUBMIT</button>
            </form>
            <div class="form-checkbox justify-content-center">
                <input type="checkbox" class="custom-checkbox" id="hide-newsletter-popup" name="hide-newsletter-popup"
                    required />
                <label class="hide-newsletter-popup">Don't show this popup again</label>
            </div>
            <div class="social-links">
                <a href="#" title="social-link" class="social-link social-linkedin fab fa-google"></a>
                <a href="#" title="social-link" class="social-link social-facebook fab fa-facebook-f"></a>
                <a href="#" title="social-link" class="social-link social-twitter fab fa-twitter"></a>
            </div>
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

    <!-- <div class="mfp-wrap mfp-close-btn-in mfp-auto-cursor mfp-login mfp-fade mfp-ready" tabindex="-1"
        >
        <div class="mfp-container mfp-ajax-holder">
            <div class="mfp-content">
                <div class="login-popup">
                    <div class="form-box">
                        <div class="tab tab-nav-simple tab-nav-boxed form-tab">
                            <ul class="nav nav-tabs nav-fill align-items-center border-no justify-content-center mb-5"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active border-no lh-1 ls-normal" href="#signin">Login</a>
                                </li>
                                <li class="delimiter">or</li>
                                <li class="nav-item">
                                    <a class="nav-link border-no lh-1 ls-normal" href="#register">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="signin">
                                    <form action="#">
                                        <div class="form-group mb-3">
                                            <input type="text" class="form-control" id="singin-email"
                                                name="singin-email" placeholder="Username or Email Address *"
                                                required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="singin-password"
                                                name="singin-password" placeholder="Password *" required="">
                                        </div>
                                        <div class="form-footer">
                                            <div class="form-checkbox">
                                                <input type="checkbox" class="custom-checkbox" id="signin-remember"
                                                    name="signin-remember">
                                                <label class="form-control-label" for="signin-remember">Remember
                                                    me</label>
                                            </div>
                                            <a href="#" class="lost-link">Lost your password?</a>
                                        </div>
                                        <button class="btn btn-dark btn-block btn-rounded" type="submit">Login</button>
                                    </form>
                                    <div class="form-choice text-center">
                                        <label class="ls-m">or Login With</label>
                                        <div class="social-links">
                                            <a href="#" class="social-link social-google fab fa-google border-no"></a>
                                            <a href="#"
                                                class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                            <a href="#" class="social-link social-twitter fab fa-twitter border-no"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="register">
                                    <form action="#">
                                        <div class="form-group mb-3">
                                            <input type="email" class="form-control" id="register-email"
                                                name="register-email" placeholder="Your Email Address *" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" id="register-password"
                                                name="register-password" placeholder="Password *" required="">
                                        </div>
                                        <div class="form-footer">
                                            <div class="form-checkbox">
                                                <input type="checkbox" class="custom-checkbox" id="register-agree"
                                                    name="register-agree" required="">
                                                <label class="form-control-label" for="register-agree">I agree to the
                                                    privacy policy</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-dark btn-block btn-rounded"
                                            type="submit">Register</button>
                                    </form>
                                    <div class="form-choice text-center">
                                        <label class="ls-m">or Register With</label>
                                        <div class="social-links">
                                            <a href="#" class="social-link social-google fab fa-google border-no"></a>
                                            <a href="#"
                                                class="social-link social-facebook fab fa-facebook-f border-no"></a>
                                            <a href="#" class="social-link social-twitter fab fa-twitter border-no"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button title="Close (Esc)" type="button" class="mfp-close"><span>?</span></button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Plugins JS File -->
    
    
    
    
    
    
    
    
    
    
    
    <!-- Main JS File -->
    
    

  </div>
</template>

<script setup>
const { homeSections, formatPrice } = useProducts()
const { cart, cartCount, cartSubtotal, addToCart, removeItem } = useCart()
const { categories } = useCategories()
const { vendors: topVendors } = useTopVendors(4)
const { settings } = useSiteSettings()
const router = useRouter()
const siteName = computed(() => settings.value.site_name || 'Riode')
const siteLogoWide = computed(
  () =>
    settings.value.site_logo_wide_url ||
    settings.value.site_logo_url ||
    '/images/demos/demo-market1/logo.png'
)

const searchInput = ref('')
const searchCategory = ref('all-cat')

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

const ellipseCategoryImages = [
  '/images/demos/demo-market1/category/1.png',
  '/images/demos/demo-market1/category/2.png',
  '/images/demos/demo-market1/category/3.png',
  '/images/demos/demo-market1/category/4.png',
  '/images/demos/demo-market1/category/5.png',
  '/images/demos/demo-market1/category/6.png',
  '/images/demos/demo-market1/category/7.png',
  '/images/demos/demo-market1/category/8.png',
  '/images/demos/demo-market1/category/9.png',
  '/images/demos/demo-market1/category/10.png'
]

const ellipseCategories = computed(() =>
  categories.value.slice(0, ellipseCategoryImages.length).map((category, index) => ({
    ...category,
    imageUrl: category.image_url ?? ellipseCategoryImages[index],
    key: category.slug || String(category.id)
  }))
)

const footerCategories = computed(() =>
  categories.value.slice(0, 6).map((category) => ({
    ...category,
    key: category.slug || String(category.id),
    subcategories: (category.subcategories ?? []).slice(0, 12)
  }))
)

const categoryLink = (item) => {
  if (!item?.slug || item.slug === 'all') {
    return '/market-shop'
  }
  return { path: '/market-shop', query: { category: item.slug } }
}

const vendorFallbackLogo = '/images/demos/demo-market1/vendor/logo-1.png'
const vendorFallbackProduct = '/images/demos/demo-market1/vendor/1.jpg'

const vendorLink = (vendor) => ({
  path: '/market-shop',
  query: { vendor_id: vendor.id }
})

const submitSearch = () => {
  const term = searchInput.value.trim()
  const category = searchCategory.value !== 'all-cat' ? searchCategory.value : undefined
  router.push({
    path: '/market-shop',
    query: {
      search: term || undefined,
      category
    }
  })
}
const dealMain = computed(() => homeSections.value.dealMain)
const dealList = computed(() => homeSections.value.dealList)
const gridAProducts = computed(() => homeSections.value.gridA)
const gridBProducts = computed(() => homeSections.value.gridB)
const gridCPrimaryProducts = computed(() => homeSections.value.gridCPrimary)
const gridCSecondaryProducts = computed(() => homeSections.value.gridCSecondary)
const recentProducts = computed(() => homeSections.value.recent)

useHead({
  bodyAttrs: { class: 'home market' }
})

</script>








