<template>
  <div class="page-wrapper">
    <header class="header header-border">
      <div class="header-top">
        <div class="container">
          <div class="header-left">
            <p class="welcome-msg">
              Welcome to {{ siteName }} store message or remove it!
            </p>
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
            <NuxtLink to="/contact-us" class="contact d-lg-show"
              ><i class="d-icon-map"></i>Contact</NuxtLink
            >
            <a href="#" class="help d-lg-show"
              ><i class="d-icon-info"></i> Need Help</a
            >
            <a class="login-link" href="#" data-toggle="login-modal"
              ><i class="d-icon-user"></i>Sign in</a
            >
            <span class="delimiter">/</span>
            <a class="register-link ml-0" href="#" data-toggle="login-modal"
              >Register</a
            >
            <!-- End of Login -->
          </div>
        </div>
      </div>
      <!-- End HeaderTop -->
      <div class="header-middle sticky-header fix-top sticky-content">
        <div class="container">
          <div class="header-left">
            <a href="#" class="mobile-menu-toggle">
              <i class="d-icon-bars2"></i>
            </a>
            <NuxtLink to="/" class="logo">
              <img :src="siteLogoWide" :alt="siteName" width="153" height="44" />
            </NuxtLink>
            <!-- End Logo -->

            <div class="header-search hs-simple">
              <form action="#" class="input-wrapper" @submit.prevent="submitSearch">
                <input
                  v-model="searchInput"
                  type="text"
                  class="form-control"
                  name="search"
                  autocomplete="off"
                  placeholder="Search..."
                  required
                />
                <button class="btn btn-search" type="submit">
                  <i class="d-icon-search"></i>
                </button>
              </form>
            </div>
            <!-- End Header Search -->
          </div>
          <div class="header-right">
            <a href="tel:#" class="icon-box icon-box-side">
              <div class="icon-box-icon mr-0 mr-lg-2">
                <i class="d-icon-phone"></i>
              </div>
              <div class="icon-box-content d-lg-show">
                <h4 class="icon-box-title">Call Us Now:</h4>
                <p>0(800) 123-456</p>
              </div>
            </a>
            <span class="divider"></span>
            <div class="dropdown wishlist wishlist-dropdown off-canvas">
              <NuxtLink to="/wishlist" class="wishlist-toggle">
                <i class="d-icon-heart"></i>
              </NuxtLink>
              <div class="canvas-overlay"></div>
              <!-- End Wishlist Toggle -->
              <div class="dropdown-box scrollable">
                <div class="canvas-header">
                  <h4 class="canvas-title">wishlist</h4>
                  <a
                    href="#"
                    class="btn btn-dark btn-link btn-icon-right btn-close"
                    >close<i class="d-icon-arrow-right"></i
                    ><span class="sr-only">wishlist</span></a
                  >
                </div>
                <div class="products scrollable">
                  <div class="product product-wishlist">
                    <figure class="product-media">
                      <NuxtLink to="/product">
                        <img
                          src="/images/wishlist/product-1.jpg"
                          width="100"
                          height="100"
                          alt="product"
                        />
                      </NuxtLink>
                      <button class="btn btn-link btn-close">
                        <i class="fas fa-times"></i
                        ><span class="sr-only">Close</span>
                      </button>
                    </figure>
                    <div class="product-detail">
                      <NuxtLink to="/product" class="product-name"
                        >Girl's Dark Bag</NuxtLink
                      >
                      <div class="price-box">
                        <span class="product-price">$84.00</span>
                      </div>
                    </div>
                  </div>
                  <!-- End of wishlist Product -->
                  <div class="product product-wishlist">
                    <figure class="product-media">
                      <NuxtLink to="/product">
                        <img
                          src="/images/wishlist/product-2.jpg"
                          width="100"
                          height="100"
                          alt="product"
                        />
                      </NuxtLink>
                      <button class="btn btn-link btn-close">
                        <i class="fas fa-times"></i
                        ><span class="sr-only">Close</span>
                      </button>
                    </figure>
                    <div class="product-detail">
                      <NuxtLink to="/product" class="product-name"
                        >Women's Fashional Comforter
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
                        <img
                          src="/images/wishlist/product-3.jpg"
                          width="100"
                          height="100"
                          alt="product"
                        />
                      </NuxtLink>
                      <button class="btn btn-link btn-close">
                        <i class="fas fa-times"></i
                        ><span class="sr-only">Close</span>
                      </button>
                    </figure>
                    <div class="product-detail">
                      <NuxtLink to="/product" class="product-name"
                        >Wide Knickerbockers</NuxtLink
                      >
                      <div class="price-box">
                        <span class="product-price">$84.00</span>
                      </div>
                    </div>
                  </div>

                  <!-- End of wishlist Product -->
                </div>
                <NuxtLink to="/wishlist" class="btn btn-dark wishlist-btn mt-4"
                  ><span>Go To Wishlist</span></NuxtLink
                >
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
                  <a
                    href="#"
                    class="btn btn-dark btn-link btn-icon-right btn-close"
                    >close<i class="d-icon-arrow-right"></i
                    ><span class="sr-only">Cart</span></a
                  >
                </div>
                <div class="products scrollable">
                  <div v-if="!cart.length" class="text-center text-muted py-4">
                    Your cart is empty.
                  </div>
                  <div v-for="item in cart" :key="item.id" class="product product-cart">
                    <figure class="product-media">
                      <NuxtLink :to="item.href || `/product/${item.slug}`">
                        <img
                          :src="item.image"
                          :alt="item.name"
                          width="80"
                          height="88"
                        />
                      </NuxtLink>
                      <button class="btn btn-link" @click.prevent="removeItem(item.id)">
                        <i class="fas fa-times"></i
                        >
                      </button>
                    </figure>
                    <div class="product-detail">
                      <NuxtLink :to="item.href || `/product/${item.slug}`" class="product-name">
                        {{ item.name }}
                      </NuxtLink>
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
                  <NuxtLink to="/cart" class="btn btn-dark btn-link"
                    >View Cart</NuxtLink
                  >
                  <NuxtLink to="/checkout" class="btn btn-dark"
                    ><span>Go To Checkout</span></NuxtLink
                  >
                </div>
                <!-- End of Cart Action -->
              </div>
              <!-- End Dropdown Box -->
            </div>
          </div>
        </div>
      </div>

      <div class="header-bottom d-lg-show">
        <div class="container">
          <div class="header-left">
            <nav class="main-nav">
              <ul class="menu">
                <li>
                  <NuxtLink to="/">Home</NuxtLink>
                </li>
                <li>
                  <NuxtLink to="/compare">Compare</NuxtLink>
                </li>
                <li>
                  <NuxtLink to="/shop">Categories</NuxtLink>
                  <div class="megamenu">
                    <div class="row">
                      <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                        <h4 class="menu-title">Variations 1</h4>
                        <ul>
                          <li><a href="#">Classic Filter</a></li>
                          <li><a href="#">Left Toggle Filter</a></li>
                          <li><a href="#">Right Toggle Sidebar</a></li>
                          <li><a href="#">Horizontal Filter </a></li>
                          <li><a href="#">Navigation Filter</a></li>

                          <li><a href="#">Off-Canvas Filter </a></li>
                          <li><a href="#">Top Banner</a></li>
                          <li><a href="#">Inner Top Banner</a></li>
                          <li><a href="#">With Bottom Block</a></li>
                        </ul>
                      </div>
                      <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                        <h4 class="menu-title">Variations 2</h4>
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
                      </div>
                      <div class="col-6 col-sm-4 col-md-4 col-lg-3">
                        <h4 class="menu-title">Variations 3</h4>
                        <ul>
                          <li><a href="#">Category Grid Shop</a></li>
                          <li><a href="#">Category + Products</a></li>
                          <li><a href="#">Shop Default 1 </a></li>
                          <li><a href="#">Shop Default 2</a></li>
                          <li><a href="#">Shop Default 3</a></li>
                          <li><a href="#">Shop Default 4</a></li>
                          <li><a href="#">Shop Default 5</a></li>
                          <li><a href="#">Shop Default 6</a></li>
                          <li><a href="#">Shop Default 7</a></li>
                          <li><a href="#">Shop Default 8</a></li>
                        </ul>
                      </div>
                      <div
                        class="col-6 col-sm-4 col-md-4 col-lg-3 menu-banner menu-banner1 banner banner-fixed"
                      >
                        <figure>
                          <img
                            src="/images/menu/banner-1.jpg"
                            alt="Menu banner"
                            width="221"
                            height="330"
                          />
                        </figure>
                        <div class="banner-content y-50">
                          <h4
                            class="banner-subtitle font-weight-bold text-primary ls-m"
                          >
                            Sale.
                          </h4>
                          <h3 class="banner-title font-weight-bold">
                            <span class="text-uppercase">Up to</span>70% Off
                          </h3>
                          <NuxtLink
                            to="/shop"
                            class="btn btn-link btn-underline"
                            >shop now<i class="d-icon-arrow-right"></i
                          ></NuxtLink>
                        </div>
                      </div>
                      <!-- End Megamenu -->
                    </div>
                  </div>
                </li>
                <li>
                  <NuxtLink to="/product">Products</NuxtLink>
                  <div class="megamenu">
                    <div class="row">
                      <div class="col-6 col-sm-4 col-md-3">
                        <h4 class="menu-title">Product Pages</h4>
                        <ul>
                          <li><a href="#">Simple Product</a></li>
                          <li><a href="#">Featured &amp; On Sale</a></li>
                          <li>
                            <NuxtLink to="/product">Variable Product</NuxtLink>
                          </li>
                          <li><a href="#">Variation Swatch Product</a></li>
                          <li><a href="#">Grouped Product </a></li>
                          <li><a href="#">External Product</a></li>
                          <li><a href="#">In Stock Product</a></li>
                          <li><a href="#">Out of Stock Product</a></li>
                          <li><a href="#">Upsell Products</a></li>
                          <li><a href="#">Cross Sell Products</a></li>
                        </ul>
                      </div>
                      <div class="col-6 col-sm-4 col-md-3">
                        <h4 class="menu-title">Product Layouts</h4>
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
                      </div>
                      <div class="col-6 col-sm-4 col-md-3">
                        <h4 class="menu-title">Product Features</h4>
                        <ul>
                          <li><a href="#">Sale Countdown</a></li>
                          <li><a href="#">Hurry Up Notification </a></li>
                          <li><a href="#">Attribute Guide </a></li>
                          <li><a href="#">Add Cart Sticky</a></li>
                          <li><a href="#">Labels on Thumbnail</a></li>
                          <li><a href="#">More Description Tabs</a></li>
                          <li><a href="#">Data In Accordion</a></li>
                          <li><a href="#">Data Inside</a></li>
                          <li><a href="#">Video Thumbnail </a></li>
                          <li><a href="#">360 Degree Thumbnail </a></li>
                        </ul>
                      </div>
                      <div
                        class="col-6 col-sm-4 col-md-3 menu-banner menu-banner2 banner banner-fixed"
                      >
                        <figure>
                          <img
                            src="/images/menu/banner-2.jpg"
                            alt="Menu banner"
                            width="221"
                            height="330"
                          />
                        </figure>
                        <div class="banner-content x-50 text-center">
                          <h3 class="banner-title text-white text-uppercase">
                            Sunglasses
                          </h3>
                          <h4
                            class="banner-subtitle font-weight-bold text-white mb-0"
                          >
                            $23.00 - $120.00
                          </h4>
                        </div>
                      </div>
                      <!-- End MegaMenu -->
                    </div>
                  </div>
                </li>
                <li class="active">
                  <a href="#">Pages</a>
                  <ul>
                    <li><NuxtLink to="/about-us">About</NuxtLink></li>
                    <li><NuxtLink to="/contact-us">Contact Us</NuxtLink></li>
                    <li><NuxtLink to="/account">My Account</NuxtLink></li>
                    <li><NuxtLink to="/wishlist">Wishlist</NuxtLink></li>
                    <li><NuxtLink to="/faq">FAQs</NuxtLink></li>
                    <li>
                      <NuxtLink to="/error-404">Error 404</NuxtLink>
                      <ul>
                        <li>
                          <NuxtLink to="/error-404">Error 404-1</NuxtLink>
                        </li>
                        <li><a href="#">Error 404-2</a></li>
                        <li><a href="#">Error 404-3</a></li>
                        <li><a href="#">Error 404-4</a></li>
                      </ul>
                    </li>
                    <li><NuxtLink to="/coming-soon">Coming Soon</NuxtLink></li>
                  </ul>
                </li>
                <li class="d-xl-show">
                  <a href="#">Elements</a>
                  <div class="megamenu">
                    <div class="row">
                      <div class="col-md-3">
                        <h4 class="menu-title">Elements 1</h4>
                        <ul>
                          <li><a href="#">Accordions</a></li>
                          <li><a href="#">Alert &amp; Notification</a></li>

                          <li><a href="#">Banner Effect </a></li>
                          <li><a href="#">Banner </a></li>
                          <li><a href="#">Blog Posts</a></li>
                          <li><a href="#">Breadcrumb </a></li>
                          <li><a href="#">Buttons</a></li>
                          <li><a href="#">Call to Action</a></li>
                          <li><a href="#">Countdown </a></li>
                        </ul>
                      </div>
                      <div class="col-md-3">
                        <h4 class="menu-title">Elements 2</h4>
                        <ul>
                          <li><a href="#">Counter </a></li>
                          <li><a href="#">Creative Grid </a></li>
                          <li><a href="#">Entrance Effect </a></li>
                          <li><a href="#">Floating </a></li>
                          <li><a href="#">Hotspot </a></li>
                          <li><a href="#">Icon Boxes</a></li>
                          <li><a href="#">Icons</a></li>
                          <li><a href="#">Image box </a></li>
                          <li><a href="#">Instagrams</a></li>
                        </ul>
                      </div>
                      <div class="col-md-3">
                        <h4 class="menu-title">Elements 3</h4>
                        <ul>
                          <li><a href="#">Product Category</a></li>
                          <li><a href="#">Products</a></li>
                          <li><a href="#">Products + Banner </a></li>
                          <li><a href="#">Products + Grid </a></li>
                          <li><a href="#">Product Single </a></li>
                          <li><a href="#">Products + Tab </a></li>
                          <li><a href="#">Single Product </a></li>
                          <li><a href="#">Slider </a></li>
                          <li><a href="#">Social Icons </a></li>
                        </ul>
                      </div>
                      <div class="col-md-3">
                        <h4 class="menu-title">Elements 4</h4>
                        <ul>
                          <li><a href="#">Subcategory </a></li>
                          <li><a href="#">Svg Floating </a></li>
                          <li><a href="#">Tabs</a></li>
                          <li><a href="#">Testimonials </a></li>
                          <li><a href="#">Title</a></li>
                          <li><a href="#">Typography</a></li>
                          <li><a href="#">Vendor </a></li>
                          <li><a href="#">Video </a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
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
                  <NuxtLink to="/about-us">About Us</NuxtLink>
                </li>
              </ul>
            </nav>
          </div>
          <div class="header-right">
            <a href="#"><i class="d-icon-card"></i>Special Offers</a>
            <a href="https://d-themes.com/buynow/riodehtml" class="ml-6"
              >Buy {{ siteName }}!</a
            >
          </div>
        </div>
      </div>
    </header>
    <!-- End Header -->

    <slot />
    <!-- End Main -->
    <footer class="footer">
      <div class="container">
        <div class="footer-top">
          <div class="row align-items-center">
            <div class="col-lg-3">
              <a href="#" class="logo-footer">
                <img
                  :src="siteLogoWide"
                  :alt="siteName"
                  width="154"
                  height="43"
                />
              </a>
              <!-- End FooterLogo -->
            </div>
            <div class="col-lg-9">
              <div
                class="widget widget-newsletter form-wrapper form-wrapper-inline"
              >
                <div class="newsletter-info mx-auto mr-lg-2 ml-lg-4">
                  <h4 class="widget-title">Subscribe to our Newsletter</h4>
                  <p>Get all the latest information, Sales and Offers.</p>
                </div>
                <form action="#" class="input-wrapper input-wrapper-inline">
                  <input
                    type="email"
                    class="form-control"
                    name="email"
                    id="email"
                    placeholder="Email address here..."
                    required
                  />
                  <button
                    class="btn btn-primary btn-rounded btn-md ml-2"
                    type="submit"
                  >
                    subscribe<i class="d-icon-arrow-right"></i>
                  </button>
                </form>
              </div>
              <!-- End Newsletter -->
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
                    <a
                      href="/cdn-cgi/l/email-protection#3459555d5874465d5b50511a575b59"
                      ><span
                        class="__cf_email__"
                        data-cfemail="4825292124083a21272c2d662b2725"
                        >[email&#160;protected]</span
                      ></a
                    >
                  </li>
                  <li>
                    <label>Address:</label>
                    <a href="#">123 Street Name, City, England</a>
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
            <div class="col-lg-3 col-md-6">
              <div class="widget ml-lg-4">
                <h4 class="widget-title">My Account</h4>
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
            <div class="col-lg-3 col-md-6">
              <div class="widget ml-lg-4">
                <h4 class="widget-title">Contact Info</h4>
                <ul class="widget-body">
                  <li>
                    <a href="#">Sign in</a>
                  </li>
                  <li>
                    <NuxtLink to="/cart">View Cart</NuxtLink>
                  </li>
                  <li>
                    <NuxtLink to="/wishlist">My Wishlist</NuxtLink>
                  </li>
                  <li>
                    <a href="#">Track My Order</a>
                  </li>
                  <li>
                    <a href="#">Help</a>
                  </li>
                </ul>
              </div>
              <!-- End Widget -->
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="widget widget-instagram">
                <h4 class="widget-title">Instagram</h4>
                <figure class="widget-body row">
                  <div class="col-3">
                    <img
                      src="/images/instagram/01.jpg"
                      alt="instagram 1"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/02.jpg"
                      alt="instagram 2"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/03.jpg"
                      alt="instagram 3"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/04.jpg"
                      alt="instagram 4"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/05.jpg"
                      alt="instagram 5"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/06.jpg"
                      alt="instagram 6"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/07.jpg"
                      alt="instagram 7"
                      width="64"
                      height="64"
                    />
                  </div>
                  <div class="col-3">
                    <img
                      src="/images/instagram/08.jpg"
                      alt="instagram 8"
                      width="64"
                      height="64"
                    />
                  </div>
                </figure>
              </div>
              <!-- End Instagram -->
            </div>
          </div>
        </div>
        <!-- End FooterMiddle -->
        <div class="footer-bottom">
          <div class="footer-left">
            <figure class="payment">
              <img
                src="/images/payment.png"
                alt="payment"
                width="159"
                height="29"
              />
            </figure>
          </div>
          <div class="footer-center">
            <p class="copyright">
              {{ siteName }} eCommerce &copy; 2021. All Rights Reserved
            </p>
          </div>
          <div class="footer-right">
            <div class="social-links">
              <a
                href="#"
                class="social-link social-facebook fab fa-facebook-f"
              ></a>
              <a href="#" class="social-link social-twitter fab fa-twitter"></a>
              <a
                href="#"
                class="social-link social-linkedin fab fa-linkedin-in"
              ></a>
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
    <NuxtLink to="/shop" class="sticky-link">
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
        <input
          v-model="searchInput"
          type="text"
          class="form-control"
          name="search"
          autocomplete="off"
          placeholder="Search your keyword..."
          required
        />
        <button class="btn btn-search" type="submit">
          <i class="d-icon-search"></i>
        </button>
      </form>
    </div>
  </div>
  <!-- Scroll Top -->
  <a id="scroll-top" href="#top" title="Top" role="button" class="scroll-top"
    ><i class="d-icon-arrow-up"></i
  ></a>

  <!-- MobileMenu -->
  <div class="mobile-menu-wrapper">
    <div class="mobile-menu-overlay"></div>
    <!-- End Overlay -->
    <a class="mobile-menu-close" href="#"><i class="d-icon-times"></i></a>
    <!-- End CloseButton -->
    <div class="mobile-menu-container scrollable">
      <form action="#" class="input-wrapper" @submit.prevent="submitSearch">
        <input
          v-model="searchInput"
          type="text"
          class="form-control"
          name="search"
          autocomplete="off"
          placeholder="Search your keyword..."
          required
        />
        <button class="btn btn-search" type="submit">
          <i class="d-icon-search"></i>
        </button>
      </form>
      <!-- End Search Form -->
      <ul class="mobile-menu mmenu-anim">
        <li>
          <NuxtLink to="/">Home</NuxtLink>
        </li>
        <li>
          <NuxtLink to="/shop" class="active">Categories</NuxtLink>
          <ul>
            <li>
              <a href="#"> Variations 1 </a>
              <ul>
                <li><a href="#">Classic Filter</a></li>
                <li><a href="#">Left Toggle Filter</a></li>
                <li><a href="#">Right Toggle Sidebar</a></li>
                <li><a href="#">Horizontal Filter </a></li>
                <li><a href="#">Navigation Filter</a></li>

                <li><a href="#">Off-Canvas Filter </a></li>
                <li><a href="#">Top Banner</a></li>
                <li><a href="#">Inner Top Banner</a></li>
                <li><a href="#">With Bottom Block</a></li>
              </ul>
            </li>
            <li>
              <a href="#"> Variations 2 </a>
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
              <a href="#"> Variations 3 </a>
              <ul>
                <li><a href="#">Category Grid Shop</a></li>
                <li><a href="#">Category + Products</a></li>
                <li><a href="#">Shop Default 1 </a></li>
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
          <NuxtLink to="/product">Products</NuxtLink>
          <ul>
            <li>
              <a href="#">Product Pages</a>
              <ul>
                <li><a href="#">Simple Product</a></li>
                <li><a href="#">Featured &amp; On Sale</a></li>
                <li><NuxtLink to="/product">Variable Product</NuxtLink></li>
                <li><a href="#">Variation Swatch Product</a></li>
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
                <li><a href="#">Labels on Thumbnail</a></li>
                <li><a href="#">More Description Tabs</a></li>
                <li><a href="#">Data In Accordion</a></li>
                <li><a href="#">Data Inside</a></li>
                <li><a href="#">Video Thumbnail </a></li>
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
            <li>
              <NuxtLink to="/error-404">Error 404</NuxtLink>
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

                <li><a href="#">Banner Effect </a></li>
                <li><a href="#">Banner </a></li>
                <li><a href="#">Blog Posts</a></li>
                <li><a href="#">Breadcrumb </a></li>
                <li><a href="#">Buttons</a></li>
                <li><a href="#">Call to Action</a></li>
                <li><a href="#">Countdown </a></li>
              </ul>
            </li>
            <li>
              <a href="#">Elements 2</a>
              <ul>
                <li><a href="#">Counter </a></li>
                <li><a href="#">Creative Grid </a></li>
                <li><a href="#">Entrance Effect </a></li>
                <li><a href="#">Floating </a></li>
                <li><a href="#">Hotspot </a></li>
                <li><a href="#">Icon Boxes</a></li>
                <li><a href="#">Icons</a></li>
                <li><a href="#">Image box </a></li>
                <li><a href="#">Instagrams</a></li>
              </ul>
            </li>
            <li>
              <a href="#">Elements 3</a>
              <ul>
                <li><a href="#">Product Category</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">Products + Banner </a></li>
                <li><a href="#">Products + Grid </a></li>
                <li><a href="#">Product Single </a></li>
                <li><a href="#">Products + Tab </a></li>
                <li><a href="#">Single Product </a></li>
                <li><a href="#">Slider </a></li>
                <li><a href="#">Social Icons </a></li>
              </ul>
            </li>
            <li>
              <a href="#">Elements 4</a>
              <ul>
                <li><a href="#">Subcategory </a></li>
                <li><a href="#">Svg Floating </a></li>
                <li><a href="#">Tabs</a></li>
                <li><a href="#">Testimonials </a></li>
                <li><a href="#">Title</a></li>
                <li><a href="#">Typography</a></li>
                <li><a href="#">Vendor </a></li>
                <li><a href="#">Video </a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="https://d-themes.com/buynow/riodehtml">Buy {{ siteName }}!</a></li>
      </ul>
      <!-- End MobileMenu -->
    </div>
  </div>
  <!-- sticky icons-->
  <div class="sticky-icons-wrapper">
    <div class="sticky-icon-links">
      <ul>
        <li>
          <a href="#" class="demo-toggle"
            ><i class="fas fa-home"></i><span>Demos</span></a
          >
        </li>
        <li>
          <a href="#"
            ><i class="fas fa-info-circle"></i><span>Documentation</span></a
          >
        </li>
        <li>
          <a href="https://themeforest.net/downloads/"
            ><i class="fas fa-star"></i><span>Reviews</span></a
          >
        </li>
        <li>
          <a href="https://d-themes.com/buynow/riodehtml"
            ><i class="fas fa-shopping-cart"></i><span>Buy now!</span></a
          >
        </li>
      </ul>
    </div>
    <div class="demos-list">
      <div class="demos-overlay"></div>
      <a class="demos-close" href="#"><i class="close-icon"></i></a>
      <div class="demos-content scrollable scrollable-light">
        <h3 class="demos-title">Demos</h3>
        <div class="demos"></div>
      </div>
    </div>
  </div>
  <!-- Plugins JS File -->

  <!-- Main JS File -->
</template>

<script setup>
const { cart, cartCount, cartSubtotal, removeItem } = useCart()
const { settings } = useSiteSettings()
const router = useRouter()
const searchInput = ref('')
const siteName = computed(() => settings.value.site_name || 'Riode')
const siteLogoWide = computed(
  () => settings.value.site_logo_wide_url || settings.value.site_logo_url || '/images/logo.png'
)

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}

const submitSearch = () => {
  const term = searchInput.value.trim()
  router.push({
    path: '/market-shop',
    query: {
      search: term || undefined
    }
  })
}
</script>




