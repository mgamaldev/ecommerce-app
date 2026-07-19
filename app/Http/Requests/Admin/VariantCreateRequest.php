<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VariantCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],

            'variant_stock' => ['required', 'integer', 'min:0'],

            'price' => ['required', 'numeric', 'min:0'],

            'sku' => ['required', 'string', 'max:255', 'unique:variants,sku'],

            'color' => ['nullable', 'string', 'max:50'],

            'size' => ['nullable', 'integer', 'max:50'],
        ];
    }
}
