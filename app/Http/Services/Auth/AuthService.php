<?php

namespace App\Http\Services\Auth;

interface AuthService
{
    public function login($request);
    public function logout();
    public function register($request);
    public function refreshToken();
}
