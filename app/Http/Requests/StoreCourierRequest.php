<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:couriers,phone',
            'email' => 'nullable|email|max:255|unique:couriers,email',
            'vehicle_type' => 'required|string|max:50',
            'plate_number' => 'required|string|max:20',
            'level' => 'required|integer|between:1,5',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
