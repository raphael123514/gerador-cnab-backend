<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(array $data): User
    {
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->assignUserRole($user, $data['role'] ?? null);

        return $user;
    }

    private function assignUserRole(User $user, ?string $role): void
    {
        $roleName = ($role === 'admin') ? 'admin' : 'user';
        $user->assignRole($roleName);
    }
}