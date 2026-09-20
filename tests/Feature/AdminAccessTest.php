<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows admin users to access the admin dashboard', function () {
    $admin = User::factory()->create([
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
        'is_admin' => true,
        'is_recruiter' => false,
    ]);

    $this->actingAs($admin);

    $this->get(route('admin.dashboard'))->assertOk();
});

it('blocks non-admin users from the admin dashboard', function () {
    $user = User::factory()->create([
        'email' => 'candidate@example.com',
        'password' => Hash::make('password123'),
        'is_admin' => false,
        'is_recruiter' => false,
    ]);

    $this->actingAs($user);

    $this->get(route('admin.dashboard'))->assertStatus(403);
});
