<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows admin to manage moderation actions', function () {
    $admin = User::factory()->create([
        'email' => 'moderator@example.com',
        'password' => Hash::make('password123'),
        'is_admin' => true,
        'is_recruiter' => true,
    ]);

    $targetUser = User::factory()->create([
        'email' => 'company@example.com',
        'password' => Hash::make('password123'),
        'is_recruiter' => true,
        'is_verified' => false,
        'is_blocked' => false,
    ]);

    $this->actingAs($admin);

    $this->get(route('admin.companies'))->assertOk();
    $this->get(route('admin.reports'))->assertOk();

    $this->post(route('admin.users.toggle-block', $targetUser))->assertRedirect();
    $this->assertDatabaseHas('users', ['id' => $targetUser->id, 'is_blocked' => true]);

    $this->post(route('admin.companies.toggle-approval', $targetUser))->assertRedirect();
    $this->assertDatabaseHas('users', ['id' => $targetUser->id, 'is_verified' => true]);
});
