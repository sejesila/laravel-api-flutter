<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users|string',
            'password' => ['required', 'confirmed', 'min:4', Password::default()],
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json([
                'message' => 'User already exists'
            ], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'device_name' => $request->device_name]);

            return $user->createToken($request->device_name)->plainTextToken;

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'

        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }
        return $user->createToken($request->device_name)->plainTextToken;

    }

    public function logout(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if ($user){
            // Revoke all tokens...
            $user->tokens()->delete();
        }
        return response()->noContent();

    }
}
