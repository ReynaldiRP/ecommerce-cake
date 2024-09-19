<?php

namespace App\Http\Requests\ShoppingChart;

use Illuminate\Foundation\Http\FormRequest;

class StoreShoppingChartRequest extends FormRequest
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
            'shopping_chart_id' => 'nullable',
            'cake_id' => 'required',
            'cake_flavour_id' => 'nullable',
            'toppings' => 'sometimes|array',
            'toppings.*' => 'integer|exists:toppings,id',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
        ];
    }
}
