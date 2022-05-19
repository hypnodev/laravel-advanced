<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Jobs\JobTest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('laravel-advanced')->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            JobTest::dispatch(auth()->user(), true);
            $token = auth()->user()?->createToken('laravel-advanced')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => auth()->user()
            ]);
        }

        return response()->json(['message' => 'Autenticazione fallita.'], 401);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
