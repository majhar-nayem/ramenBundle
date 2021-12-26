<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
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
            'code' => ['string', 'required', 'unique:coupons'],
            'type' => ['required', 'in:fixed,percentage'],
            'amount' => ['int', 'required'],
            'start_at' => 'required',
            'end_at' => 'required',
            'max_limit' => 'int',
            'user_limit' => 'int',
            'min_order_amount' => 'int',
            'max_discount_amount' => 'int',
            'discounted_fees' => 'json',
            'payable_advance' => 'numeric',
            'message' => 'string',
            'priority' => 'int'
        ];
    }
}
