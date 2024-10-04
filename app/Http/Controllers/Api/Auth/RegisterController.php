<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate request data
        $validatedData = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validatedData->errors(),
            ], 422);
        }

        // Check if email already register before
        if(User::where('email', '=', $request->get('email'))->exists()){
            return response()->json([
                'status' => false,
                'message' => 'Email already exists',
            ], 409);
        }

        // Create User Process
        try {
            // Create New User
            $userNew = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            // If Created Success
            if ($userNew) {
                $token = auth()->guard('api')->attempt([
                    'email' => $request->get('email'),
                    'password' => $request->get('password')
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Register User Berhasil',
                    'token' => $token,
                ], 201);
            }
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ],500);
        }
    }
}
