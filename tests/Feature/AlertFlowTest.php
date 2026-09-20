<?php

use App\Models\Alert;
use App\Models\User;

it('allows an authenticated user to access the alert management page', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->get(route('alert.index'))->assertOk();
});

it('allows a user to create an alert and view it in the list', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $this->post(route('alert.store'), [
        'location' => 'Paris',
        'employment_type' => 'full_time',
        'min_salary' => 50000,
        'max_salary' => 90000,
    ])->assertRedirect(route('alert.index'));

    $this->assertDatabaseHas('alerts', [
        'user_id' => $user->id,
        'location' => 'Paris',
        'employment_type' => 'full_time',
    ]);

    $this->get(route('alert.index'))->assertSee('Paris');
});
