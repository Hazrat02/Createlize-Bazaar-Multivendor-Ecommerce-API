<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\CheckoutRequest;
use App\Models\Product;
use App\Services\Cart\CartService;
use App\Services\Orders\CheckoutService;
use App\Services\Orders\RequiredFieldsBuilder;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CheckoutService $checkout,
        private CartService $cart,
        private RequiredFieldsBuilder $fieldsBuilder,
    ) {}

    public function checkout(CheckoutRequest $request)
    {
        $result = $this->checkout->checkout($request->user(), $request->validated());
        return response()->json($result);
    }

    public function fields(Request $request)
    {
        $cart = $this->cart->get();
        $items = $cart['items'] ?? [];

        if (empty($items)) {
            return response()->json(['fields' => []]);
        }

        $firstProduct = Product::query()->findOrFail((int)$items[0]['product_id']);
        $fields = $this->fieldsBuilder->build($firstProduct);

        return response()->json([
            'fields' => $fields,
        ]);
    }
}
