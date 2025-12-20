<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryField;
use App\Models\DeliveryType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DeliveryAdminController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Deliveries/Index', [
            'deliveryTypes' => DeliveryType::query()->with('fields')->orderBy('sort_order')->get(),
        ]);
    }

    public function storeType(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:150'],
            'code' => ['required','string','max:50','unique:delivery_types,code'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        DeliveryType::create([
            'name' => $data['name'],
            'code' => $data['code'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return back()->with('success','Delivery type created');
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

        return back()->with('success','Field created');
    }

    public function destroyField(DeliveryField $deliveryField): RedirectResponse
    {
        $deliveryField->delete();
        return back()->with('success','Field deleted');
    }
}
