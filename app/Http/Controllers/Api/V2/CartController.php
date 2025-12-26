<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\CartAddRequest;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cart) {}

    public function add(CartAddRequest $request)
    {
        $cart = $this->cart->add((int)$request->validated('product_id'), (int)($request->validated('qty') ?? 1));
        return response()->json([
            'cart' => $cart,
            'totals' => $this->cart->totals($cart),
        ]);
    }

    public function get()
    {
        $cart = $this->cart->get();
        return response()->json([
            'cart' => $cart,
            'totals' => $this->cart->totals($cart),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => ['required', 'integer', 'min:1']]);
        $cart = $this->cart->remove((int)$request->product_id);
        return response()->json(['cart' => $cart, 'totals' => $this->cart->totals($cart)]);
    }

    public function clear()
    {
        $this->cart->clear();
        return response()->json(['ok' => true]);
    }
}
