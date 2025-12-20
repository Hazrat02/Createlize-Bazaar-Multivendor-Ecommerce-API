<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeliveryType;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProductAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => Product::query()->with(['vendor','category','subCategory','deliveryType'])->latest()->paginate(20),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Create', [
            'vendors' => User::query()->role('Vendor')->orderBy('name')->get(['id','name','email']),
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
            'subcategories' => SubCategory::query()->orderBy('name')->get(['id','name','category_id']),
            'deliveryTypes' => DeliveryType::query()->orderBy('name')->get(['id','name','code']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vendor_id' => ['required','exists:users,id'],
            'category_id' => ['required','exists:categories,id'],
            'sub_category_id' => ['required','exists:sub_categories,id'],
            'delivery_type_id' => ['required','exists:delivery_types,id'],
            'name' => ['required','string','max:200'],
            'title' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'currency' => ['required','in:USD,BDT'],
            'discount_percent' => ['nullable','integer','min:0','max:100'],
            'stock' => ['nullable','integer','min:0'],
            'sku' => ['nullable','string','max:100'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(6));
        $data['tags'] = [];
        $data['meta'] = [];

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success','Product created');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product->load(['images','files']),
            'vendors' => User::query()->role('Vendor')->orderBy('name')->get(['id','name','email']),
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
            'subcategories' => SubCategory::query()->orderBy('name')->get(['id','name','category_id']),
            'deliveryTypes' => DeliveryType::query()->orderBy('name')->get(['id','name','code']),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'vendor_id' => ['required','exists:users,id'],
            'category_id' => ['required','exists:categories,id'],
            'sub_category_id' => ['required','exists:sub_categories,id'],
            'delivery_type_id' => ['required','exists:delivery_types,id'],
            'name' => ['required','string','max:200'],
            'title' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'price' => ['required','numeric','min:0'],
            'currency' => ['required','in:USD,BDT'],
            'discount_percent' => ['nullable','integer','min:0','max:100'],
            'stock' => ['nullable','integer','min:0'],
            'sku' => ['nullable','string','max:100'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
        ]);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Product updated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Product deleted');
    }
}
