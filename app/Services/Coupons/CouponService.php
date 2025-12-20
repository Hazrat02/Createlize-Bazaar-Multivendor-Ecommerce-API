<?php

namespace App\Services\Coupons;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class CouponService
{
    public function validateAndCompute(
        string $code,
        User $user,
        array $cartItems,
        float $subtotal,
        string $paymentType // online_only|cod_only|both
    ): array {
        $coupon = Coupon::query()
            ->where('code', strtoupper(trim($code)))
            ->where('status', 'active')
            ->first();

        if (!$coupon) {
            throw ValidationException::withMessages(['coupon_code' => 'Invalid coupon.']);
        }

        $now = Carbon::now();
        if ($coupon->start_at && $now->lt($coupon->start_at)) {
            throw ValidationException::withMessages(['coupon_code' => 'Coupon is not active yet.']);
        }
        if ($coupon->end_at && $now->gt($coupon->end_at)) {
            throw ValidationException::withMessages(['coupon_code' => 'Coupon has expired.']);
        }

        if ($coupon->allowed_payment_types !== 'both') {
            if ($coupon->allowed_payment_types === 'online_only' && $paymentType === 'cod') {
                throw ValidationException::withMessages(['coupon_code' => 'Coupon not allowed for COD orders.']);
            }
            if ($coupon->allowed_payment_types === 'cod_only' && $paymentType !== 'cod') {
                throw ValidationException::withMessages(['coupon_code' => 'Coupon allowed for COD only.']);
            }
        }

        if ($coupon->min_order_amount && $subtotal < (float)$coupon->min_order_amount) {
            throw ValidationException::withMessages(['coupon_code' => 'Order amount is below minimum for this coupon.']);
        }

        // Usage limits
        if ($coupon->usage_limit_total) {
            $usedTotal = CouponUsage::query()->where('coupon_id', $coupon->id)->count();
            if ($usedTotal >= (int)$coupon->usage_limit_total) {
                throw ValidationException::withMessages(['coupon_code' => 'Coupon usage limit reached.']);
            }
        }

        if ($coupon->usage_limit_per_user) {
            $usedUser = CouponUsage::query()->where('coupon_id', $coupon->id)->where('user_id', $user->id)->count();
            if ($usedUser >= (int)$coupon->usage_limit_per_user) {
                throw ValidationException::withMessages(['coupon_code' => 'You already used this coupon maximum times.']);
            }
        }

        // Scope validation
        $this->validateScope($coupon, $cartItems);

        // Compute discount
        $discount = 0.0;
        if ($coupon->type === 'percentage') {
            $discount = $subtotal * ((float)$coupon->value / 100.0);
        } else {
            $discount = (float)$coupon->value;
        }

        if ($coupon->max_discount_amount) {
            $discount = min($discount, (float)$coupon->max_discount_amount);
        }
        $discount = min($discount, $subtotal);
        $discount = round($discount, 2);

        return [
            'coupon' => $coupon,
            'discount_amount' => $discount,
            'discount_type' => $coupon->type,
        ];
    }

    private function validateScope(Coupon $coupon, array $cartItems): void
    {
        $scope = $coupon->applicable_scope;
        $ids = $coupon->applicable_ids ?? [];

        if ($scope === 'all_products') return;

        $productIds = collect($cartItems)->pluck('product_id')->map(fn($v)=>(int)$v)->all();
        $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

        $ok = false;

        foreach ($productIds as $pid) {
            $p = $products->get($pid);
            if (!$p) continue;

            if ($scope === 'specific_products' && in_array($p->id, $ids, true)) $ok = true;
            if ($scope === 'vendor' && in_array($p->vendor_id, $ids, true)) $ok = true;
            if ($scope === 'category' && in_array($p->category_id, $ids, true)) $ok = true;
            if ($scope === 'sub_category' && in_array($p->sub_category_id, $ids, true)) $ok = true;
        }

        if (!$ok) {
            throw ValidationException::withMessages(['coupon_code' => 'Coupon not applicable to items in cart.']);
        }
    }
}
