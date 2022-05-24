<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository as UserRepositoryAlias;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryAlias
{
    public function find($email)
    {
        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            throw new \Exception('User not found.');
        }

        return $user;
    }

    public function create(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
