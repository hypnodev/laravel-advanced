<?php

namespace App\Http\Controllers;

use App\Contracts\GeocodingService;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function findByEmail(Request $request)
    {
        $user = app(UserRepository::class)->find($request->email);
        return response()->json($user);
    }
}
