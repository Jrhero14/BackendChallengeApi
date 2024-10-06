<?php

namespace App\Http\Repositories\User;

use App\Exceptions\FailedResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImplementation implements UserRepository
{
    private $userModel;
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function geById(int $id)
    {
        return $this->userModel::query()->where('id', $id)->first();
    }

    public function getByEmail(string $email)
    {
        return $this->userModel::query()->where('email', $email)->first();
    }

    public function createUser(string $name, string $email, string $password)
    {
        // Create New User
        $userNew = $this->userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // If Created Success
        if (!$userNew) {
            throw new FailedResponse('User not created', 500);
        }
    }
}
