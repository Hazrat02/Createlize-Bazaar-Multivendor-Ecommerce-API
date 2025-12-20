<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDeliveryFile extends Model
{
    use HasFactory;

    protected $fillable = ['order_delivery_id','path','original_name','mime','size'];

    public function delivery(){ return $this->belongsTo(OrderDelivery::class, 'order_delivery_id'); }
}
