<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class CategoryAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $q = trim((string) $request->get('q', ''));

        $categories = Category::query()
            ->when($q !== '', fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
            'filters' => [
                'q' => $q,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'image' => ['nullable', 'image', 'max:4096'],
            'icon' => ['nullable', 'image', 'max:4096'],
        ]);

        $imagePath = $request->file('image')?->store('categories', 'public');
        $iconPath = $request->file('icon')?->store('categories', 'public');

        Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(6)),
            'is_active' => true,
            'image_path' => $imagePath,
            'icon_path' => $iconPath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
            'icon' => ['nullable', 'image', 'max:4096'],
        ]);

        $imagePath = $category->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $iconPath = $category->icon_path;
        if ($request->hasFile('icon')) {
            if ($iconPath) {
                Storage::disk('public')->delete($iconPath);
            }
            $iconPath = $request->file('icon')->store('categories', 'public');
        }

        $category->update([
            'name' => $data['name'],
            'is_active' => $data['is_active'] ?? $category->is_active,
            'image_path' => $imagePath,
            'icon_path' => $iconPath,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        if ($category->icon_path) {
            Storage::disk('public')->delete($category->icon_path);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
