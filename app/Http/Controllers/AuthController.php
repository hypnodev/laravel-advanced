<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($data)) {
            $token = Auth::user()->createToken('laravel-advanced')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => Auth::user()
            ]);
        }

        return response()->json(['message' => 'Autenticazione fallita.'], 401);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required', 'unique:users,email'],
            'password' => ['string', 'required']
        ]);

        $user = User::create($data);

        $token = $user->createToken('laravel-advanced')->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
