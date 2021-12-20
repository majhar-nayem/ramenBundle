<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\EmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'phone' => ['required']
        ]);

        $phone = $request->phone;

        $user = Admin::where('phone', $phone)->first();
        if (is_null($user)) {
            return response()->json(['error' => 'Invalid Phone No!'], 404);
        }
        $otp = rand(1000, 9999);
        $user->update([
            'otp' => $otp,
            'expired_at' => Carbon::now()->addMinutes(5)
        ]);
        $user->notify(new EmailVerifyNotification($otp));
        return response()->json([
            'message' => 'OTP send successfully',
        ]);
    }

    public function verifyOTP(Request $request)
    {
        $this->validate($request, [
            'otp' => ['required', 'string', 'size:4'],
            'phone' => 'required'
        ]);
        $user = Admin::where('phone', $request->phone)->first();

        if ($user->otp == $request->otp) {
            if ($user->expired_at < Carbon::now()) {
                return response()->json(['message' => "OTP expired!"], 403);
            }
            $success['token'] = $user->guard(['admin'])->createToken('admin')->accessToken;
            $success['user_id'] = $user->id;
            $success['name'] = $user->name;
            $success['phone'] = $user->phone;
            $success['roles'] = $user->roles;
            $success['department'] = $user->department;

            return response()->json(['success' => $success], 200);
        }
        return response()->json(['error' => "Oops!, Invalid OTP!!"], 403);
    }

    public function emailLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (is_null($admin)) {
            return response()->json(['error' => "Invalid Email or Password!"], 422);
        }
        if (Hash::check($request->password, $admin->password)) {
            $success['token'] = $admin->guard(['admin-web'])->createToken('admin')->accessToken;
            $success['user_id'] = $admin->id;
            $success['name'] = $admin->name;
            $success['email'] = $admin->email;

            return response()->json(['response' => $success], 200);
        }

        return response()->json(['error' => "Invalid Email or Password"], 422);
    }
}
