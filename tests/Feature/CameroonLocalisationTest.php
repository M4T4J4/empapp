<?php

use App\Models\JobOffer;
use App\Models\User;

it('stores Cameroon job salaries in FCFA without converting the entered values', function () {
    $user = User::factory()->create([
        'is_recruiter' => true,
        'company_name' => 'CamerData Services',
    ]);

    $this->actingAs($user);

    $this->post(route('recruiter.job.store'), [
        'title' => 'Analyste de données junior',
        'description' => 'Mission de support analytique pour un projet de croissance.',
        'company' => 'CamerData Services',
        'location' => 'Yaoundé, Centre',
        'city' => 'Yaoundé',
        'region' => 'Centre',
        'domain' => 'IT',
        'salary_min' => 450000,
        'salary_max' => 1400000,
        'employment_type' => 'cdd',
        'required_experience' => 'sans_experience',
        'education_level' => 'Bachelor',
        'work_mode' => 'remote',
        'required_skills' => 'SQL, Excel, Power BI',
        'benefits' => 'Transport, prime de performance',
        'deadline' => now()->addDays(30)->toDateString(),
        'is_active' => true,
    ])->assertRedirect(route('recruiter.jobs'));

    $this->assertDatabaseHas('job_offers', [
        'user_id' => $user->id,
        'city' => 'Yaoundé',
        'region' => 'Centre',
        'employment_type' => 'contract',
        'salary_min' => 450000,
        'salary_max' => 1400000,
    ]);
});

it('displays stored salaries with the FCFA currency on the job offer page', function () {
    $recruiter = User::factory()->create(['is_recruiter' => true]);
    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Analyste de données junior',
        'description' => 'Mission de support analytique.',
        'company' => 'CamerData Services',
        'location' => 'Yaoundé, Centre',
        'employment_type' => 'contract',
        'salary_min' => 450000,
        'salary_max' => 1400000,
        'is_active' => true,
        'posted_at' => now(),
    ]);

    $this->get(route('job-offer.show', $jobOffer))
        ->assertSee('450 000 FCFA')
        ->assertSee('1 400 000 FCFA');
});

it('prefills and updates recruiter salaries in FCFA', function () {
    $recruiter = User::factory()->create(['is_recruiter' => true]);
    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Développeur Laravel',
        'description' => 'Développement web.',
        'company' => 'CamerData Services',
        'location' => 'Yaoundé',
        'employment_type' => 'full_time',
        'salary_min' => 450000,
        'salary_max' => 1400000,
        'is_active' => true,
        'posted_at' => now(),
    ]);

    $this->actingAs($recruiter)
        ->get(route('recruiter.job.edit', $jobOffer))
        ->assertSee('value="450000', false);

    $this->put(route('recruiter.job.update', $jobOffer), [
        'title' => 'Développeur Laravel',
        'description' => 'Développement web.',
        'company' => 'CamerData Services',
        'location' => 'Yaoundé',
        'salary_min' => 700000,
        'salary_max' => 1000000,
        'employment_type' => 'full_time',
    ])->assertRedirect(route('recruiter.jobs'));

    $this->assertDatabaseHas('job_offers', [
        'id' => $jobOffer->id,
        'salary_min' => 700000,
        'salary_max' => 1000000,
    ]);
});
