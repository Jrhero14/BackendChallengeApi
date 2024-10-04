<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RefreshController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke()
    {
        $token = auth()->refresh();
        return response()->json([
            'status' => true,
            'message' => 'Success Refresh Token',
            'token' => $token,
        ]);
    }
}
