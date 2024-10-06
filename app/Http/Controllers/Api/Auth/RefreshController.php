<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\Request;

class RefreshController extends Controller
{
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api');
        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        // Refresh process in service
        $token = $this->authService->refreshToken();

        //Success refresh
        return response()->json([
            'status' => true,
            'message' => 'Success Refresh Token',
            'token' => $token,
        ]);
    }
}
