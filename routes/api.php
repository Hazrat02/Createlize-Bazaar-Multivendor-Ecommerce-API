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
