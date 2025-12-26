<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V2\CategoryResource;
use App\Http\Resources\Api\V2\SubCategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(
            Category::query()->where('is_active', true)->orderBy('sort_order')->get()
        );
    }

    public function subcategories(string $slug)
    {
        $category = Category::query()->where('slug', $slug)->where('is_active', true)->firstOrFail();
        return SubCategoryResource::collection(
            $category->subCategories()->where('is_active', true)->orderBy('sort_order')->get()
        );
    }
}
