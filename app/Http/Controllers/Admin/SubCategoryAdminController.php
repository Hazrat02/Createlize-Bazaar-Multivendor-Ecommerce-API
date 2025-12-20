<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SubCategoryAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $q = trim((string) $request->get('q', ''));

        $subcategories = SubCategory::query()
            ->with('category')
            ->when($q !== '', fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Subcategories/Index', [
            'subcategories' => $subcategories,
            'filters' => [
                'q' => $q,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Subcategories/Create', [
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name' => ['required','string','max:150'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        SubCategory::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']).'-'.Str::lower(Str::random(6)),
            'is_active' => $data['is_active'] ?? true,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created');
    }

    public function edit(SubCategory $subcategory): Response
    {
        return Inertia::render('Admin/Subcategories/Edit', [
            'subcategory' => $subcategory,
            'categories' => Category::query()->orderBy('name')->get(['id','name']),
        ]);
    }

    public function update(Request $request, SubCategory $subcategory): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required','exists:categories,id'],
            'name' => ['required','string','max:150'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $subcategory->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'is_active' => $data['is_active'] ?? $subcategory->is_active,
        ]);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated');
    }

    public function destroy(SubCategory $subcategory): RedirectResponse
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory deleted');
    }
}
