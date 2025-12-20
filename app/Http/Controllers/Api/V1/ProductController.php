<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::query()->where('is_active', true)->with(['images']);

        if ($request->filled('category_id')) $q->where('category_id', (int)$request->category_id);
        if ($request->filled('sub_category_id')) $q->where('sub_category_id', (int)$request->sub_category_id);
        if ($request->filled('vendor_id')) $q->where('vendor_id', (int)$request->vendor_id);
        if ($request->filled('search')) {
            $s = trim((string)$request->search);
            $q->where(function($qq) use ($s){ $qq->where('name','like',"%$s%")->orWhere('title','like',"%$s%"); });
        }

        return ProductResource::collection($q->latest()->paginate(24));
    }

    public function show(string $slug)
    {
        $product = Product::query()->where('slug', $slug)->where('is_active', true)->with(['images','files','deliveryType'])->firstOrFail();
        return new ProductResource($product);
    }
}
