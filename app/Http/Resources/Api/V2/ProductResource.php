<?php

namespace App\Http\Resources\Api\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $images = $this->images
            ->sortBy('sort_order')
            ->values()
            ->map(fn($image) => [
                'url' => asset('storage/' . $image->path),
                'sort_order' => $image->sort_order,
            ]);

        $primaryImage = $images->first()['url'] ?? null;

        $labels = [];
        if ((int)$this->discount_percent > 0) {
            $labels[] = ['text' => 'sale', 'class' => 'product-label label-sale'];
        }
        if ((bool)$this->is_featured) {
            $labels[] = ['text' => 'new', 'class' => 'product-label label-new'];
        }

        $descriptionSource = $this->description ?: ($this->title ?: $this->name);
        $shortDesc = Str::limit(trim(strip_tags((string)$descriptionSource)), 120);
        $meta = $this->meta ?? [];

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'category' => $this->category?->name ?? 'Uncategorized',
            'image' => $primaryImage,
            'price' => (float)$this->final_price,
            'oldPrice' => (int)$this->discount_percent > 0 ? (float)$this->price : null,
            'ratingPercent' => (int)($meta['rating_percent'] ?? 80),
            'reviewCount' => (int)($meta['review_count'] ?? 0),
            'sku' => $this->sku ?: ('SKU-' . str_pad((string)$this->id, 4, '0', STR_PAD_LEFT)),
            'brand' => $this->vendor?->name ?? 'Createlize',
            'shortDesc' => $shortDesc ?: $this->name,
            'labels' => $labels,
            'href' => '/product/' . $this->slug,
            'description' => $this->description,
            'images' => $images,
            'colors' => array_values(array_filter($meta['colors'] ?? [])),
            'sizes' => array_values(array_filter($meta['sizes'] ?? [])),
            'plans' => array_values(array_filter($meta['plans'] ?? [])),
        ];
    }
}
