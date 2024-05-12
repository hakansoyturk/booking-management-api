<?php

namespace App\Services;

use App\Repositories\Interfaces\IUserRepository;
use App\Services\Interfaces\IAuthService;
use Illuminate\Support\Facades\Auth;

// Bu sınıf, IAuthService interface'ini implement eder.
// IUserRepository interface'ini kullanarak veritabanı işlemlerini gerçekleştirir.
// Auth ile ilgili işlemler bu serviste gerçekleştirilir.
class AuthService implements IAuthService
{
    /**
     * Create a new interface instance.
     *
     * @param IUserRepository $userRepository
     */
    public function __construct(private IUserRepository $userRepository) {}

    // Kullanıcı kayıt eder
    public function register(array $data)
    {
        return $this->userRepository->create($data);
    }

    // Kullanıcı giriş yapar
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

    // Kullanıcı çıkış yapar
    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}