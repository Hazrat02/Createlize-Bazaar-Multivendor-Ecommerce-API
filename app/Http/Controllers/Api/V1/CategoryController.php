<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Http\Resources\Api\V1\SubCategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(
            Category::query()->where('is_active', true)->orderBy('sort_order')->paginate(20)
        );
    }

    public function subcategories(string $slug)
    {
        $category = Category::query()->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return SubCategoryResource::collection($category->subCategories()->where('is_active', true)->orderBy('sort_order')->get());
    }
}
