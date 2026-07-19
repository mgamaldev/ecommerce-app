<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VariantUpdateRequest extends FormRequest
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
        $variantId = $this->route('id');

        return [
            'product_id' => ['sometimes', 'integer', 'exists:products,id'],

            'variant_stock' => ['sometimes', 'integer', 'min:0'],

            'price' => ['sometimes', 'numeric', 'min:0'],

            'sku' => ['sometimes', 'string', 'max:255', Rule::unique('variants', 'sku')->ignore($variantId)],

            'color' => ['nullable', 'string', 'max:50'],

            'size' => ['nullable', 'string', 'max:50'],
        ];
    }
}
