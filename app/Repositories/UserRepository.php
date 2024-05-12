<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

// Bu sınıf, IUserRepository interface'ini implement eder.
// User ile ilgili veritabanı işlemleri bu sınıfta gerçekleştirilir.
class UserRepository implements IUserRepository
{
    // Kullanıcı oluşturur
    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    // Email'e göre kullanıcı getirir
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}