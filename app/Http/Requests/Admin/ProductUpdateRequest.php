<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
        $productId = $this->route('id');

        return [
            'category_id' => ['sometimes', 'integer', 'exists:categories,id'],

            'name' => ['sometimes', 'string', 'max:255', 'min:2'],

            'slug' => ['sometimes', 'string', 'max:255', 'min:2', Rule::unique('products', 'slug')->ignore($productId)],

            'description' => ['sometimes', 'string'],

            'stock' => ['sometimes', 'integer', 'min:0'],

            'base_price' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
