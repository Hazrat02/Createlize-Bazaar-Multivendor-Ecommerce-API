<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 100,
            'max_discount_amount' => 200,
            'start_at' => now()->subDay(),
            'end_at' => now()->addDays(30),
            'usage_limit_total' => 1000,
            'usage_limit_per_user' => 2,
            'applicable_scope' => 'all_products',
            'allowed_payment_types' => 'both',
            'is_stackable' => false,
            'status' => 'active'
        ]);

        Coupon::create([
            'code' => 'COD50',
            'type' => 'fixed',
            'value' => 50,
            'min_order_amount' => 300,
            'start_at' => now()->subDay(),
            'end_at' => now()->addDays(30),
            'usage_limit_total' => 100,
            'usage_limit_per_user' => 1,
            'applicable_scope' => 'all_products',
            'allowed_payment_types' => 'cod_only',
            'is_stackable' => false,
            'status' => 'active'
        ]);
    }
}
