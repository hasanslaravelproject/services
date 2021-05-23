<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductionStoreRequest extends FormRequest
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
            'date' => ['required', 'date', 'date'],
            'validity' => ['required', 'max:255', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
            'quanity' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'order_id' => ['nullable', 'max:255', 'string'],
            'product_id' => ['nullable', 'exists:products,id'],
        ];
    }
}
