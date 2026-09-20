<?php

use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('loads the main candidate features pages', function () {
    $user = User::factory()->create([
        'is_recruiter' => false,
    ]);

    $this->actingAs($user)
        ->get(route('resume.index'))
        ->assertOk();

    $this->actingAs($user)
        ->get(route('alert.index'))
        ->assertOk();

    $this->actingAs($user)
        ->get(route('premium.index'))
        ->assertOk();
});

it('configures the private disk used for CV uploads', function () {
    expect(Storage::disk('private')->getDriver())->not->toBeNull();
});
