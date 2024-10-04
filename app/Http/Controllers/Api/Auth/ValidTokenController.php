<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke()
    {
       return response()->json([
           'status' => true,
           'message' => 'Token valid',
       ], 200);
    }
}
