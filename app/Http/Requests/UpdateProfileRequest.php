<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
            'email' => ['email', 'unique:users,id,'.Auth::id()],
            'phone' => ['unique:users,id,'.Auth::id(), 'string'],
            'image' => ['mimes:png,jpeg,jpg'],

        ];
    }
}
