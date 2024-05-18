<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try{
        $user = User::where('email', $request->email)->first();

        if(empty($user))
        {
            return response()->json([
                'message' => '404 not found'
            ]);
        }

        if(!Hash::check($request->password, $user->password))
        {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 404);
        }

        $otp = rand(100000, 999999);
        $user->otp_code = Hash::make($otp);
        $user->save();


        // Http::withoutVerifying()->post(env('SEMAPHORE_API_URL'), [
        //         'apikey' => env('SEMAPHORE_API_KEY'),
        //         'number' => env('SEMAPHORE_API_NUMBER'),
        //         'message' => 'Your OTP code is: ' . $otp
        //     ]);

        return response()->json([
            'message' => 'OTP sent successfully',
            'otp_code' => $otp, 
        ]);
        
        } catch (\Exception $sms) {
        return response()->json([
            'status' =>false,
            'message' => 'There is an Error: ' . $sms->getMessage()
        ], 500);
    }
    }

    public function verifyOTP(Request $request)
    {
     
        $request->validate([
            'otp_code' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->otp_code, $user->otp_code)) {
            return response()->json(['message' => 'Invalid OTP'], 401);
        }
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Login Successfull',
            'token' => $user->createToken('token')->plainTextToken
        ]);
    }

    public function users()
    {
        return User::limit(10)->orderBy('id', 'desc')->get();
    }
    
}
