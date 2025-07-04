<?php

namespace Database\Seeders;

use App\Domain\User\Models\User;
use App\Enums\ProfileEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => ProfileEnum::ADMIN->value, 'guard_name' => 'api']);
        Role::create(['name' => ProfileEnum::USER->value, 'guard_name' => 'api']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->assignRole('admin');
    }
}
