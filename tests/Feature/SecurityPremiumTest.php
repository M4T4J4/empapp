<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('blocks a user whose account is blocked from logging in', function () {
    $user = User::factory()->create([
        'email' => 'blocked@example.com',
        'password' => Hash::make('password123'),
        'is_blocked' => true,
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ])->assertSessionHasErrors('email');
});

it('requires premium access for premium features', function () {
    $user = User::factory()->create([
        'email' => 'standard@example.com',
        'password' => Hash::make('password123'),
        'is_premium' => false,
    ]);

    $this->actingAs($user)
        ->get(route('premium.index'))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('success', 'Premium sera bientôt disponible.');
});
