<?php

namespace App\Http\Requests\ShoppingChart;

use App\Models\Cake;
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
     * If the request contains a cake_id, and the cake has a cake_size,
     * then merge the cake_size into the request.
     *
     * This is a workaround for a problem with the request validation
     * where the cake_size is not being validated if the request does
     * not contain the cake_size.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        if ($this->cake_id) {
            $cake = Cake::findOrfail($this->cake_id);
            if ($cake && $cake->cake_size_id) {
                $this->merge([
                    'cake_size' => $cake->cake_size_id,
                ]);
            }
        }
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
            'cake_flavour_id' => 'required_with:cake_size',
            'toppings' => 'sometimes|array|max:4',
            'toppings.*' => 'integer|exists:toppings,id',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:1',
        ];
    }


    public function messages(): array
    {
        return [
            'cake_flavour_id.required_with' => 'Please choose atleast one flavour',
            'toppings.max' => 'You can only add upto 4 toppings',
        ];
    }
}
