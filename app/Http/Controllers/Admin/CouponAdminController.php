<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CouponAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Coupons/Index', [
            'coupons' => Coupon::query()->latest()->paginate(20),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Coupons/Create', [
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
            'subcategories' => SubCategory::query()->orderBy('name')->get(['id','name','category_id']),
            'vendors' => User::query()->role('Vendor')->orderBy('name')->get(['id','name','email']),
            'products' => Product::query()->orderBy('name')->get(['id','name','title']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required','string','max:50','unique:coupons,code'],
            'type' => ['required','in:percentage,fixed'],
            'value' => ['required','numeric','min:0'],
            'min_order_amount' => ['nullable','numeric','min:0'],
            'max_discount_amount' => ['nullable','numeric','min:0'],
            'start_at' => ['nullable','date'],
            'end_at' => ['nullable','date'],
            'usage_limit_total' => ['nullable','integer','min:1'],
            'usage_limit_per_user' => ['nullable','integer','min:1'],
            'applicable_scope' => ['required','in:all_products,category,sub_category,vendor,specific_products'],
            'applicable_ids' => ['nullable','array'],
            'allowed_payment_types' => ['required','in:online_only,cod_only,both'],
            'is_stackable' => ['boolean'],
            'status' => ['required','in:active,inactive'],
        ]);

        $data['code'] = Str::upper($data['code']);
        $data['applicable_ids'] = $data['applicable_ids'] ?? [];

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created');
    }

    public function edit(Coupon $coupon): Response
    {
        return Inertia::render('Admin/Coupons/Edit', [
            'coupon' => $coupon,
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
            'subcategories' => SubCategory::query()->orderBy('name')->get(['id','name','category_id']),
            'vendors' => User::query()->role('Vendor')->orderBy('name')->get(['id','name','email']),
            'products' => Product::query()->orderBy('name')->get(['id','name','title']),
        ]);
    }

    public function update(Request $request, Coupon $coupon): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required','string','max:50','unique:coupons,code,'.$coupon->id],
            'type' => ['required','in:percentage,fixed'],
            'value' => ['required','numeric','min:0'],
            'min_order_amount' => ['nullable','numeric','min:0'],
            'max_discount_amount' => ['nullable','numeric','min:0'],
            'start_at' => ['nullable','date'],
            'end_at' => ['nullable','date'],
            'usage_limit_total' => ['nullable','integer','min:1'],
            'usage_limit_per_user' => ['nullable','integer','min:1'],
            'applicable_scope' => ['required','in:all_products,category,sub_category,vendor,specific_products'],
            'applicable_ids' => ['nullable','array'],
            'allowed_payment_types' => ['required','in:online_only,cod_only,both'],
            'is_stackable' => ['boolean'],
            'status' => ['required','in:active,inactive'],
        ]);

        $data['code'] = Str::upper($data['code']);
        $data['applicable_ids'] = $data['applicable_ids'] ?? [];

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated');
    }

    public function destroy(Coupon $coupon): RedirectResponse
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted');
    }
}
