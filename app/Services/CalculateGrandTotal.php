<?php

namespace App\Services;

class CalculateGrandTotal
{
    public function __invoke($bundle, $coupon_id = null)
    {
        if (is_null($coupon_id)){
            return $bundle->price;
        }
    }
}
