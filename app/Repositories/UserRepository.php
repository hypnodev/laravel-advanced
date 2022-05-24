<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepository as UserRepositoryAlias;

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
}
