<?php

namespace App\Http\Repositories\User;

use App\Exceptions\FailedResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImplementation implements UserRepository
{
    private $userModel;

    /**
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function geById(int $id)
    {
        return $this->userModel::query()->where('id', $id)->first();
    }

    /**
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getByEmail(string $email)
    {
        return $this->userModel::query()->where('email', $email)->first();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @return void
     * @throws FailedResponse
     */
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
