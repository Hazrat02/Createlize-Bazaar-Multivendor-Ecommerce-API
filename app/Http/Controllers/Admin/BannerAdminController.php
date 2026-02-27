<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BannerAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $q = trim((string) $request->get('q', ''));

        $banners = Banner::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($builder) use ($q) {
                    $builder
                        ->where('title', 'like', "%{$q}%")
                        ->orWhere('subtitle', 'like', "%{$q}%");
                });
            })
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Banners/Index', [
            'banners' => $banners,
            'filters' => [
                'q' => $q,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Banners/Create', [
            'categories' => $this->categoryOptions(),
            'subcategories' => $this->subCategoryOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatePayload($request, true);

        $imagePath = $request->file('image')?->store('banners', 'public');

        Banner::create([
            'title' => $data['title'] ?? null,
            'subtitle' => $data['subtitle'] ?? null,
            'cta_text' => $data['cta_text'] ?? null,
            'cta_link' => $data['cta_link'] ?? null,
            'image_path' => $imagePath,
            'text_align' => $data['text_align'] ?? 'left',
            'sort_order' => (int)($data['sort_order'] ?? 0),
            'is_active' => (bool)($data['is_active'] ?? false),
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'sub_category_id' => $data['sub_category_id'] ?? null,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner): Response
    {
        return Inertia::render('Admin/Banners/Edit', [
            'banner' => $banner,
            'categories' => $this->categoryOptions(),
            'subcategories' => $this->subCategoryOptions(),
        ]);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $data = $this->validatePayload($request, false);

        $imagePath = $banner->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner->update([
            'title' => $data['title'] ?? null,
            'subtitle' => $data['subtitle'] ?? null,
            'cta_text' => $data['cta_text'] ?? null,
            'cta_link' => $data['cta_link'] ?? null,
            'image_path' => $imagePath,
            'text_align' => $data['text_align'] ?? 'left',
            'sort_order' => (int)($data['sort_order'] ?? 0),
            'is_active' => (bool)($data['is_active'] ?? false),
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'sub_category_id' => $data['sub_category_id'] ?? null,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    private function validatePayload(Request $request, bool $isCreate): array
    {
        $imageRule = $isCreate ? ['required', 'image', 'max:4096'] : ['nullable', 'image', 'max:4096'];

        return $request->validate([
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:180'],
            'cta_text' => ['nullable', 'string', 'max:80'],
            'cta_link' => ['nullable', 'string', 'max:255'],
            'text_align' => ['nullable', 'string', 'in:left,center,right'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'image' => $imageRule,
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'sub_category_id' => ['nullable', 'integer', 'exists:sub_categories,id'],
        ]);
    }

    private function categoryOptions()
    {
        return Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    private function subCategoryOptions()
    {
        return SubCategory::query()
            ->orderBy('name')
            ->get(['id', 'name', 'category_id']);
    }
}
