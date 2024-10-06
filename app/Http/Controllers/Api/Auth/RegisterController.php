<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\FailedResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Auth\AuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
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
        // Validate request data
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validatedData->fails()) {
            throw new FailedResponse($validatedData->errors(), 422);
        }

        // Create User in service
        $token = $this->authService->register($request);

        return response()->json([
            'status' => true,
            'message' => 'Register User Berhasil',
            'token' => $token,
        ], 201);
    }
}
