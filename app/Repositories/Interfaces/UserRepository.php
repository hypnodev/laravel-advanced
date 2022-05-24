<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepository
{
    public function find($email);

    public function create(string $name, string $email, string $password): User;
}
