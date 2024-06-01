<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (empty($user)) {
                return response()->json([
                    'message' => '404 not found'
                ]);
            }

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid Credentials'
                ], 404);
            }

            $otp = rand(100000, 999999);
            $user->otp_code = Hash::make($otp);
            $user->save();

            Http::withoutVerifying()->post(env('SEMAPHORE_API_URL'), [
                'apikey' => env('SEMAPHORE_API_KEY'),
                'number' => env('SEMAPHORE_API_NUMBER'),
                'message' => 'Your OTP code is: ' . $otp
            ]);

            return response()->json([
                'message' => 'OTP sent successfully',
                'otp_code' => $otp,
            ]);
        } catch (\Exception $sms) {
            return response()->json([
                'status' => false,
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
            'message' => 'Login Successful',
            'token' => $user->createToken('token')->plainTextToken
        ]);
    }

    public function users()
    {
        return User::orderBy('id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $password = $request->input('password');

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        Mail::to($user->email)->send(new NewUserMail($user, $password));

        return response()->json([
            'message' => 'Create User Successfully',
            'status' => true,
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'Delete User Successfully',
            'status' => true,
        ]);
    }

    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $users->id,
            'password' => 'required|string|max:255',
        ]);

        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $users->password = bcrypt($request->input('password'));

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $users->avatar = $avatarPath;
        }

        $users->save();

        return response()->json([
            'status' => true,
            'message' => 'Edit User Successfully',
        ]);
    }

    public function getUser(string $id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}

    