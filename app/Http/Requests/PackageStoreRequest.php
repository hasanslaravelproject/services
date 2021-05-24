<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'validity' => ['required', 'date', 'date'],
            'status' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'company_id' => ['nullable', 'exists:companies,id'],
            'package_type_id' => ['nullable', 'exists:package_types,id'],
        ];
    }
}
