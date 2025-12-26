<template>
  <main class="main checkout">
			<div class="page-content pt-7 pb-10 mb-10">
				<div class="step-by pr-4 pl-4">
					<h3 class="title title-simple title-step"><NuxtLink to="/cart">1. Shopping Cart</NuxtLink></h3>
					<h3 class="title title-simple title-step active"><NuxtLink to="/checkout">2. Checkout</NuxtLink></h3>
					<h3 class="title title-simple title-step"><a href="#">3. Order Complete</a></h3>
				</div>
				<div class="container mt-7">
					<div class="card accordion">
						<div class="alert alert-light alert-primary alert-icon mb-4 card-header">
							<i class="fas fa-exclamation-circle"></i>
							<span class="text-body">Returning customer?</span>
							<a href="#" class="text-primary" data-toggle="login-modal">Click here to login</a>
						</div>
						<div class="alert-body collapsed" id="alert-body1">
							<p>If you have shopped with us before, please enter your details below.
								If you are a new customer, please proceed to the Billing section.</p>
							<div class="row cols-md-2">
								<form class="mb-4 mb-md-0">
									<label for="username">Username Or Email *</label>
									<input type="text" class="input-text form-control mb-0" name="username"
										id="username" autocomplete="username">
								</form>
								<form class="mb-4 mb-md-0">
									<label for="password">Password *</label>
									<input class="input-text form-control mb-0" type="password" name="password"
										id="password" autocomplete="current-password">
								</form>
							</div>
							<div class="checkbox d-flex align-items-center justify-content-between">
								<div class="form-checkbox pt-0 mb-0">
									<input type="checkbox" class="custom-checkbox" id="signin-remember"
										name="signin-remember" />
									<label class="form-control-label" for="signin-remember">Remember
										Me</label>
								</div>
								<a href="#" class="lost-link">Lost your password?</a>
							</div>
							<div class="link-group">
								<a href="#" class="btn btn-dark btn-rounded mb-4">Login</a>
								<span class="d-inline-block text-body font-weight-semi-bold">or Login With</span>
								<div class="social-links mb-4">
									<a href="#" class="social-link social-google fab fa-google"></a>
									<a href="#" class="social-link social-facebook fab fa-facebook-f"></a>
									<a href="#" class="social-link social-twitter fab fa-twitter"></a>
								</div>
							</div>
						</div>
					</div>
					<div class="card accordion">
						<div class="alert alert-light alert-primary alert-icon mb-4 card-header">
							<i class="fas fa-exclamation-circle"></i>
							<span class="text-body">Have a coupon?</span>
							<a href="#alert-body2" class="text-primary">Click here to enter your code</a>
						</div>
						<div class="alert-body collapsed" id="alert-body2">
							<p>If you have a coupon code, please apply it below.</p>
							<div class="check-coupon-box d-flex">
								<input v-model="couponCode" type="text" name="coupon_code"
									class="input-text form-control text-grey ls-m mr-4 mb-4" id="coupon_code"
									placeholder="Coupon code">
								<button type="button" class="btn btn-dark btn-rounded btn-outline mb-4"
									:disabled="couponLoading" @click.prevent="applyCoupon">
									{{ couponLoading ? 'Applying...' : 'Apply Coupon' }}
								</button>
							</div>
							<p v-if="couponError" class="text-danger mb-0">{{ couponError }}</p>
						</div>
					</div>
					<form action="#" class="form" @submit.prevent="handleCheckout">
						<div class="row">
							<div class="col-lg-7 mb-6 mb-lg-0 pr-lg-4">
								<h3 class="title title-simple text-left text-uppercase">Billing Details</h3>
								<div class="row">
									<div class="col-xs-6">
										<label>First Name *</label>
										<input type="text" class="form-control" name="first-name" required="" />
									</div>
									<div class="col-xs-6">
										<label>Last Name *</label>
										<input type="text" class="form-control" name="last-name" required="" />
									</div>
								</div>
								<label>Company Name (Optional)</label>
								<input type="text" class="form-control" name="company-name" required="" />
								<label>Country / Region *</label>
								<div class="select-box">
									<select name="country" class="form-control">
										<option value="us" selected>United States (US)</option>
										<option value="uk"> United Kingdom</option>
										<option value="fr">France</option>
										<option value="aus">Austria</option>
									</select>
								</div>
								<label>Street Address *</label>
								<input type="text" class="form-control" name="address1" required=""
									placeholder="House number and street name" />
								<input type="text" class="form-control" name="address2" required=""
									placeholder="Apartment, suite, unit, etc. (optional)" />
								<div class="row">
									<div class="col-xs-6">
										<label>Town / City *</label>
										<input type="text" class="form-control" name="city" required="" />
									</div>
									<div class="col-xs-6">
										<label>State *</label>
										<input type="text" class="form-control" name="state" required="" />
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<label>ZIP *</label>
										<input type="text" class="form-control" name="zip" required="" />
									</div>
									<div class="col-xs-6">
										<label>Phone *</label>
										<input type="text" class="form-control" name="phone" required="" />
									</div>
								</div>
								<label>Email Address *</label>
								<input type="text" class="form-control" name="email-address" required="" />
								<div class="form-checkbox mb-0">
									<input type="checkbox" class="custom-checkbox" id="create-account"
										name="create-account">
									<label class="form-control-label ls-s" for="create-account">Create an
										account?</label>
								</div>
								<div class="form-checkbox mb-6">
									<input type="checkbox" class="custom-checkbox" id="different-address"
										name="different-address">
									<label class="form-control-label ls-s" for="different-address">Ship to a different
										address?</label>
								</div>
								<h2 class="title title-simple text-uppercase text-left">Additional Information</h2>
								<label>Order Notes (Optional)</label>
								<textarea class="form-control pb-2 pt-2 mb-0" cols="30" rows="5"
									placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
								<div v-if="requiredFields.length" class="mt-6">
									<h2 class="title title-simple text-uppercase text-left">Required Information</h2>
									<div class="row">
										<div v-for="field in requiredFields" :key="field.name" class="col-md-6">
											<div class="input-style-1">
												<label>
													{{ field.title }}
													<span v-if="field.required" class="text-danger">*</span>
												</label>
												<input
													v-if="field.type === 'text' || field.type === 'email' || field.type === 'phone'"
													v-model="requiredValues[field.name]"
													:type="field.type === 'phone' ? 'text' : field.type"
													class="form-control"
													:placeholder="field.placeholder || ''"
												/>
												<textarea
													v-else-if="field.type === 'textarea'"
													v-model="requiredValues[field.name]"
													class="form-control"
													rows="3"
													:placeholder="field.placeholder || ''"
												></textarea>
												<div v-else-if="field.type === 'select'" class="select-box">
													<select v-model="requiredValues[field.name]" class="form-control">
														<option value="">Select an option</option>
														<option v-for="option in field.options || []" :key="option" :value="option">
															{{ option }}
														</option>
													</select>
												</div>
												<input
													v-else-if="field.type === 'file'"
													type="file"
													class="form-control"
													@change="onRequiredFileChange($event, field.name)"
												/>
											</div>
										</div>
									</div>
								</div>
							</div>
							<aside class="col-lg-5 sticky-sidebar-wrapper">
								<div class="sticky-sidebar mt-1" data-sticky-options="{'bottom': 50}">
									<div class="summary pt-5">
										<h3 class="title title-simple text-left text-uppercase">Your Order</h3>
										<table class="order-table">
											<thead>
												<tr>
													<th>Product</th>
													<th></th>
												</tr>
											</thead>
											<tbody>
                                                <tr v-if="!cart.length">
                                                    <td class="product-name text-muted" colspan="2">No items in cart.</td>
                                                </tr>
                                                <tr v-for="item in cart" :key="item.id">
                                                    <td class="product-name">
                                                        {{ item.name }}
                                                        <span class="product-quantity">A-&nbsp;{{ item.qty }}</span>
                                                    </td>
                                                    <td class="product-total text-body">{{ formatPrice(item.price * item.qty) }}</td>
                                                </tr>
                                                <tr class="summary-subtotal">
                                                    <td>
                                                        <h4 class="summary-subtitle">Subtotal</h4>
                                                    </td>
                                                    <td class="summary-subtotal-price pb-0 pt-0">{{ formatPrice(cartSubtotal) }}</td>
                                                </tr>
                                                <tr v-if="discountAmount > 0">
                                                    <td>
                                                        <h4 class="summary-subtitle">Discount</h4>
                                                    </td>
                                                    <td class="summary-subtotal-price pb-0 pt-0">-{{ formatPrice(discountAmount) }}</td>
                                                </tr>
                                                <tr class="sumnary-shipping shipping-row-last">
                                                    <td colspan="2">
                                                        <h4 class="summary-subtitle">Calculate Shipping</h4>
                                                        <ul>
                                                            <li>
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="flat_rate" name="shipping"
                                                                        class="custom-control-input" checked>
                                                                    <label class="custom-control-label"
                                                                        for="flat_rate">Flat rate</label>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="free-shipping"
                                                                        name="shipping" class="custom-control-input">
                                                                    <label class="custom-control-label"
                                                                        for="free-shipping">Free
                                                                        shipping</label>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <div class="custom-radio">
                                                                    <input type="radio" id="local_pickup"
                                                                        name="shipping" class="custom-control-input">
                                                                    <label class="custom-control-label"
                                                                        for="local_pickup">Local pickup</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                <tr class="summary-total">
                                                    <td class="pb-0">
                                                        <h4 class="summary-subtitle">Total</h4>
                                                    </td>
                                                    <td class=" pt-0 pb-0">
                                                        <p class="summary-total-price ls-s text-primary">{{ formatPrice(cartTotal) }}</p>
                                                    </td>
                                                </tr>
</tbody>
										</table>
										<div class="payment accordion radio-type">
											<h4 class="summary-subtitle ls-m pb-3">Payment Methods</h4>
											<div class="card">
												<div class="card-header">
													<a href="#collapse1"
														class="collapse text-body text-normal ls-m">Check payments
													</a>
												</div>
												<div id="collapse1" class="expanded" style="display: block;">
													<div class="card-body ls-m">
														Please send a check to Store Name, Store Street,
														Store Town, Store State / County, Store Postcode.
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header">
													<a href="#collapse2" class="expand text-body text-normal ls-m">Cash
														on delivery</a>
												</div>
												<div id="collapse2" class="collapsed">
													<div class="card-body ls-m">
														Pay with cash upon delivery.
													</div>
												</div>
											</div>
										</div>
										<div class="form-checkbox mt-4 mb-5">
											<input type="checkbox" class="custom-checkbox" id="terms-condition"
												name="terms-condition" />
											<label class="form-control-label" for="terms-condition">
												I have read and agree to the website <a href="#">terms and conditions
												</a>*
											</label>
										</div>
										<p v-if="checkoutError" class="text-danger mb-3">{{ checkoutError }}</p>
										<button type="submit" class="btn btn-dark btn-rounded btn-order" :disabled="checkoutLoading">
											{{ checkoutLoading ? 'Processing...' : 'Place Order' }}
										</button>
									</div>
								</div>
							</aside>
						</div>
					</form>
				</div>
			</div>
			
		</main>
</template>

<script setup>
const { cart, cartSubtotal } = useCart()
const { ensureLoggedIn, openLoginModal } = useAuth()
const config = useRuntimeConfig()
const checkoutLoading = ref(false)
const checkoutError = ref('')
const couponCode = ref('')
const couponLoading = ref(false)
const couponError = ref('')
const discountAmount = ref(0)
const cartSynced = ref(false)
const requiredFields = ref([])
const requiredValues = ref({})
const requiredFiles = ref({})

const cartTotal = computed(() => Math.max(cartSubtotal.value - discountAmount.value, 0))

const syncCartToServer = async () => {
  if (cartSynced.value) return
  await $fetch(`${config.public.apiBase}/cart/clear`, {
    method: 'POST',
    credentials: 'include'
  })

  for (const item of cart.value) {
    await $fetch(`${config.public.apiBase}/cart/add`, {
      method: 'POST',
      credentials: 'include',
      body: {
        product_id: item.id,
        qty: item.qty
      }
    })
  }

  cartSynced.value = true
}

const loadRequiredFields = async () => {
  if (!cart.value.length) {
    requiredFields.value = []
    requiredValues.value = {}
    requiredFiles.value = {}
    return
  }

  await syncCartToServer()

  const response = await $fetch(`${config.public.apiBase}/checkout/fields`, {
    method: 'GET',
    credentials: 'include'
  })

  requiredFields.value = response?.fields ?? []
  const nextValues = {}
  for (const field of requiredFields.value) {
    nextValues[field.name] = requiredValues.value[field.name] ?? ''
  }
  requiredValues.value = nextValues
}

const applyCoupon = async () => {
  if (!couponCode.value.trim()) {
    couponError.value = 'Please enter a coupon code.'
    return
  }

  couponLoading.value = true
  couponError.value = ''

  try {
    await syncCartToServer()
    const response = await $fetch(`${config.public.apiBase}/coupons/validate`, {
      method: 'POST',
      credentials: 'include',
      body: {
        coupon_code: couponCode.value.trim(),
        payment_type: 'online'
      }
    })
    discountAmount.value = Number(response?.discount_amount || 0)
  } catch (error) {
    discountAmount.value = 0
    couponError.value = 'Invalid coupon code.'
  } finally {
    couponLoading.value = false
  }
}

const onRequiredFileChange = (event, fieldName) => {
  const file = event.target.files?.[0] || null
  requiredFiles.value[fieldName] = file
}

const buildCheckoutFormData = () => {
  const formData = new FormData()
  if (couponCode.value.trim()) {
    formData.append('coupon_code', couponCode.value.trim())
  }

  Object.entries(requiredValues.value || {}).forEach(([key, value]) => {
    formData.append(`required_data[${key}]`, value ?? '')
  })

  Object.entries(requiredFiles.value || {}).forEach(([key, file]) => {
    if (file) {
      formData.append(`required_files[${key}]`, file)
    }
  })

  return formData
}

const handleCheckout = async () => {
  if (!cart.value.length) {
    checkoutError.value = 'Cart is empty.'
    return
  }

  const loggedIn = await ensureLoggedIn()
  if (!loggedIn) {
    checkoutError.value = 'Please sign in to checkout.'
    openLoginModal('login')
    return
  }

  checkoutLoading.value = true
  checkoutError.value = ''

  try {
    await syncCartToServer()
    const body = buildCheckoutFormData()

    const response = await $fetch(`${config.public.apiBase}/checkout`, {
      method: 'POST',
      credentials: 'include',
      body
    })

    const paymentUrl = response?.payment?.payment_url
    if (paymentUrl) {
      window.location.href = paymentUrl
      return
    }
    checkoutError.value = 'Payment URL not returned. Please contact support.'
  } catch (error) {
    const status = error?.statusCode || error?.status
    if (status === 401) {
      checkoutError.value = 'Please sign in to checkout.'
      openLoginModal('login')
      return
    }
    checkoutError.value = 'Checkout failed. Please try again.'
  } finally {
    checkoutLoading.value = false
  }
}

watch(
  cart,
  () => {
    cartSynced.value = false
    discountAmount.value = 0
    couponError.value = ''
  },
  { deep: true }
)

onMounted(() => {
  void loadRequiredFields()
})

const formatPrice = (value) => {
  const number = Number(value) || 0
  return `$${number.toFixed(2)}`
}

useHead({
  bodyAttrs: {}
})
definePageMeta({
  layout: 'riode'
})
</script>




