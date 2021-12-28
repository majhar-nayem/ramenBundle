<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $order = Order::with(['bundle', 'coupons', 'user'])->findOrFail($request->order_id);

        if ($order->user_id != Auth::id()){
            return response()->json(['message' => "Invalid Order"]);
        }

        $provider = new PayPal;
        $provider->addProduct($order->bundle->name,$order->bundle->description,'Product','Product')
            ->addMonthlyPlan();
    }
}
