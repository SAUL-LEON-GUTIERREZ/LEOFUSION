<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technical_sheet' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'price_reference' => ['nullable', 'numeric', 'min:0'],
            'is_quote_only' => ['required', 'boolean'],
        ];
    }
}
