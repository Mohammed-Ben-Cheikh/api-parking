<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParkingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:parkings,name'],                                                                                                                                                            
            'description' => ['required', 'string', 'min:6'],
            'address' => ['required', 'string', 'max:255'],
            'total_position' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'boolean'],
            'region_id' => ['required', 'integer', 'exists:regions,id']
        ];
    }
}
