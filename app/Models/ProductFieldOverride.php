<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFieldOverride extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id','action','field_name','definition'
    ];

    protected $casts = [
        'definition' => 'array',
    ];

    public function product() { return $this->belongsTo(Product::class); }
}
