<?php

use App\Models\User;

it('allows recruiter access to the recruiter dashboard and company profile', function () {
    $user = User::factory()->create([
        'name' => 'Acme Labs',
        'email' => 'recruiter@acme.test',
        'company_name' => 'Acme Labs',
        'is_recruiter' => true,
    ]);

    $this->actingAs($user);

    $this->get(route('recruiter.dashboard'))->assertOk();
    $this->get(route('recruiter.profile'))->assertOk();
});
