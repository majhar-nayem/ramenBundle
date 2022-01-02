<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponUse;
use App\Traits\FindCampaign;
use Illuminate\Support\Facades\Auth;

class CalculateGrandTotal
{
    public function __invoke($bundle, $coupon = null)
    {
        if (!is_null($coupon)) {
            $is_valid = FindCampaign::isValidCoupon($coupon, $bundle->price);
            if ($is_valid) {
                $dis_amount = FindCampaign::calDiscountAmount($coupon, $bundle->price);
                if ($bundle->price - $dis_amount > 0) {
                    CouponUse::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => Auth::id()
                    ]);
                    return $bundle->price - $dis_amount;
                }
            }
        }
        return $bundle->price;
    }
}
