<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RawProductStockUpdateRequest extends FormRequest
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
            'quantity' => ['required', 'numeric'],
            'expiry_date' => ['required', 'date', 'date'],
            'ingredient_id' => ['nullable', 'exists:ingredients,id'],
        ];
    }
}
