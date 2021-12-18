<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'product_code' => ['required', 'string', 'unique:products'],
            'description' => ['required', 'string'],
            'image' => ['required', 'mimes:png,jpg,jpeg'],
            'price' => ['required', 'numeric'],
            'sub_images' => ['array'],
            'sub_images.*.image' => ['required', 'mimes:png,jpg,jpeg'],
            'sub_images.*.note' => ['nullable', 'string'],
        ];
    }
}
