<?php

namespace App\Http\Controllers\Api;

use App\Services\TokenService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function login(Request $request)
    {

        $credenciales = $request->only('nick_name', 'password');


        $token = $this->tokenService->createToken($credenciales);

        if ($token) {
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
