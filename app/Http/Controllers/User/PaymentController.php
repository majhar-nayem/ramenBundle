<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        $order = Order::with(['bundle', 'coupon', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($request->order_id);

        try {
            $provider = new PayPal;
            $provider->getAccessToken();
            $bundle_name = $order->bundle->name;
            $response = $provider->addProduct($bundle_name, $order->bundle->description, 'PHYSICAL', 'ECOMMERCE_SERVICES')
                ->addPlanTrialPricing('DAY', 7)
                ->addMonthlyPlan($order->bundle->name, "Order", $order->grand_total)
                ->setupSubscription($order->user->name, $order->user->email, now()->addMinute());

            Payment::create([
               'order_id' => $order->id,
               'subscription_id' => $response['id'],
               'response_data' =>  $response,
                'status' => $response['status']
            ]);
           //return $provider->activateSubscription($response['id'], "$bundle_name Subscription Payment Activate");
        }catch (\Exception $exception){
        return response()->json(["message" => "Something Went Wrong!"],500);
        }

        return $response;
    }

    public function response(Request $request)
    {

    }
}
