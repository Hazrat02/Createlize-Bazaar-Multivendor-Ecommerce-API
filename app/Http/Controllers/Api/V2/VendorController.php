<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    public function topWeekly(Request $request)
    {
        $limit = (int)($request->query('limit') ?? 4);
        $limit = max(1, min($limit, 12));

        $from = Carbon::now()->subDays(7);

        $vendorIds = Order::query()
            ->where('created_at', '>=', $from)
            ->select('vendor_id', DB::raw('sum(total) as total_sales'))
            ->groupBy('vendor_id')
            ->orderByDesc('total_sales')
            ->limit($limit)
            ->pluck('vendor_id')
            ->values();

        $vendors = collect();
        if ($vendorIds->isNotEmpty()) {
            $vendorsById = User::role('Vendor')
                ->whereIn('id', $vendorIds)
                ->where('status', 'active')
                ->withCount(['products' => fn($q) => $q->where('is_active', true)])
                ->with('vendorProfile')
                ->get()
                ->keyBy('id');

            $vendors = $vendorIds
                ->map(fn($id) => $vendorsById->get($id))
                ->filter()
                ->values();
        }

        if ($vendors->count() < $limit) {
            $excludeIds = $vendors->pluck('id')->all();
            $fallback = User::role('Vendor')
                ->when(count($excludeIds), fn($q) => $q->whereNotIn('id', $excludeIds))
                ->where('status', 'active')
                ->withCount(['products' => fn($q) => $q->where('is_active', true)])
                ->with('vendorProfile')
                ->orderByDesc('products_count')
                ->limit($limit - $vendors->count())
                ->get();

            $vendors = $vendors->concat($fallback)->values();
        }

        $payload = $vendors->map(function ($vendor) use ($from) {
            $topProductIds = OrderItem::query()
                ->select('product_id', DB::raw('sum(qty) as total_qty'))
                ->whereHas('order', function ($q) use ($from, $vendor) {
                    $q->where('vendor_id', $vendor->id)->where('created_at', '>=', $from);
                })
                ->groupBy('product_id')
                ->orderByDesc('total_qty')
                ->limit(3)
                ->pluck('product_id');

            $products = collect();
            if ($topProductIds->isNotEmpty()) {
                $products = Product::query()
                    ->whereIn('id', $topProductIds)
                    ->where('is_active', true)
                    ->with(['images' => fn($q) => $q->orderBy('sort_order')])
                    ->get()
                    ->keyBy('id');

                $products = $topProductIds
                    ->map(fn($id) => $products->get($id))
                    ->filter()
                    ->values();
            }

            if ($products->count() < 3) {
                $excludeIds = $products->pluck('id')->all();
                $fallbackProducts = Product::query()
                    ->where('vendor_id', $vendor->id)
                    ->where('is_active', true)
                    ->when(count($excludeIds), fn($q) => $q->whereNotIn('id', $excludeIds))
                    ->with(['images' => fn($q) => $q->orderBy('sort_order')])
                    ->latest()
                    ->limit(3 - $products->count())
                    ->get();

                $products = $products->concat($fallbackProducts)->values();
            }

            $topProducts = $products->map(function ($product) {
                $imagePath = $product->images->first()?->path;
                return [
                    'id' => $product->id,
                    'slug' => $product->slug,
                    'name' => $product->name,
                    'image_url' => $imagePath ? asset('storage/' . $imagePath) : null,
                ];
            });

            $logoPath = $vendor->vendorProfile?->logo_path ?: $vendor->profile_image;

            return [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'store_name' => $vendor->vendorProfile?->store_name,
                'logo_url' => $logoPath ? asset('storage/' . $logoPath) : null,
                'product_count' => (int)($vendor->products_count ?? 0),
                'top_products' => $topProducts,
            ];
        });

        return response()->json([
            'items' => $payload,
            'from' => $from->toDateTimeString(),
        ]);
    }
}
