<?php

namespace App\Domain\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function execute(string $email, string $password): string|bool
    {
        $credentials = ['email' => $email, 'password' => $password];

        if (! $token = auth('api')->attempt($credentials)) {
            return false;
        }

        return $token;
    }
}
