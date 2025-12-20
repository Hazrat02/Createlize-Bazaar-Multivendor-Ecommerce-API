<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryField extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_type_id','title','name','type','required','placeholder','options','sort_order'
    ];

    protected $casts = [
        'required'=>'boolean',
        'options'=>'array',
    ];

    public function deliveryType()
    {
        return $this->belongsTo(DeliveryType::class);
    }
}
