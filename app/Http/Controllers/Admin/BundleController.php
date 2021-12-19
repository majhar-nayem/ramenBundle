<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBundleRequest;
use App\Http\Resources\BundleResource;
use App\Models\Bundle;
use App\Models\BundleProduct;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BundleResource::collection(Bundle::latest()->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBundleRequest $request)
    {
        $data = $request->only('name','description', 'price');
        $data['slug'] = Str::slug($request->name . ' ' . time());
        if ($request->has('image')) {
            $file_path = Upload::uploadFile($request->image, 'Product');
            $data['image'] = 'storage/' . $file_path;
        }
        $bundle = Bundle::create($data);
        $bundle->bundleProducts()->createMany($request->products);

        return response()->json(['message' => "Bundle Created Successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BundleResource
     */
    public function show($id)
    {
        $bundle = Bundle::find($id) ?? Bundle::where('slug', $id)->firstOrFail();

        return new BundleResource($bundle);
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
        $bundle = Bundle::findOrFail($id);

        $data = $request->except('products');
        if ($request->has('image')) {
            $file_path = Upload::uploadFile($request->image, 'Product');
            $data['image'] = 'storage/' . $file_path;
        }
        $bundle->update($data);

        if ($request->has('products') && count($request->products) > 0) {
            $bundle->products()->createMany($request->products);
        }

        return response()->json(['message' => "Bundle Updated Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->delete();

        return response()->json(['message' => "Bundle Deleted Successfully"]);
    }

    public function removeBundleProducts($id){
        $product = BundleProduct::findOrFail($id);
        $product->delete();

        return response()->json(['message' => "Product Removed From Bundle"]);
    }
}
