<?php

namespace App\Repositories\Interfaces;

interface UserRepository
{
    public function find($email);
}
