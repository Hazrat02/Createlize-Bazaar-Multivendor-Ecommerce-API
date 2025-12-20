<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','status','notes','delivered_at'];

    protected $casts = ['delivered_at'=>'datetime'];

    public function order(){ return $this->belongsTo(Order::class); }
    public function files(){ return $this->hasMany(OrderDeliveryFile::class); }
}
