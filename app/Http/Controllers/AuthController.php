<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(LoginRequest $request) {
        if (auth()->attempt($request->validated())) {
            return response()->json([
                'message' => 'user has successfully login.',
                'data' => $this->authService->login()
            ]);
        }
        return response()->json([
            'message' => 'Invalid credentias.'
        ], 422);
    }

    public function register(RegisterRequest $request) {
        return response()->json([
            'message' => 'user has successfully registered.',
            'data' => $this->authService->register($request->validated())
        ]);
    }
}
