<?php

namespace App\Http\Requests;

use App\Models\Quote;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuoteStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([
                Quote::STATUS_PENDIENTE,
                Quote::STATUS_COTIZADO,
                Quote::STATUS_APROBADO,
                Quote::STATUS_RECHAZADO,
            ])],
            'total_estimated' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
