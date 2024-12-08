<?php

namespace App\Http\Requests\Cake;


use Illuminate\Foundation\Http\FormRequest;

class UpdateCakeRequest extends FormRequest
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
            'id' => 'required',
            'category_id' => 'nullable',
            'discount_id' => 'nullable',
            'name' => 'required|regex:/^[a-zA-Z\s\-]+$/|min:3|max:255',
            'base_price' => 'required|numeric|min:1|max:1000000',
            'description' => 'nullable|min:3|max:255',
            'image_url' => 'nullable|mimes:png,jpg,jpeg,webp',
            'personalization_type' => 'required'
        ];
    }
}
