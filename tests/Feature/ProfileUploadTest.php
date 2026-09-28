<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores and displays a candidate profile photo', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $photo = UploadedFile::fake()->image('profile.jpg');

    $response = $this->actingAs($user)->put(route('profile.update'), [
        'name' => $user->name,
        'email' => $user->email,
        'profile_photo' => $photo,
    ]);

    $response->assertRedirect(route('profile.show'));

    $user->refresh();

    expect($user->profile_photo)->not->toBeNull();
    expect(Storage::disk('public')->url($user->profile_photo))->toBe('/storage/'.$user->profile_photo);
    Storage::disk('public')->assertExists($user->profile_photo);

    $this->get(route('profile.show'))
        ->assertOk()
        ->assertSee('/storage/'.$user->profile_photo, false);
});

it('stores and displays a recruiter company logo', function () {
    Storage::fake('public');

    $user = User::factory()->create([
        'is_recruiter' => true,
        'company_name' => 'Acme Labs',
    ]);
    $logo = UploadedFile::fake()->image('logo.png');

    $response = $this->actingAs($user)->put(route('recruiter.profile.update'), [
        'company_name' => $user->company_name,
        'logo' => $logo,
    ]);

    $response->assertRedirect(route('recruiter.profile'));

    $user->refresh();

    expect($user->company_logo)->not->toBeNull();
    expect(Storage::disk('public')->url($user->company_logo))->toBe('/storage/'.$user->company_logo);
    Storage::disk('public')->assertExists($user->company_logo);

    $this->get(route('recruiter.profile'))
        ->assertOk()
        ->assertSee('/storage/'.$user->company_logo, false);

    $this->get(route('company.public', $user))
        ->assertOk()
        ->assertSee('/storage/'.$user->company_logo, false);
});
