<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryField;
use App\Models\DeliveryType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class DeliveryAdminController extends Controller
{
    public function index(Request $request): Response
    {
        $query = DeliveryType::query()->orderBy('sort_order')->orderBy('name');

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('key', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Admin/Deliveries/Index', [
            'deliveryTypes' => $query->paginate(10)->withQueryString(),
            'filters' => $request->only('q'),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Deliveries/Create');
    }

    public function edit(DeliveryType $deliveryType): Response
    {
        return Inertia::render('Admin/Deliveries/Edit', [
            'deliveryType' => $deliveryType,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->saveType($request);
    }

    public function storeType(Request $request): RedirectResponse
    {
        return $this->saveType($request);
    }

    public function update(Request $request, DeliveryType $deliveryType): RedirectResponse
    {
        return $this->saveType($request, $deliveryType);
    }

    public function destroy(DeliveryType $deliveryType): RedirectResponse
    {
        $deliveryType->delete();

        return back()->with('success', 'Delivery type deleted');
    }

    public function fields(DeliveryType $deliveryType, Request $request): Response
    {
        $fieldsQuery = $deliveryType->fields()->orderBy('sort_order')->orderBy('title');

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $fieldsQuery->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        return Inertia::render('Admin/Deliveries/Fields', [
            'deliveryType' => $deliveryType,
            'fields' => $fieldsQuery->paginate(10)->withQueryString(),
            'filters' => $request->only('q'),
        ]);
    }

    public function createField(DeliveryType $deliveryType): Response
    {
        return Inertia::render('Admin/Deliveries/CreateFields', [
            'deliveryType' => $deliveryType,
        ]);
    }

    public function storeField(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'delivery_type_id' => ['required','exists:delivery_types,id'],
            'title' => ['required','string','max:150'],
            'name' => ['required','string','max:60'],
            'type' => ['required','in:text,email,phone,textarea,select,file'],
            'required' => ['boolean'],
            'placeholder' => ['nullable','string','max:255'],
            'options' => ['nullable','array'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        DeliveryField::create([
            'delivery_type_id' => $data['delivery_type_id'],
            'title' => $data['title'],
            'name' => $data['name'],
            'type' => $data['type'],
            'required' => (bool)($data['required'] ?? false),
            'placeholder' => $data['placeholder'] ?? null,
            'options' => $data['options'] ?? [],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        $deliveryType = DeliveryType::find($data['delivery_type_id']);

        if (!$deliveryType) {
            return back()->with('success', 'Field created');
        }

        return redirect()
            ->route('admin.deliveries.fields.index', $deliveryType)
            ->with('success', 'Field created');
    }

    public function destroyField(DeliveryField $deliveryField): RedirectResponse
    {
        $deliveryField->delete();
        return back()->with('success', 'Field deleted');
    }

    private function saveType(Request $request, ?DeliveryType $deliveryType = null): RedirectResponse
    {
        $uniqueRule = Rule::unique('delivery_types', 'key');
        if ($deliveryType) {
            $uniqueRule = $uniqueRule->ignore($deliveryType->id);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'key' => ['required', 'string', 'max:50', $uniqueRule],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($deliveryType) {
            $deliveryType->update([
                'name' => $data['name'],
                'key' => $data['key'],
                'sort_order' => $data['sort_order'] ?? 0,
                'is_active' => (bool)($data['is_active'] ?? false),
            ]);

            return redirect()->route('admin.deliveries.index')->with('success', 'Delivery type updated');
        }

        DeliveryType::create([
            'name' => $data['name'],
            'key' => $data['key'],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.deliveries.index')->with('success', 'Delivery type created');
    }
}
