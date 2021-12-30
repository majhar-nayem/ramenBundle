<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Bundle;
use App\Models\Coupon;
use App\Models\Order;
use App\Services\CalculateGrandTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $orders = Order::latest()->where('user_id', Auth::id())->paginate(20);

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $bundle = Bundle::findOrFail($request->bundle_id);
        $data['sub_total'] = $bundle->price;
        $data['user_id'] = Auth::id();
        $coupon = Coupon::find($request->coupon_id) ?? Coupon::where('code', $request->coupon_code)->first();
        $data['grand_total'] = (new CalculateGrandTotal())($bundle, $coupon);
       $order = Order::create($data);

        return response()->json([
            'message' => "Order Created Successfully!",
            'order' => $order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrderResource
     */
    public function show($id)
    {
        $orders = Order::where('user_id', Auth::id())->findOrFail($id);
        return new OrderResource($orders);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => "Order Deleted Successfully!"]);
    }
}
