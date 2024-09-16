<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'brand_id' => 'required',
            'category_id' => 'required',
            'name' => 'required|string',
            'product_code' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'weight' => 'required|string',
            'description' =>'required|string',
            'images.*' => 'mimes:jpg,bmp,png,webp'
        ];
    }
}
