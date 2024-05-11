<?php

namespace App\Http\Controllers;

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
    public function __construct(private IAuthService $authService) {}

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = $this->authService->register($request->all());

        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $response = $this->authService->login($request->only('email', 'password'));

        if (!$response) {
            return response()->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json($response);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return response()->json([
            'message' => 'Successfully logged out'
        ], Response::HTTP_OK);
    }
}
