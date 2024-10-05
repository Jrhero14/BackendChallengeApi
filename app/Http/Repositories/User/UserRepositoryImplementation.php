<?php

namespace App\Http\Repositories\User;

use App\Models\User;

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
}
