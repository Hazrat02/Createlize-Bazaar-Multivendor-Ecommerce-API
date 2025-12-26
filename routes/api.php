<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\CmsController;
use App\Http\Controllers\Api\V1\VendorController;
use App\Http\Controllers\Api\V1\CouponController;
use App\Http\Controllers\Api\V2\ProductController as ProductControllerV2;
use App\Http\Controllers\Api\V2\CategoryController as CategoryControllerV2;
use App\Http\Controllers\Api\V2\VendorController as VendorControllerV2;
use App\Http\Controllers\Api\V2\SettingController as SettingControllerV2;
use App\Http\Controllers\Api\V2\CartController as CartControllerV2;
use App\Http\Controllers\Api\V2\CheckoutController as CheckoutControllerV2;
use App\Http\Controllers\Api\V2\CouponController as CouponControllerV2;
use App\Http\Controllers\Api\V2\AuthController as AuthControllerV2;
use App\Http\Controllers\Api\V2\OrderController as OrderControllerV2;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    });

    Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me']);

    // Catalog
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}/subcategories', [CategoryController::class, 'subcategories']);
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);

    // Cart (session-based; no DB)
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'get']);
    Route::post('/cart/remove', [CartController::class, 'remove']);
    Route::post('/cart/clear', [CartController::class, 'clear']);
 
    // Coupons
    Route::post('/coupons/validate', [CouponController::class, 'validateCoupon']);

    // Checkout & Orders
    Route::middleware('auth:sanctum')->post('/checkout', [CheckoutController::class, 'checkout']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order_number}', [OrderController::class, 'show']);
        Route::get('/orders/{order_number}/downloads', [OrderController::class, 'downloads']);

        // Vendor
        Route::middleware('role:Vendor')->get('/vendor/orders', [VendorController::class, 'orders']);
        Route::middleware('role:Vendor')->get('/vendor/products', [VendorController::class, 'products']);
    });

    // CMS
    Route::get('/page/{key}', [CmsController::class, 'page']);
    Route::get('/faqs', [CmsController::class, 'faqs']);
    Route::post('/contact', [CmsController::class, 'contact']);
});

Route::prefix('v2')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthControllerV2::class, 'register']);
        Route::post('/login', [AuthControllerV2::class, 'login']);
        Route::get('/google/redirect', [AuthControllerV2::class, 'googleRedirect'])
            ->middleware('web')
            ->name('api.v2.auth.google.redirect');
        Route::get('/google/callback', [AuthControllerV2::class, 'googleCallback'])
            ->middleware('web')
            ->name('api.v2.auth.google.callback');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/auth/me', [AuthControllerV2::class, 'me']);
        Route::post('/auth/logout', [AuthControllerV2::class, 'logout']);
        Route::get('/orders', [OrderControllerV2::class, 'index']);
        Route::get('/orders/{order_number}', [OrderControllerV2::class, 'show']);
        Route::get('/orders/{order_number}/downloads', [OrderControllerV2::class, 'downloads']);
    });

    Route::get('/products', [ProductControllerV2::class, 'index']);
    Route::get('/products/{slug}', [ProductControllerV2::class, 'show']);
    Route::get('/categories', [CategoryControllerV2::class, 'index']);
    Route::get('/categories/{slug}/subcategories', [CategoryControllerV2::class, 'subcategories']);
    Route::get('/vendors/top-weekly', [VendorControllerV2::class, 'topWeekly']);
    Route::get('/settings', [SettingControllerV2::class, 'general']);
    Route::post('/cart/add', [CartControllerV2::class, 'add']);
    Route::get('/cart', [CartControllerV2::class, 'get']);
    Route::post('/cart/remove', [CartControllerV2::class, 'remove']);
    Route::post('/cart/clear', [CartControllerV2::class, 'clear']);
    Route::post('/coupons/validate', [CouponControllerV2::class, 'validateCoupon']);
    Route::get('/checkout/fields', [CheckoutControllerV2::class, 'fields']);
    Route::middleware('auth:sanctum')->post('/checkout', [CheckoutControllerV2::class, 'checkout']);
});
