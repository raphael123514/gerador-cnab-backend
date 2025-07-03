<?php

namespace App\Domain\User\Actions;


use App\Domain\User\Models\User;
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