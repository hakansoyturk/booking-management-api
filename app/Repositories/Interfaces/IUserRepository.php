<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface IUserRepository
{
    public function create(array $data): User;
    public function findByEmail(string $email): ?User;
}