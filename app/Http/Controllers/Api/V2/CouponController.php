<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartService;
use App\Services\Coupons\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(private CartService $cart, private CouponService $coupons) {}

    public function validateCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => ['required', 'string', 'max:50'],
            'payment_type' => ['nullable', 'in:online,cod'],
        ]);

        $cart = $this->cart->get();
        $totals = $this->cart->totals($cart);

        $user = $request->user() ?? \App\Models\User::query()->where('email', 'guest@createlize.org')->first();
        if (!$user) {
            return response()->json(['message' => 'Auth required to validate coupon'], 401);
        }

        $result = $this->coupons->validateAndCompute(
            $request->coupon_code,
            $user,
            $cart['items'] ?? [],
            (float)$totals['subtotal'],
            $request->input('payment_type', 'online')
        );

        return response()->json([
            'coupon_code' => $result['coupon']->code,
            'discount_amount' => $result['discount_amount'],
            'discount_type' => $result['discount_type'],
        ]);
    }
}
