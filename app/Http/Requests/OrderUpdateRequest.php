<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'number' => ['required', 'max:255'],
            'delivery_date' => ['required', 'date', 'date'],
            'quantity' => ['required', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
            'product_id' => ['nullable', 'exists:products,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
