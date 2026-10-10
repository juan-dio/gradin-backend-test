<?php

namespace App\Http\Requests;

use App\Models\Courier;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourierRequest extends FormRequest
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
        $courier = $this->route('courier');

        return [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('couriers', 'phone')->ignore($courier instanceof Courier ? $courier->id : $courier),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('couriers', 'email')->ignore($courier instanceof Courier ? $courier->id : $courier),
            ],
            'vehicle_type' => 'required|string|max:50',
            'plate_number' => 'required|string|max:20',
            'level' => 'required|integer|between:1,5',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
