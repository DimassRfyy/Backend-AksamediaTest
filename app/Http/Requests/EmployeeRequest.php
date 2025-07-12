<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return [
                'image' => 'required|url',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'division_id' => 'required|exists:divisions,id',
                'position' => 'required|string|max:255',
            ];
        } else {
            return [
                'image' => 'sometimes|required|url',
                'name' => 'sometimes|required|string|max:255',
                'phone' => 'sometimes|required|string|max:20',
                'division_id' => 'sometimes|required|exists:divisions,id',
                'position' => 'sometimes|required|string|max:255',
            ];
        }
    }
}
