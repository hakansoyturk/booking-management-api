<?php

namespace App\Services\Interfaces;

interface IAuthService
{
    public function register(array $data);
    public function login(array $credentials);
    public function logout($request);
}