<?php

namespace App\Http\Requests\Flavour;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlavourRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-Z\s\-]+$/|min:5|max:255|unique:flavours,name',
            'price' => 'required|numeric|min:1|max:1000000',
            'image_url' => 'nullable|mimes:png,jpg,jpeg'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'The flavour is already exists',
            'name.regex' => 'The flavour may only contain alphabetic characters and dashes.',
            'price.max' => 'The flavour price must not be greater than 1,000,000.',
            'image_url.mimes' => 'The image must be a file of type: png, jpg, jpeg.'
        ];
    }
}
