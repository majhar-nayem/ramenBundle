<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBundleRequest extends FormRequest
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
            'name' => ['string'],
            'description' => ['string'],
            'slug' => ['string', 'unique:bundles'],
            'image' => ['mimes:png,jpg,jpeg'],
            'price' => ['numeric'],
            'products' => ['array'],
            'products.*.product_id' => ['required'],
            'products.*.qty' => ['required','int'],
        ];
    }
}
