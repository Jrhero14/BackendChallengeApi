<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\FailedResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws FailedResponse
     */
    public function __invoke(Request $request)
    {
        // Validate Data
        $validateData = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validateData->fails()) {
            throw new FailedResponse($validateData->errors(), 422);
        }

        // Login process in service
        $token = $this->authService->login($request);

        // Success Login
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
        ], 200);

    }
}
