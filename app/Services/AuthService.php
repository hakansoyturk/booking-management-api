<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IAuthService;
use Illuminate\Support\Facades\Auth;

class AuthService implements IAuthService
{
    /**
     * Create a new interface instance.
     *
     * @param IUserRepository $userRepository
     */
    public function __construct(private IUserRepository $userRepository) {}

    public function register(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();
        $token = $user->createToken('token-name');

        return [
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ];
    }

    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}