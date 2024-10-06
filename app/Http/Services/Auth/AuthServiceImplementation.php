<?php

namespace App\Http\Services\Auth;

use App\Exceptions\FailedResponse;
use App\Http\Repositories\User\UserRepository;
use Closure;

class AuthServiceImplementation implements AuthService
{
    private $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $request
     * @return mixed|string|bool
     * @throws FailedResponse
     */
    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api')->attempt($credentials);
        if (!$token) {
            throw new FailedResponse('Unauthorized', 401);
        }
        return $token;
    }

    /**
     * @return void
     */
    public function logout()
    {
        auth()->logout();
    }

    /**
     * @param $request
     * @return mixed|string|bool
     * @throws FailedResponse
     */
    public function register($request)
    {
        // Check if email already register before
        $userObj = $this->userRepository->getByEmail($request->get('email'));
        if($userObj){
            throw new FailedResponse('Email already exists', 409);
        }

        // Create User
        $this->userRepository->createUser(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        // Get token
        $token = auth()->guard('api')->attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        // Return token for new user
        return $token;
    }

    /**
     * @param $request
     * @return Closure|mixed|object|null
     */
    public function refreshToken()
    {
        return auth()->refresh();
    }
}
