<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function orders(Request $request)
    {
        $orders = Order::query()->where('vendor_id', $request->user()->id)->latest()->paginate(20);
        return response()->json($orders);
    }

    public function products(Request $request)
    {
        $products = Product::query()->where('vendor_id', $request->user()->id)->latest()->paginate(20);
        return response()->json($products);
    }
}
