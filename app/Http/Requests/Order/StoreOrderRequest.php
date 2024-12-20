<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'estimated_delivery_date' => 'required|date|after:' . now()->addDays(2)->toDateString(), // Ensures estimation time is a valid date and in the future
            'user_address' => 'required|string|max:255',
            'cake_recipient' => 'required|string|regex:/^[a-zA-Z\s]+$/|min:3|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'estimated_delivery_date.after' => 'Tanggal pengambilan harus lebih dari 2 hari dari hari ini.',
            'user_address.required' => 'Alamat penerima harus diisi.',
            'user_address.max' => 'Alamat penerima maksimal 255 karakter.',
            'cake_recipient.required' => 'Nama penerima kue harus diisi.',
            'cake_recipient.regex' => 'Nama penerima hanya boleh berisi huruf dan spasi.',
        ];
    }
}
