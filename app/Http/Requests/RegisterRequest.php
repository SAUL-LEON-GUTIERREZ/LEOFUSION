<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in([
                User::ROLE_CLIENTE,
                User::ROLE_PROFESIONAL,
                User::ROLE_PROVEEDOR,
            ])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
