<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        $validatedData = request()->validate([
            'email' => 'required',
            'password' => 'required|min:8'
        ]);
        if (!auth()->guard('web')->attempt($validatedData)) {
            return response()->json(['error' => 'Invalid Email or Password!'], 401);
        }
        $token['token'] = auth()->guard('web')->user()->createToken('User')->accessToken;

        return response()->json(['response' => $token], 200);
    }

    public function register(UserRegistrationRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $success['token'] = $user->guard(['web'])->createToken('User')->accessToken;
        $success['name'] = $user->name;
        return response()->json([
            'message' => "Registration Successful!",
            'response' => $success
        ]);
    }
}
