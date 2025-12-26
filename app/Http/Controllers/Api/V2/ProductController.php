<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V2\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int)($request->query('per_page') ?? $request->query('limit') ?? 48);
        $perPage = max(1, min($perPage, 200));

        $q = Product::query()
            ->where('is_active', true)
            ->with(['images', 'category', 'vendor']);

        if ($request->filled('category_id')) $q->where('category_id', (int)$request->category_id);
        if ($request->filled('sub_category_id')) $q->where('sub_category_id', (int)$request->sub_category_id);
        if ($request->filled('vendor_id')) $q->where('vendor_id', (int)$request->vendor_id);
        if ($request->filled('min_price')) {
            $minPrice = (float)$request->query('min_price');
            $q->whereRaw('(price - (price * discount_percent / 100)) >= ?', [$minPrice]);
        }
        if ($request->filled('max_price')) {
            $maxPrice = (float)$request->query('max_price');
            $q->whereRaw('(price - (price * discount_percent / 100)) <= ?', [$maxPrice]);
        }

        $colors = $this->parseList($request->query('colors'));
        foreach ($colors as $color) {
            $q->whereJsonContains('meta->colors', $color);
        }

        $sizes = $this->parseList($request->query('sizes'));
        foreach ($sizes as $size) {
            $q->whereJsonContains('meta->sizes', $size);
        }

        $plans = $this->parseList($request->query('plans'));
        foreach ($plans as $plan) {
            $q->whereJsonContains('meta->plans', $plan);
        }
        if ($request->filled('search')) {
            $s = trim((string)$request->search);
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', "%$s%")->orWhere('title', 'like', "%$s%");
            });
        }

        $sort = (string)$request->query('sort', '');
        if ($sort === 'price-low') {
            $q->orderByRaw('(price - (price * discount_percent / 100)) asc');
        } elseif ($sort === 'price-high') {
            $q->orderByRaw('(price - (price * discount_percent / 100)) desc');
        } elseif ($sort === 'rating') {
            $q->orderByRaw("COALESCE(JSON_EXTRACT(meta, '$.rating_percent'), 0) desc");
        } elseif ($sort === 'popularity') {
            $q->orderByRaw("COALESCE(JSON_EXTRACT(meta, '$.review_count'), 0) desc");
        } else {
            $q->latest();
        }

        $paginator = $q->paginate($perPage);
        $items = ProductResource::collection($paginator)->resolve();

        return response()->json([
            'items' => $items,
            'total' => $paginator->total(),
            'per_page' => $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['images', 'files', 'deliveryType', 'category', 'vendor'])
            ->firstOrFail();

        return new ProductResource($product);
    }

    private function parseList($value): array
    {
        if (is_array($value)) {
            return collect($value)->map(fn($item) => trim((string)$item))->filter()->values()->all();
        }

        if (!is_string($value) || trim($value) === '') {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
