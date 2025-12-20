<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CheckoutRequest;
use App\Services\Orders\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private CheckoutService $checkout){}

    public function checkout(CheckoutRequest $request)
    {
        $result = $this->checkout->checkout($request->user(), $request->validated());
        return response()->json($result);
    }
}
