<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $customers = User::latest()->paginate(20);

        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CustomerResource
     */
    public function show($id)
    {
        $customer = User::findOrFail($id);

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string',
            'phone' => ['string', 'unique:users,id,' . $id],
            'email' => ['string', 'unique:users,id,' . $id]
        ]);

        $customer = User::findOrFail($id);
        $customer->update($request->all());

        return response()->json(['message' => "Customer Info Updated"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return response()->json(['message' => "Customer Deleted!"]);
    }
}
