<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('throttles repeated invalid login attempts', function () {
    $email = 'unknown@example.com';

    foreach (range(1, 5) as $attempt) {
        $this->post(route('login'), [
            'email' => $email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
    }

    $this->post(route('login'), [
        'email' => $email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');

    expect(session('errors')->first('email'))->toContain('Trop de tentatives');
});

it('logs in successfully and clears previous failed attempts', function () {
    $user = User::factory()->create([
        'email' => 'candidate@example.com',
        'password' => Hash::make('correct-password'),
    ]);

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ])->assertSessionHasErrors('email');

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'correct-password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
});

it('hashes a registered password', function () {
    $this->post(route('register'), [
        'name' => 'New Candidate',
        'email' => 'new@example.com',
        'password' => 'Strong-password-123',
        'password_confirmation' => 'Strong-password-123',
        'is_recruiter' => false,
    ])->assertRedirect(route('dashboard'));

    $user = User::where('email', 'new@example.com')->firstOrFail();

    expect(Hash::check('Strong-password-123', $user->password))->toBeTrue();
});
