<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function __invoke()
    {
        return response()->json(['pong' => true]);
    }
}
