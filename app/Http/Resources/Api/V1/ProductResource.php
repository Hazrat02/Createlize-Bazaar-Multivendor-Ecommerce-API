<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'delivery_type_id' => $this->delivery_type_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'currency' => $this->currency,
            'price' => (float)$this->price,
            'discount_percent' => (int)$this->discount_percent,
            'final_price' => (float)$this->final_price,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'tags' => $this->tags ?? [],
            'meta' => $this->meta ?? [],
            'is_featured' => (bool)$this->is_featured,
            'images' => $this->images->map(fn($i) => ['url' => asset('storage/'.$i->path), 'sort_order' => $i->sort_order]),
        ];
    }
}
