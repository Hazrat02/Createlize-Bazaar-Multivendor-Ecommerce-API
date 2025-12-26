<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeliveryType;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProductAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::query()
            ->with(['vendor','category','subCategory','deliveryType'])
            ->latest();

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhereHas('vendor', function ($vendorQuery) use ($search) {
                        $vendorQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return Inertia::render('Admin/Products/Index', [
            'products' => $query->paginate(20)->withQueryString(),
            'filters' => $request->only('q'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Create', [
            'vendors' => User::query()->role('Vendor')->orderBy('name')->get(['id','name','email']),
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
            'subcategories' => SubCategory::query()->orderBy('name')->get(['id','name','category_id']),
            'deliveryTypes' => DeliveryType::query()->orderBy('name')->get(['id','name','key']),
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
            'tags' => ['nullable','string','max:500'],
            'colors' => ['nullable','string','max:500'],
            'sizes' => ['nullable','string','max:500'],
            'plans' => ['nullable','string','max:500'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'images' => ['nullable','array'],
            'images.*' => ['image','max:4096'],
        ]);

        $data['slug'] = Str::slug($data['name']).'-'.Str::lower(Str::random(6));
        $data['tags'] = $this->parseTags($data['tags'] ?? null);
        $data['meta'] = [
            'colors' => $this->parseList($data['colors'] ?? null),
            'sizes' => $this->parseList($data['sizes'] ?? null),
            'plans' => $this->parseList($data['plans'] ?? null),
        ];

        unset($data['colors'], $data['sizes'], $data['plans']);

        $images = $request->file('images', []);

        $product = Product::create($data);

        $this->storeImages($product, $images);

        return redirect()->route('admin.products.index')->with('success','Product created');
    }

    public function show(Product $product): Response
    {
        return Inertia::render('Admin/Products/Show', [
            'product' => $product->load([
                'vendor',
                'category',
                'subCategory',
                'deliveryType',
                'images' => fn($query) => $query->orderBy('sort_order'),
            ]),
        ]);
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Admin/Products/Edit', [
            'product' => $product->load([
                'images' => fn($query) => $query->orderBy('sort_order'),
                'files',
            ]),
            'vendors' => User::query()->role('Vendor')->orderBy('name')->get(['id','name','email']),
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
            'subcategories' => SubCategory::query()->orderBy('name')->get(['id','name','category_id']),
            'deliveryTypes' => DeliveryType::query()->orderBy('name')->get(['id','name','key']),
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
            'tags' => ['nullable','string','max:500'],
            'colors' => ['nullable','string','max:500'],
            'sizes' => ['nullable','string','max:500'],
            'plans' => ['nullable','string','max:500'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'images' => ['nullable','array'],
            'images.*' => ['image','max:4096'],
        ]);

        $data['tags'] = $this->parseTags($data['tags'] ?? null);
        $meta = $product->meta ?? [];
        $meta['colors'] = $this->parseList($data['colors'] ?? null);
        $meta['sizes'] = $this->parseList($data['sizes'] ?? null);
        $meta['plans'] = $this->parseList($data['plans'] ?? null);
        $data['meta'] = $meta;
        unset($data['colors'], $data['sizes'], $data['plans']);

        $product->update($data);

        $images = $request->file('images', []);
        $this->storeImages($product, $images);

        return redirect()->route('admin.products.index')->with('success','Product updated');
    }

    public function addImages(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'images' => ['required','array'],
            'images.*' => ['image','max:4096'],
        ]);

        $this->storeImages($product, $data['images']);

        return back()->with('success', 'Images uploaded');
    }

    public function removeImage(Product $product, ProductImage $image): RedirectResponse
    {
        if ($image->product_id !== $product->id) {
            return back()->with('error', 'Image not found.');
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image removed');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Product deleted');
    }

    private function parseTags(?string $tags): array
    {
        if (!$tags) {
            return [];
        }

        return collect(explode(',', $tags))
            ->map(fn($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }

    private function parseList(?string $value): array
    {
        if (!$value) {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function storeImages(Product $product, array $images): void
    {
        if (empty($images)) {
            return;
        }

        $maxOrder = (int)$product->images()->max('sort_order');
        foreach ($images as $index => $image) {
            $path = $image->store('products', 'public');
            $product->images()->create([
                'path' => $path,
                'sort_order' => $maxOrder + $index + 1,
            ]);
        }
    }
}
