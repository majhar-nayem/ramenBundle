<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Traits\Upload;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return new ProfileResource(Auth::user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $data = $request->validated();
        if ($request->has('image')) {
            $file_path = Upload::uploadFile($request->image, 'Users');
            $data['image'] = 'storage/' . $file_path;
        }
        Auth::user()->update($data);

        return response()->json(['message' => 'Profile Updated Successfully!']);
    }
}
