<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('customer_id', $request->user()->id)
            ->withCount('items')
            ->latest()
            ->paginate(20);

        return response()->json($orders);
    }

    public function show(Request $request, string $order_number)
    {
        $order = Order::query()
            ->where('order_number', $order_number)
            ->where('customer_id', $request->user()->id)
            ->with(['items','deliveries.files','requiredData'])
            ->firstOrFail();

        return response()->json($order);
    }

    public function downloads(Request $request, string $order_number)
    {
        $order = Order::query()
            ->where('order_number', $order_number)
            ->where('customer_id', $request->user()->id)
            ->with(['items.product.files','deliveries.files'])
            ->firstOrFail();

        $files = [];

        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && $product->deliveryType?->key === 'instant') {
                foreach ($product->files as $pf) {
                    $files[] = [
                        'type' => 'instant',
                        'name' => $pf->original_name,
                        'download_url' => route('downloads.get', ['token' => $this->signedToken($request->user()->id, $pf->path)]),
                    ];
                }
            }
        }

        foreach ($order->deliveries as $delivery) {
            foreach ($delivery->files as $df) {
                $files[] = [
                    'type' => 'manual',
                    'name' => $df->original_name,
                    'download_url' => route('downloads.get', ['token' => $this->signedToken($request->user()->id, $df->path)]),
                ];
            }
        }

        return response()->json(['files' => $files]);
    }

    private function signedToken(int $uid, string $path): string
    {
        return base64_encode(json_encode(['uid'=>$uid,'path'=>$path]));
    }
}
