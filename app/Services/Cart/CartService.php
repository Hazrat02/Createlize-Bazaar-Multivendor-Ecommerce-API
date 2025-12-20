<?php

namespace App\Services\Cart;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class CartService
{
    private const SESSION_KEY = 'cb_cart_v1';

    public function get(): array
    {
        return Session::get(self::SESSION_KEY, [
            'vendor_id' => null,
            'items' => []
        ]);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function add(int $productId, int $qty = 1): array
    {
        $qty = max(1, $qty);
        $product = Product::query()->where('is_active', true)->findOrFail($productId);

        $cart = $this->get();

        // Single-vendor cart enforcement
        if ($cart['vendor_id'] && (int)$cart['vendor_id'] !== (int)$product->vendor_id) {
            throw ValidationException::withMessages([
                'cart' => 'Single-vendor cart: you cannot add products from another vendor.'
            ]);
        }

        $cart['vendor_id'] = $product->vendor_id;

        $items = collect($cart['items']);
        $existing = $items->firstWhere('product_id', $product->id);

        if ($existing) {
            $existing['qty'] = (int)$existing['qty'] + $qty;
            $items = $items->map(fn($i) => $i['product_id'] === $product->id ? $existing : $i);
        } else {
            $items->push([
                'product_id' => $product->id,
                'slug' => $product->slug,
                'name' => $product->title ?? $product->name,
                'vendor_id' => $product->vendor_id,
                'currency' => $product->currency,
                'unit_price' => (float)$product->final_price,
                'qty' => $qty,
            ]);
        }

        $cart['items'] = $items->values()->all();

        Session::put(self::SESSION_KEY, $cart);
        return $cart;
    }

    public function remove(int $productId): array
    {
        $cart = $this->get();
        $cart['items'] = collect($cart['items'])->reject(fn($i) => (int)$i['product_id'] === $productId)->values()->all();
        if (count($cart['items']) === 0) {
            $cart['vendor_id'] = null;
        }
        Session::put(self::SESSION_KEY, $cart);
        return $cart;
    }

    public function totals(array $cart): array
    {
        $subtotal = 0.0;
        foreach ($cart['items'] as $item) {
            $subtotal += ((float)$item['unit_price']) * ((int)$item['qty']);
        }
        return [
            'subtotal' => round($subtotal, 2),
        ];
    }
}
