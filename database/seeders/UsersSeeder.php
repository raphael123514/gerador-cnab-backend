<?php

namespace Database\Seeders;

use App\Enums\ProfileEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Domain\User\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => ProfileEnum::ADMIN->value]);
        Role::create(['name' => ProfileEnum::USER->value]);
        
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->assignRole('admin');
    }
}
