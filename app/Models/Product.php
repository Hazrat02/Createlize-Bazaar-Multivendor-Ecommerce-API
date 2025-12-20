<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id','category_id','sub_category_id','delivery_type_id',
        'name','slug','title','description','price','discount_percent','currency',
        'stock','sku','tags','meta','is_active','is_featured'
    ];

    protected $casts = [
        'price'=>'decimal:2',
        'discount_percent'=>'integer',
        'tags'=>'array',
        'meta'=>'array',
        'is_active'=>'boolean',
        'is_featured'=>'boolean',
    ];

    public function vendor(): BelongsTo { return $this->belongsTo(User::class, 'vendor_id'); }
    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function subCategory(): BelongsTo { return $this->belongsTo(SubCategory::class, 'sub_category_id'); }
    public function deliveryType(): BelongsTo { return $this->belongsTo(DeliveryType::class); }

    public function images() { return $this->hasMany(ProductImage::class); }
    public function files() { return $this->hasMany(ProductFile::class); } // instant delivery
    public function fieldOverrides() { return $this->hasMany(ProductFieldOverride::class); }

    public function getFinalPriceAttribute(): string
    {
        $price = (float)$this->price;
        if ($this->discount_percent) {
            $price = $price - ($price * ((int)$this->discount_percent / 100));
        }
        return number_format(max($price, 0), 2, '.', '');
    }
}
