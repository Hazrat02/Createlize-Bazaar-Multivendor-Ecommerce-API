<?php

namespace App\Services\Orders;

use App\Models\DeliveryType;
use App\Models\Product;
use Illuminate\Support\Collection;

class RequiredFieldsBuilder
{
    /**
     * Build required fields for a product based on its delivery type defaults,
     * then apply per-product overrides.
     *
     * Override model:
     * - action: add|remove|override
     * - field_name: key
     * - definition: full field definition for add/override
     */
    public function build(Product $product): array
    {
        $deliveryType = DeliveryType::query()->with('fields')->findOrFail($product->delivery_type_id);

        $fields = collect($deliveryType->fields)->map(fn($f) => [
            'title' => $f->title,
            'name' => $f->name,
            'type' => $f->type,
            'required' => (bool)$f->required,
            'placeholder' => $f->placeholder,
            'options' => $f->options ?? [],
            'sort_order' => (int)$f->sort_order,
        ]);

        foreach ($product->fieldOverrides as $ovr) {
            $action = $ovr->action;
            $fieldName = $ovr->field_name;
            $def = $ovr->definition ?? [];

            if ($action === 'remove') {
                $fields = $fields->reject(fn($f) => $f['name'] === $fieldName);
            } elseif ($action === 'add') {
                $fields->push($def);
            } elseif ($action === 'override') {
                $fields = $fields->map(fn($f) => $f['name'] === $fieldName ? array_merge($f, $def) : $f);
            }
        }

        return $fields->sortBy('sort_order')->values()->all();
    }
}
