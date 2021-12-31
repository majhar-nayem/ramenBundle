<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->page = 0) {
            $product = Product::latest()->get();
        } else {
            $product = Product::latest()->paginate(20);
        }

        return ProductResource::collection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ProductResource
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->except('sub_images');
        if ($request->has('image')) {
            $file_path = Upload::uploadFile($request->image, 'Product');
            $data['image'] = 'storage/' . $file_path;
        }
        $data['slug'] = Str::slug($request->title . ' ' . time());
        $product = Product::create($data);
        if ($request->has('sub_images') && count($request->sub_images) > 0) {
            $img_arr = [];
            foreach ($request->sub_images as $image){
                $file_path = Upload::uploadFile($image['image'], 'ProductSubImage');
                $img_arr[] = [
                  'product_id' => $product->id,
                  'image' => 'storage/'. $file_path,
                  'note' => $image['note'] ?? null
                ];
            }
            ProductImage::insert($img_arr);
        }
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ProductResource
     */
    public function show($id)
    {
        $product = Product::find($id) ?? Product::where('slug', $id)->firstOrFail();

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id) ?? Product::where('slug', $id)->firstOrFail();

        $data = $request->validated();
        if ($request->has('image')) {
            $file_path = Upload::uploadFile($request->image, 'Users');
            $data['image'] = 'storage/' . $file_path;
        }
        $data['slug'] = Str::slug($request->title . ' ' . time());
        $product->update($data);
        if ($request->has('sub_images') && count($request->sub_images) > 0) {
            $img_arr = [];
            foreach ($request->sub_images as $image){
                $file_path = Upload::uploadFile($image['image'], 'ProductSubImage');
                $img_arr[] = [
                    'product_id' => $product->id,
                    'image' => 'storage/'. $file_path,
                    'note' => $image['note'] ?? null
                ];
            }
            ProductImage::insert($img_arr);
        }

        return response()->json(['message' => "Product Updated Successfully!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id) ?? Product::where('slug', $id)->firstOrFail();
        $product->delete();

        return response()->json(['message' => "Deleted Successfully!"]);
    }

    public function subImageDelete($id)
    {
        $sub_image = ProductImage::findOrFail($id);
        $sub_image->delete();

        return response()->json(['message' => "File Deleted Successfully!"]);
    }
}
