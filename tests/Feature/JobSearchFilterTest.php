<?php

use App\Models\JobOffer;
use App\Models\User;

it('filters job offers by keyword, city, contract type, experience and salary range', function () {
    $user = User::factory()->create();

    JobOffer::create([
        'user_id' => $user->id,
        'title' => 'Senior Laravel Developer',
        'description' => 'Build APIs and dashboards for a modern SaaS product.',
        'company' => 'Acme Digital',
        'location' => 'Paris',
        'city' => 'Paris',
        'region' => 'Île-de-France',
        'domain' => 'Software',
        'employment_type' => 'full_time',
        'required_experience' => '5+ years',
        'education_level' => 'Master',
        'work_mode' => 'remote',
        'salary_min' => 70000,
        'salary_max' => 110000,
        'is_active' => true,
        'posted_at' => now(),
    ]);

    JobOffer::create([
        'user_id' => $user->id,
        'title' => 'Product Designer',
        'description' => 'Design user journeys and prototypes.',
        'company' => 'Studio Graph',
        'location' => 'Lyon',
        'city' => 'Lyon',
        'region' => 'Auvergne-Rhône-Alpes',
        'domain' => 'Design',
        'employment_type' => 'contract',
        'required_experience' => '2+ years',
        'education_level' => 'Bachelor',
        'work_mode' => 'hybrid',
        'salary_min' => 45000,
        'salary_max' => 65000,
        'is_active' => true,
        'posted_at' => now()->subDay(),
    ]);

    $response = $this->get(route('job-offer.index', [
        'search' => 'Laravel',
        'city' => 'Paris',
        'employment_type' => 'full_time',
        'required_experience' => '5+ years',
        'salary_min' => 60000,
        'salary_max' => 120000,
        'work_mode' => 'remote',
    ]));

    $response->assertOk();
    $response->assertSee('Senior Laravel Developer');
    $response->assertDontSee('Product Designer');
});
