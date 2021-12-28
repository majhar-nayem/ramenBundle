<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Bundle;
use App\Models\Order;
use App\Services\CalculateGrandTotal;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $orders = Order::orderBy('id', $request->sort_by ?? "DESC")->get();
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $bundle = Bundle::findOrFail($request->bundle_id);
        $data['sub_total'] = $bundle->price;
        $data['grand_total'] = (new CalculateGrandTotal())($bundle, $request->coupon_id);
        Order::create($data);

        return response()->json(['message' => "Order Created Successfully!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return OrderResource
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => "Order Deleted Successfully!"]);
    }
}
