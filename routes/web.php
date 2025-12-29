<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\SubCategoryAdminController;
use App\Http\Controllers\Admin\DeliveryAdminController;
use App\Http\Controllers\Admin\VendorAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\CouponAdminController;
use App\Http\Controllers\Admin\ContentAdminController;
use App\Http\Controllers\Admin\PaymentAdminController;
use App\Http\Controllers\Admin\SmtpAdminController;
use App\Http\Controllers\Admin\InvoiceAdminController;
use App\Http\Controllers\Admin\SeoAdminController;
use App\Http\Controllers\Admin\SettingAdminController;
use App\Http\Controllers\Admin\ApiDocsController;
use App\Http\Controllers\Admin\DownloadAdminController;
use App\Http\Controllers\Admin\ProfileAdminController;

// Route::get('/', fn() => redirect()->route('admin.dashboard'));
// Secure download routes (signed)
Route::middleware(['guest'])->get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::middleware(['auth','role:Admin'])->get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/admin/login', [AdminAuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [AdminAuthController::class, 'destroy'])->middleware('auth')->name('admin.logout');

Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('locale', function () {
        return redirect('/');
    })->name('locale.show');

    Route::post('locale', function (Request $request) {
        $data = $request->validate([
            'locale' => ['required', 'in:en,bn'],
        ]);

        $locale = $data['locale'];
        $request->session()->put('locale', $locale);

        $redirectTo = url()->previous() ?: '/';
        if ($redirectTo === url('/admin/locale')) {
            $redirectTo = '/';
        }

        return redirect()->to($redirectTo)->withCookie(cookie('locale', $locale, 60 * 24 * 365));
    })->name('locale');
    // Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryAdminController::class);
    Route::resource('subcategories', SubCategoryAdminController::class);
    Route::get('deliveries', [DeliveryAdminController::class, 'index'])->name('deliveries.index');
    Route::get('deliveries/create', [DeliveryAdminController::class, 'create'])->name('deliveries.create');
    Route::post('deliveries', [DeliveryAdminController::class, 'store'])->name('deliveries.store');
    Route::get('deliveries/{deliveryType}/edit', [DeliveryAdminController::class, 'edit'])->name('deliveries.edit');
    Route::put('deliveries/{deliveryType}', [DeliveryAdminController::class, 'update'])->name('deliveries.update');
    Route::delete('deliveries/{deliveryType}', [DeliveryAdminController::class, 'destroy'])->name('deliveries.destroy');
    Route::get('deliveries/{deliveryType}/fields', [DeliveryAdminController::class, 'fields'])->name('deliveries.fields.index');
    Route::get('deliveries/{deliveryType}/fields/create', [DeliveryAdminController::class, 'createField'])->name('deliveries.fields.create');
    Route::post('deliveries/types', [DeliveryAdminController::class, 'storeType'])->name('deliveries.types.store');
    Route::post('deliveries/fields', [DeliveryAdminController::class, 'storeField'])->name('deliveries.fields.store');
    Route::delete('deliveries/fields/{deliveryField}', [DeliveryAdminController::class, 'destroyField'])->name('deliveries.fields.destroy');

    Route::get('vendors', [VendorAdminController::class, 'index'])->name('vendors.index');
    Route::post('vendors', [VendorAdminController::class, 'store'])->name('vendors.store');
    Route::get('vendors/{user}', [VendorAdminController::class, 'show'])->name('vendors.show');
    Route::get('vendors/{user}/edit', [VendorAdminController::class, 'edit'])->name('vendors.edit');
    Route::put('vendors/{user}', [VendorAdminController::class, 'update'])->name('vendors.update');
    Route::put('vendors/{user}/profile', [VendorAdminController::class, 'updateProfile'])->name('vendors.profile.update');
    Route::delete('vendors/{user}/profile', [VendorAdminController::class, 'destroyProfile'])->name('vendors.profile.destroy');
    Route::post('vendors/{user}/ban', [VendorAdminController::class, 'ban'])->name('vendors.ban');
    Route::post('vendors/{user}/unban', [VendorAdminController::class, 'unban'])->name('vendors.unban');

    Route::resource('products', ProductAdminController::class);
    Route::post('products/{product}/images', [ProductAdminController::class, 'addImages'])->name('products.images.store');
    Route::delete('products/{product}/images/{image}', [ProductAdminController::class, 'removeImage'])->name('products.images.destroy');
    Route::resource('users', UserAdminController::class);
    Route::post('users/google-settings', [UserAdminController::class, 'updateGoogleSettings'])->name('users.google-settings');
    Route::post('users/{user}/ban', [UserAdminController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban', [UserAdminController::class, 'unban'])->name('users.unban');
    Route::post('users/{user}/mail', [UserAdminController::class, 'sendMail'])->name('users.mail');
    Route::get('orders/demo', [OrderAdminController::class, 'demoCreate'])->name('orders.demo.create');
    Route::post('orders/demo', [OrderAdminController::class, 'demoStore'])->name('orders.demo.store');
    Route::get('orders/demo/checkout', [OrderAdminController::class, 'demoCheckout'])->name('orders.demo.checkout');
    Route::post('orders/demo/checkout', [OrderAdminController::class, 'demoCheckoutSubmit'])->name('orders.demo.checkout.submit');
    Route::resource('orders', OrderAdminController::class)->only(['index','show','update']);
    Route::post('orders/{order}/deliveries/upload', [OrderAdminController::class, 'uploadDeliveryFile'])->name('orders.deliveries.upload');
    Route::get('orders/{order}/invoice', [OrderAdminController::class, 'invoice'])->name('orders.invoice');

    Route::resource('coupons', CouponAdminController::class);

    Route::get('content', [ContentAdminController::class, 'index'])->name('content.index');
    Route::post('content/pages', [ContentAdminController::class, 'savePages'])->name('content.pages.save');
    Route::post('content/faqs', [ContentAdminController::class, 'saveFaqs'])->name('content.faqs.save');

    Route::get('payments/uddoktapay', [PaymentAdminController::class, 'edit'])->name('payments.uddoktapay.edit');
    Route::post('payments/uddoktapay', [PaymentAdminController::class, 'update'])->name('payments.uddoktapay.update');

    Route::get('smtp', [SmtpAdminController::class, 'edit'])->name('smtp.edit');
    Route::post('smtp', [SmtpAdminController::class, 'update'])->name('smtp.update');

    Route::get('invoice-template', [InvoiceAdminController::class, 'edit'])->name('invoice.edit');
    Route::post('invoice-template', [InvoiceAdminController::class, 'update'])->name('invoice.update');

    Route::get('seo', [SeoAdminController::class, 'edit'])->name('seo.edit');
    Route::post('seo', [SeoAdminController::class, 'update'])->name('seo.update');

    Route::get('settings', [SettingAdminController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingAdminController::class, 'update'])->name('settings.update');

    Route::get('api-docs', [ApiDocsController::class, 'index'])->name('api-docs');

    Route::get('profile', [ProfileAdminController::class, 'edit'])->name('profile.edit');
    Route::post('profile', [ProfileAdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/password', [ProfileAdminController::class, 'updatePassword'])->name('profile.password');
});

Route::match(['get','post'], '/payment/success', [\App\Http\Controllers\PaymentCallbackController::class, 'success'])
    ->name('payment.success');
Route::match(['get','post'], '/payment/cancel', [\App\Http\Controllers\PaymentCallbackController::class, 'cancel'])
    ->name('payment.cancel');

// Secure download routes (signed)
Route::middleware('auth')->get('/downloads/{token}', 


[DownloadAdminController::class, 'download'])
    ->name('downloads.get')->middleware('signed');
