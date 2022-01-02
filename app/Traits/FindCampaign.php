<?php

namespace App\Traits;

use App\Models\Coupon;
use App\Models\CouponUse;
use Illuminate\Support\Facades\Auth;

trait FindCampaign
{
    public static function campaign($amount)
    {
        $coupons = Coupon::orderBy('priority', 'ASC')->get();
        foreach ($coupons as $coupon) {
            if (!self::isValidCoupon($coupon, $amount)) {
                continue;
            }
            return $coupon;
        }
        return false;
    }

    public static function isValidCoupon($coupon, $amount, $user_id = null)
    {
        if ($coupon->min_order_amount > $amount) {
            return false;
        }
        if ($coupon->start_at > now()) {
            return false;
        }
        if (!is_null($coupon->end_at) && $coupon->end_at < now()) {
            return false;
        }
        $uses = CouponUse::where('coupon_id', $coupon->id)->get();
        $coupon_use_user = $uses->where('user_id', $user_id ?? Auth::id())->count();
        $coupon_count = $uses->count();
        if ((!is_null($coupon->max_uses) && $coupon_count >= $coupon->max_uses)
            || (!is_null($coupon->user_limit) && $coupon_use_user >= $coupon->user_limit)) {
            return false;
        }
        return true;
    }

    public static function calDiscountAmount($coupon, $order_amount)
    {
        if ($coupon->is_fixed) {
            $amount = $coupon->amount;
        } else {
            $amount = round(($coupon->amount / 100) * $order_amount);
            $mda = $coupon->max_discount_amount;
            if (!is_null($mda) && $amount > $mda) {
                $amount = $mda;
            }
        }

        return $amount;
    }
}
