<?php

namespace App\Services\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderRequiredData;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\Coupons\CouponService;
use App\Services\Payments\UddoktaPayService;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(
        private CartService $cart,
        private CouponService $coupons,
        private RequiredFieldsBuilder $fieldsBuilder,
        private UddoktaPayService $uddoktaPay,
        private SettingsService $settings,
    ) {}

    public function checkout(User $user, array $payload): array
    {
        $cart = $this->cart->get();
        if (empty($cart['items'])) {
            throw ValidationException::withMessages(['cart' => 'Cart is empty.']);
        }

        // Ensure all items same vendor already enforced by CartService, but re-check
        $vendorId = (int)$cart['vendor_id'];
        if (!$vendorId) {
            throw ValidationException::withMessages(['cart' => 'Invalid cart vendor.']);
        }

        $items = $cart['items'];
        $firstProduct = Product::query()->findOrFail((int)$items[0]['product_id']);
        $deliveryType = $firstProduct->deliveryType;
        $deliveryKey = $deliveryType->key; // online_not_instant, instant, physical_prepaid, cod

        // payment type decision
        $isCod = ($deliveryKey === 'cod');
        $paymentType = $isCod ? 'cod' : 'online';

        $totals = $this->cart->totals($cart);
        $subtotal = (float)$totals['subtotal'];

        // Coupon
        $couponCode = $payload['coupon_code'] ?? null;
        $couponData = null;
        if ($couponCode) {
            $couponData = $this->coupons->validateAndCompute($couponCode, $user, $items, $subtotal, $paymentType);
        }

        $discount = $couponData['discount_amount'] ?? 0.0;
        $total = max($subtotal - $discount, 0);

        // Required fields (delivery-based + product overrides)
        // Single-vendor cart implies we can use the first product to render fields, as delivery type is per product.
        $requiredFields = $this->fieldsBuilder->build($firstProduct);

        $requiredData = $payload['required_data'] ?? [];
        $requiredFiles = $payload['required_files'] ?? [];
        $this->validateRequiredData($requiredFields, $requiredData, $requiredFiles);

        return DB::transaction(function () use ($user, $vendorId, $items, $subtotal, $discount, $total, $firstProduct, $deliveryType, $couponData, $paymentType, $requiredFields, $requiredData, $requiredFiles, $isCod) {

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $user->id,
                'vendor_id' => $vendorId,
                'subtotal' => $subtotal,
                'discount_total' => $discount,
                'total' => $total,
                'currency' => $firstProduct->currency,
                'exchange_rate_used' => (float)$this->settings->get('currency', 'exchange_rate_usd_to_bdt', 110.0),
                'payment_status' => $isCod ? 'unpaid' : 'pending',
                'order_status' => 'created',
                'delivery_type_id' => $deliveryType->id,
                'coupon_id' => $couponData['coupon']->id ?? null,
                'coupon_code' => $couponData['coupon']->code ?? null,
                'coupon_discount_amount' => $couponData['discount_amount'] ?? null,
                'coupon_discount_type' => $couponData['discount_type'] ?? null,
                'payment_method' => $isCod ? 'cod' : 'uddoktapay'
            ]);

            foreach ($items as $item) {
                $product = Product::query()->findOrFail((int)$item['product_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->title ?? $product->name,
                    'unit_price' => (float)$item['unit_price'],
                    'qty' => (int)$item['qty'],
                    'line_total' => ((float)$item['unit_price']) * ((int)$item['qty']),
                    'meta' => [
                        'delivery_type_key' => $deliveryType->key,
                        'currency' => $product->currency,
                    ],
                ]);
            }

            // Save submitted required data snapshot
            foreach ($requiredFields as $field) {
                $name = $field['name'];
                $val = $requiredData[$name] ?? null;
                $filePath = null;

                if (($field['type'] ?? '') === 'file') {
                    $file = $requiredFiles[$name] ?? null;
                    if ($file) {
                        $filePath = $file->store('orders/required', 'public');
                    }
                }

                OrderRequiredData::create([
                    'order_id' => $order->id,
                    'field_title' => $field['title'],
                    'field_name' => $name,
                    'field_type' => $field['type'],
                    'value' => is_scalar($val) ? (string)$val : null,
                    'file_path' => $filePath,
                ]);
            }

            // clear cart after creating order
            $this->cart->clear();

            if ($isCod) {
                return [
                    'order_number' => $order->order_number,
                    'payment' => ['type' => 'cod'],
                ];
            }

            // Create payment at UddoktaPay and return payment_url
            $redirectUrl = (string)($payload['redirect_url'] ?? $this->settings->get('payment_uddoktapay', 'redirect_url', config('app.url')));
            $cancelUrl = (string)($payload['cancel_url'] ?? $this->settings->get('payment_uddoktapay', 'cancel_url', config('app.url')));

            $charge = $this->uddoktaPay->createCharge([
                'full_name' => $user->name,
                'email' => $user->email,
                'amount' => (string)number_format($order->total, 2, '.', ''),
                'metadata' => [
                    'order_number' => $order->order_number,
                    'user_id' => (string)$user->id,
                ],
                'redirect_url' => rtrim($redirectUrl, '/') . '/payment/success',
                'cancel_url' => rtrim($cancelUrl, '/') . '/payment/cancel',
            ]);

            $order->payment_invoice_id = $charge['invoice_id'] ?? null;
            $order->save();

            return [
                'order_number' => $order->order_number,
                'payment' => [
                    'type' => 'uddoktapay',
                    'payment_url' => $charge['payment_url'] ?? null,
                ],
            ];
        });
    }

    private function validateRequiredData(array $requiredFields, array $requiredData, array $requiredFiles): void
    {
        foreach ($requiredFields as $field) {
            if (!($field['required'] ?? false)) continue;
            $name = $field['name'];
            $val = $requiredData[$name] ?? null;
            $file = $requiredFiles[$name] ?? null;
            $isFile = ($field['type'] ?? '') === 'file';
            if ($isFile && !$file) {
                throw ValidationException::withMessages([
                    "required_data.$name" => "{$field['title']} is required."
                ]);
            }
            if (!$isFile && ($val === null || $val === '')) {
                throw ValidationException::withMessages([
                    "required_data.$name" => "{$field['title']} is required."
                ]);
            }
        }
    }

    private function generateOrderNumber(): string
    {
        // CBZ-YYYYMMDD-XXXXXXXX
        return 'CBZ-' . now()->format('Ymd') . '-' . strtoupper(Str::random(8));
    }
}
