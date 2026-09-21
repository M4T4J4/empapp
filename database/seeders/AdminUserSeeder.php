<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@empapp.com',
            ],
            [
                'name' => 'Administrateur',
                'password' => Hash::make('Admin@123456'),
                'is_admin' => true,
                'is_recruiter' => false,
                'is_verified' => true,
                'is_blocked' => false,
                'is_premium' => false,
            ]
        );
    }
}