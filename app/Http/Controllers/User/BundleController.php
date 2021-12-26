<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\BundleResource;
use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return BundleResource::collection(Bundle::all());
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return BundleResource
     */
    public function show($id)
    {
        $bundle = Bundle::find($id) ?? Bundle::where('slug', $id)->first();

        return new BundleResource($bundle);
    }
}
