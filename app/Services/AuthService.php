<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserRepository $userRepo
    ) {}

    public function register($userData) {
        return [
            'user' => new UserResource($this->userRepo->create($userData))
        ];
    }

    public function login() {
        $user = auth()->user();
        $token = $user->createToken('user-token')->plainTextToken;
        return [
            'access_token' => $token,
            'user' => new UserResource($user)
        ];
    }
}
