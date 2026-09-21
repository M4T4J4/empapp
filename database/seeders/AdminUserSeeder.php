<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@empapp.com'],
            [
                'name' => 'Administrateur',
                'password' => 'Admin@12345',
                'is_admin' => true,
                'is_recruiter' => false,
                'is_verified' => true,
                'is_blocked' => false,
                'is_premium' => false,
            ]
        );
    }
}