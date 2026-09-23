<?php

use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('exposes public candidate and company profiles and recommendation pages', function () {
    $candidate = User::factory()->create([
        'name' => 'Alice Candidate',
        'email' => 'alice@example.com',
        'password' => Hash::make('password123'),
        'is_recruiter' => false,
        'is_verified' => true,
        'is_premium' => true,
    ]);

    $company = User::factory()->create([
        'name' => 'Acme Company',
        'email' => 'acme@example.com',
        'password' => Hash::make('password123'),
        'is_recruiter' => true,
        'is_verified' => true,
    ]);

    $offer = JobOffer::create([
        'user_id' => $company->id,
        'title' => 'Senior Developer',
        'description' => 'Build scalable systems.',
        'company' => 'Acme Company',
        'location' => 'Yaoundé',
        'city' => 'Yaoundé',
        'region' => 'Centre',
        'domain' => 'Software',
        'employment_type' => 'full_time',
        'salary_min' => 1000000,
        'salary_max' => 2000000,
        'required_experience' => '3+ years',
        'education_level' => 'Bachelor',
        'work_mode' => 'hybrid',
        'required_skills' => ['Laravel', 'PHP'],
        'benefits' => ['Mutuelle'],
        'is_active' => true,
        'posted_at' => now(),
    ]);

    $this->actingAs($candidate);

    $this->get(route('profile.public', $candidate))->assertOk();
    $this->get(route('company.public', $company))->assertOk();
    $this->get(route('candidate.recommendations'))->assertOk();
    $this->post(route('job-offer.share', $offer))->assertRedirect();
    $this->get(route('recruiter.stats'))->assertOk();
    $this->get(route('premium.index'))->assertOk();
});
