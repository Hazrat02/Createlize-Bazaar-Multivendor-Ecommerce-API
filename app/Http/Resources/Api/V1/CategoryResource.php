<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image_url' => $this->image_path ? asset('storage/' . $this->image_path) : null,
            'icon_url' => $this->icon_path ? asset('storage/' . $this->icon_path) : null,
        ];
    }
}
