<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Exception;
use Illuminate\Http\Request;
use App\Services\Interfaces\IAuthService;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Create a new interface instance.
     *
     * @param IAuthService $authService
     */
    // Kullanılacak servisin bağımlılıkları enjekte edildi
    public function __construct(private IAuthService $authService)
    {
    }

    public function register(Request $request)
    {
        // Kullanıcı kayıt olurken name, email ve password alanları gereklidir.
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        try {
            // Kullanıcı kayıt edildi
            $user = $this->authService->register($request->all());
            return ResponseHelper::createResponse(
                'User successfully registered',
                $user,
                Response::HTTP_CREATED
            );
        } catch (Exception $e) {
            return ResponseHelper::handleException(
                'An error occurred while registering the user',
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function login(Request $request)
    {
        // Kullanıcı giriş yaparken email ve password alanları gereklidir.
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            // Kullanıcının giriş yapabilmesi için gerekli bilgiler kontrol edildi
            $response = $this->authService->login($request->only('email', 'password'));

            if (!$response) {
                return ResponseHelper::handleException(
                    'Invalid credentials',
                    null,
                    Response::HTTP_UNAUTHORIZED
                );
            }

            return ResponseHelper::createResponse(
                'User successfully logged in',
                $response,
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return ResponseHelper::handleException(
                'An error occurred while logging in the user',
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            // Kullanıcı çıkış yaptı
            $this->authService->logout($request);
            return ResponseHelper::createResponse(
                'Successfully logged out',
                null,
                Response::HTTP_OK
            );
        } catch (Exception $e) {
            return ResponseHelper::handleException(
                'An error occurred while logging out the user',
                null,
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

}
