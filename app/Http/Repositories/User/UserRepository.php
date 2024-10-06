<?php

namespace App\Http\Repositories\User;

use Illuminate\Http\Request;

interface UserRepository
{
    public function geById(int $id);
    public function getByEmail(string $email);
    public function createUser(string $name, string $email, string $password);
}
