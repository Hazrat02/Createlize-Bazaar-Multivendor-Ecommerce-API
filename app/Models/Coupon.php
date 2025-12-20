<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code','type','value','min_order_amount','max_discount_amount',
        'start_at','end_at','usage_limit_total','usage_limit_per_user',
        'applicable_scope','applicable_ids','allowed_payment_types','is_stackable','status'
    ];

    protected $casts = [
        'value'=>'decimal:2',
        'min_order_amount'=>'decimal:2',
        'max_discount_amount'=>'decimal:2',
        'start_at'=>'datetime',
        'end_at'=>'datetime',
        'usage_limit_total'=>'integer',
        'usage_limit_per_user'=>'integer',
        'applicable_ids'=>'array',
        'is_stackable'=>'boolean',
    ];

    public function usages(){ return $this->hasMany(CouponUsage::class); }
}
