<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number','customer_id','vendor_id','subtotal','discount_total','total',
        'currency','exchange_rate_used','payment_status','order_status','delivery_type_id',
        'coupon_id','coupon_code','coupon_discount_amount','coupon_discount_type','payment_method',
        'payment_invoice_id'
    ];

    protected $casts = [
        'subtotal'=>'decimal:2',
        'discount_total'=>'decimal:2',
        'total'=>'decimal:2',
        'exchange_rate_used'=>'decimal:6',
    ];

    public function customer() { return $this->belongsTo(User::class, 'customer_id'); }
    public function vendor() { return $this->belongsTo(User::class, 'vendor_id'); }
    public function deliveryType() { return $this->belongsTo(DeliveryType::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function requiredData() { return $this->hasMany(OrderRequiredData::class); }
    public function deliveries() { return $this->hasMany(OrderDelivery::class); }
}
