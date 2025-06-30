<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginAction
{
    public function execute(string $email, string $password): ?array
    {
        $user = User::where('email', $email)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }
        $tokenResult = $user->createToken('api-token', [], now()->addHour());
        $token = $tokenResult->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}
