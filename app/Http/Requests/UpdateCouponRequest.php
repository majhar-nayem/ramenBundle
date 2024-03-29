<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
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
            'start_at' => 'date',
            'end_at' => ['date', 'after:start_at'],
            'max_limit' => 'integer',
            'user_limit' => 'integer',
            'min_order_amount' => 'integer',
            'max_discount_amount' => 'integer',
        ];
    }
}
