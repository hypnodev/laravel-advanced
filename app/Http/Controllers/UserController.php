<?php

namespace App\Http\Controllers;

use App\Contracts\GeocodingService;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
        //
    }

    public function findByEmail(Request $request)
    {
        try {
            $user = $this->userRepository->find($request->email);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }
}
