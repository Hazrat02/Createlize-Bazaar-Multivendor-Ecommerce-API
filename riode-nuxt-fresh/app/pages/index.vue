<template>
   <main class="main">
            <section class="intro-section mt-1">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 mb-4">
                            <div style="" class="owl-carousel owl-theme owl-dot-inner row gutter-no cols-1 animation-slider"
                                data-owl-options="{
                                'nav': false,
                                'dots': true,
                                'autoplay': true,
                                'autoplayTimeout': 4000,
                                'autoplayHoverPause': true,
                                'items': 1
                            }">
                                <div
                                    v-for="(slide, index) in heroSlides"
                                    :key="slide.id || `hero-${index}`"
                                    :class="[
                                        'banner',
                                        'banner-fixed',
                                        'content-middle',
                                        'intro-slide',
                                        `intro-slide${index + 1}`,
                                        'banner-radius'
                                    ]"
                                >
                                    <figure>
                                        <img 
                                            :src="slide.image_url"
                                            :alt="slide.title || 'Banner'"
                                            width="1030"
                                            height="450"
                                        />
                                    </figure>
                                    <div  class="banner-content" :class="bannerContentClass(slide)">
                                        <div class="slide-animate" data-animation-options="{
                                            'name': 'fadeInLeftShorter', 'duration': '1s'
                                        }">
                                            <h5 v-if="slide.subtitle" class="banner-subtitle text-capitalize font-weight-normal">
                                                {{ slide.subtitle }}
                                            </h5>
                                            <h3 v-if="slide.title" class="banner-title text-uppercase font-weight-bold ls-m">
                                                {{ slide.title }}
                                            </h3>
                                            <NuxtLink :to="slide.cta_link || '/market-shop'" class="btn btn-dark btn-outline btn-rounded">
                                                {{ slide.cta_text || 'Shop Now' }}<i class="d-icon-arrow-right"></i>
                                            </NuxtLink>
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
                                            <img
                                                :src="featuredCategory?.image_url || '/images/demos/demo-market1/banner/1.jpg'"
                                                :alt="featuredCategory?.name || 'Intro Banner'"
                                                width="330"
                                                height="215"
                                                style="background-color: #232323;"
                                            />
                                        </figure>
                                        <div class="banner-content">
                                            <h3 class="banner-title font-weight-bold text-white ls-m">
                                                {{ featuredCategory?.name || 'Electronics' }}
                                            </h3>
                                            <div class="product-count text-uppercase text-white font-weight-semi-bold">
                                                {{ Number(featuredCategory?.product_count || 6) }} Products
                                            </div>
                                            <span class="divider bg-white"></span>
                                            <NuxtLink
                                                :to="featuredCategory?.slug ? `/market-shop?category=${featuredCategory.slug}` : '/market-shop'"
                                                class="btn btn-white btn-link btn-underline ls-m"
                                            >
                                                Shop Now<i class="d-icon-arrow-right"></i></NuxtLink>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-banner mb-4">
                                    <div class="banner banner-fixed content-middle banner-radius overlay-zoom">
                                        <figure>
                                            <img
                                                :src="topSubcategory?.image_url || '/images/demos/demo-market1/banner/2.jpg'"
                                                :alt="topSubcategory?.name || 'Intro Banner'"
                                                width="330"
                                                height="215"
                                                style="background-color: #eca5a9;"
                                            />
                                        </figure>
                                        <div class="banner-content">
                                            <h3 class="banner-title font-weight-bold text-white ls-m">
                                                {{ topSubcategory?.name || 'Accessories' }}
                                            </h3>
                                            <div class="product-count text-uppercase text-white font-weight-semi-bold">
                                                {{ Number(topSubcategory?.product_count || 3) }} Products
                                            </div>
                                            <span class="divider bg-white"></span>
                                            <NuxtLink
                                                :to="topSubcategory?.slug ? `/market-shop?subcategory=${topSubcategory.slug}` : '/market-shop'"
                                                class="btn btn-white btn-link btn-underline ls-m"
                                            >
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
</template>

<script setup>
const { homeSections, formatPrice } = useProducts()
const { cart, cartCount, cartSubtotal, addToCart, removeItem } = useCart()
const { categories } = useCategories()
const { vendors: topVendors } = useTopVendors(4)
const { settings } = useSiteSettings()
const config = useRuntimeConfig()
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
const homepageCache = useState('homepage-cache', () => null)

const { data: homepageData } = useAsyncData(
  'homepage',
  async () => {
    if (homepageCache.value) {
      return homepageCache.value
    }
    const payload = await $fetch(`${config.public.apiBase}/homepage`)
    homepageCache.value = payload
    return payload
  },
  { lazy: true }
)

const defaultHeroSlides = [
  {
    image_url: '/images/demos/demo-market1/slides/1.jpg',
    subtitle: 'Lifestyle Collection',
    title: 'for Ski Clothes',
    cta_text: 'Shop Now',
    cta_link: '/market-shop',
    text_align: 'left'
  },
  {
    image_url: '/images/demos/demo-market1/slides/2.jpg',
    subtitle: 'Find Your Trending',
    title: 'Autumn style',
    cta_text: 'Shop Now',
    cta_link: '/market-shop',
    text_align: 'right'
  },
  {
    image_url: '/images/demos/demo-market1/slides/3.jpg',
    subtitle: 'Must-Haves',
    title: 'for the season',
    cta_text: 'Shop Now',
    cta_link: '/market-shop',
    text_align: 'left'
  }
]

const heroSlides = computed(() => {
  const items = homepageData.value?.banners ?? []
  return items.length ? items : defaultHeroSlides
})

const bannerContentClass = (banner) => {
  if (!banner?.text_align) return ''
  if (banner.text_align === 'center') return 'text-center'
  if (banner.text_align === 'right') return 'text-right'
  return ''
}

const featuredCategory = computed(() => homepageData.value?.featured_category || null)
const topSubcategory = computed(
  () => (homepageData.value?.top_selling_subcategories ?? [])[0] || null
)

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
definePageMeta({
  layout: 'riode',
  requiresAuth: true
})
</script>










