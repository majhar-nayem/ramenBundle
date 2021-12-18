<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function Symfony\Component\Translation\t;

class UpdateProductRequest extends FormRequest
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
            'title' => ['string'],
            'product_code' => ['string', 'unique:products'],
            'description' => ['string'],
            'image' => ['mimes:png,jpg,jpeg'],
            'price' => ['numeric'],
            'sub_images' => ['array'],
            'sub_images.*.image' => ['required', 'mimes:png,jpg,jpeg'],
            'sub_images.*.note' => ['nullable', 'string'],
        ];
    }
}
