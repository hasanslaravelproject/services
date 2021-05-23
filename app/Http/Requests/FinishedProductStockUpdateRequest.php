<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishedProductStockUpdateRequest extends FormRequest
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
            'validity' => ['required', 'max:255', 'string'],
            'finished_product_stock_id' => [
                'nullable',
                'exists:finished_product_stocks,id',
            ],
            'production_id' => ['nullable', 'exists:productions,id'],
        ];
    }
}
