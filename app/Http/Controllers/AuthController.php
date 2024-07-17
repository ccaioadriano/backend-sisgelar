<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('name', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $user = User::create(
            [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]
        );
        return $user;
    }
    public function me()
    {
        $user = User::find(auth()->user()->id);
        return response()->json([
            'permissions' => $user->permissions(),
            'roles' => $user->roles,
            'user' => $user->me(),
            'success' => true,
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
}
