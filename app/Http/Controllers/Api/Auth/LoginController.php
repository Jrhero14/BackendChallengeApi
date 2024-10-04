<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate Data
        $validateData = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validateData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validateData->errors()
            ], 422);
        }

        // Check if Credential not authorization
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        // Success Login
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
        ], 200);

    }
}
