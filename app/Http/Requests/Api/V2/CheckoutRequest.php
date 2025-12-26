<?php

namespace App\Http\Requests\Api\V2;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'coupon_code' => ['nullable', 'string', 'max:50'],
            'required_data' => ['nullable', 'array'],
            'required_files' => ['nullable', 'array'],
            'required_files.*' => ['file', 'max:8192'],
        ];
    }
}
