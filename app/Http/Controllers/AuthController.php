<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Jobs\JobTest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private UserRepository $userRepository
    ) {
        //
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'alpha', 'bail'],
            'email' => ['required', 'email', 'unique:users,email', 'bail'],
            'password' => ['required', 'min:8', 'bail']
        ]);

        $user = $this->userRepository->create($request->name, $request->email, $request->password);

        $token = $user->createToken('laravel-advanced')->accessToken;
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8']
        ]);

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
