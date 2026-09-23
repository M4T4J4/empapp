<?php

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('creates a recruiter notification when a candidate applies to a job offer', function () {
    $candidate = User::factory()->create([
        'email' => 'candidate-apply@example.com',
        'password' => Hash::make('password123'),
        'is_recruiter' => false,
    ]);

    $recruiter = User::factory()->create([
        'email' => 'recruiter-apply@example.com',
        'password' => Hash::make('password123'),
        'is_recruiter' => true,
    ]);

    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Product Designer',
        'description' => 'Design great products',
        'company' => 'Studio',
        'location' => 'Douala',
        'employment_type' => 'full_time',
        'salary_min' => 800000,
        'salary_max' => 1200000,
        'required_experience' => '2 ans',
        'is_active' => true,
        'posted_at' => now(),
    ]);

    $this->actingAs($candidate);

    $this->post(route('application.store', $jobOffer), [
        'cover_letter' => 'Je suis motivé.',
    ])->assertRedirect(route('application.index'));

    $this->assertDatabaseHas('notifications', [
        'user_id' => $recruiter->id,
        'type' => 'application',
    ]);
});
