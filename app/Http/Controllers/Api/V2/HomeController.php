<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();

        $banners = $this->bannerQuery($now)->get();

        $featuredCategory = $this->getFeaturedCategory();
        $topSellingSubcategories = $this->getTopSellingSubcategories((int)($request->query('limit') ?? 2));

        return response()->json([
            'banners' => $banners->map(fn($banner) => $this->mapBanner($banner)),
            'featured_category' => $featuredCategory,
            'top_selling_subcategories' => $topSellingSubcategories,
        ]);
    }

    private function bannerQuery(Carbon $now)
    {
        return Banner::query()
            ->where('is_active', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->with(['category', 'subCategory'])
            ->orderBy('sort_order')
            ->orderByDesc('id');
    }

    private function mapBanner(Banner $banner): array
    {
        $category = $banner->category;
        $subcategory = $banner->subCategory;
        $productCount = 0;

        if ($subcategory) {
            $productCount = Product::query()
                ->where('sub_category_id', $subcategory->id)
                ->where('is_active', true)
                ->count();
        } elseif ($category) {
            $productCount = Product::query()
                ->where('category_id', $category->id)
                ->where('is_active', true)
                ->count();
        }

        $ctaLink = $banner->cta_link;
        if (!$ctaLink) {
            if ($subcategory) {
                $ctaLink = '/market-shop?subcategory=' . $subcategory->slug;
            } elseif ($category) {
                $ctaLink = '/market-shop?category=' . $category->slug;
            }
        }

        return [
            'id' => $banner->id,
            'title' => $banner->title,
            'subtitle' => $banner->subtitle,
            'cta_text' => $banner->cta_text,
            'cta_link' => $ctaLink,
            'text_align' => $banner->text_align ?: 'left',
            'image_url' => $banner->image_path ? asset('storage/' . $banner->image_path) : null,
            'product_count' => $productCount,
            'category' => $category ? [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image_url' => $category->image_path ? asset('storage/' . $category->image_path) : null,
            ] : null,
            'subcategory' => $subcategory ? [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'slug' => $subcategory->slug,
                'image_url' => $subcategory->image_path ? asset('storage/' . $subcategory->image_path) : null,
            ] : null,
        ];
    }

    private function getFeaturedCategory(): ?array
    {
        $topCategory = Product::query()
            ->select('category_id', DB::raw('count(*) as total'))
            ->whereNotNull('category_id')
            ->where('is_active', true)
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->first();

        if (!$topCategory) {
            return null;
        }

        $category = Category::query()->find($topCategory->category_id);
        if (!$category) {
            return null;
        }

        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'product_count' => (int)$topCategory->total,
            'image_url' => $category->image_path ? asset('storage/' . $category->image_path) : null,
        ];
    }

    private function getTopSellingSubcategories(int $limit): array
    {
        $limit = max(1, min($limit, 6));
        $from = Carbon::now()->subDays(30);

        $topSubcategoryRows = OrderItem::query()
            ->select('products.sub_category_id', DB::raw('sum(order_items.qty) as total_qty'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereNotNull('products.sub_category_id')
            ->where('products.is_active', true)
            ->where('orders.created_at', '>=', $from)
            ->groupBy('products.sub_category_id')
            ->orderByDesc('total_qty')
            ->limit($limit)
            ->get();

        if ($topSubcategoryRows->isEmpty()) {
            $topSubcategoryRows = Product::query()
                ->select('sub_category_id', DB::raw('count(*) as total_qty'))
                ->whereNotNull('sub_category_id')
                ->where('is_active', true)
                ->groupBy('sub_category_id')
                ->orderByDesc('total_qty')
                ->limit($limit)
                ->get();
        } elseif ($topSubcategoryRows->count() < $limit) {
            $excludeIds = $topSubcategoryRows->pluck('sub_category_id')->all();
            $fallbackRows = Product::query()
                ->select('sub_category_id', DB::raw('count(*) as total_qty'))
                ->whereNotNull('sub_category_id')
                ->where('is_active', true)
                ->when(count($excludeIds), fn($q) => $q->whereNotIn('sub_category_id', $excludeIds))
                ->groupBy('sub_category_id')
                ->orderByDesc('total_qty')
                ->limit($limit - $topSubcategoryRows->count())
                ->get();
            $topSubcategoryRows = $topSubcategoryRows->concat($fallbackRows);
        }

        if ($topSubcategoryRows->isEmpty()) {
            return [];
        }

        $subCategoryIds = $topSubcategoryRows->pluck('sub_category_id')->values();
        $subcategories = SubCategory::query()
            ->whereIn('id', $subCategoryIds)
            ->get()
            ->keyBy('id');

        return $topSubcategoryRows->map(function ($row) use ($subcategories) {
            $subcategory = $subcategories->get($row->sub_category_id);
            if (!$subcategory) {
                return null;
            }

            $productCount = Product::query()
                ->where('sub_category_id', $subcategory->id)
                ->where('is_active', true)
                ->count();

            return [
                'id' => $subcategory->id,
                'name' => $subcategory->name,
                'slug' => $subcategory->slug,
                'product_count' => $productCount,
                'sales_qty' => (int)$row->total_qty,
                'image_url' => $subcategory->image_path ? asset('storage/' . $subcategory->image_path) : null,
            ];
        })->filter()->values()->all();
    }
}
