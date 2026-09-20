<?php

use App\Models\User;

it('accepts cameroon local job values for jobs and salaries', function () {
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
    ]);
});
