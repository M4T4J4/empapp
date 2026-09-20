<?php

use App\Models\Application;
use App\Models\JobOffer;
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

it('notifies the candidate when the recruiter changes the application status', function () {
    $candidate = User::factory()->create([
        'name' => 'Jean Dupont',
        'email' => 'candidate@acme.test',
        'is_recruiter' => false,
    ]);

    $recruiter = User::factory()->create([
        'name' => 'Acme Labs',
        'email' => 'recruiter-status@acme.test',
        'company_name' => 'Acme Labs',
        'is_recruiter' => true,
    ]);

    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Product Designer',
        'description' => 'Design great products',
        'company' => 'Acme Labs',
        'location' => 'Yaoundé',
        'employment_type' => 'full_time',
        'salary_min' => 800000,
        'salary_max' => 1200000,
        'required_experience' => '2 ans',
        'is_active' => true,
        'posted_at' => now(),
    ]);

    $application = Application::create([
        'user_id' => $candidate->id,
        'job_offer_id' => $jobOffer->id,
        'status' => 'pending',
        'applied_at' => now(),
    ]);

    $this->actingAs($recruiter)
        ->put(route('recruiter.application.status', $application), ['status' => 'accepted'])
        ->assertRedirect();

    $this->assertDatabaseHas('applications', [
        'id' => $application->id,
        'status' => 'accepted',
    ]);

    $this->assertDatabaseHas('notifications', [
        'user_id' => $candidate->id,
        'type' => 'status_update',
    ]);

    $notification = $candidate->notifications()->where('type', 'status_update')->latest()->first();

    expect($notification->message)->toContain('En attente')->toContain('Acceptée');
});

it('shows only applicants who have applied to the recruiter offers', function () {
    $recruiter = User::factory()->create([
        'name' => 'Acme Labs',
        'email' => 'recruiter-limiter@acme.test',
        'company_name' => 'Acme Labs',
        'is_recruiter' => true,
    ]);

    $otherRecruiter = User::factory()->create([
        'name' => 'Other Company',
        'email' => 'other-recruiter@acme.test',
        'company_name' => 'Other Company',
        'is_recruiter' => true,
    ]);

    $candidateFromThisRecruiter = User::factory()->create([
        'name' => 'Applicant One',
        'email' => 'applicant-one@acme.test',
        'is_recruiter' => false,
    ]);

    $candidateFromOtherRecruiter = User::factory()->create([
        'name' => 'Applicant Two',
        'email' => 'applicant-two@acme.test',
        'is_recruiter' => false,
    ]);

    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Product Manager',
        'description' => 'Manage products',
        'company' => 'Acme Labs',
        'location' => 'Douala',
        'employment_type' => 'full_time',
        'salary_min' => 900000,
        'salary_max' => 1500000,
        'required_experience' => '3 ans',
        'is_active' => true,
        'posted_at' => now(),
    ]);

    $otherJobOffer = JobOffer::create([
        'user_id' => $otherRecruiter->id,
        'title' => 'Data Analyst',
        'description' => 'Analyse data',
        'company' => 'Other Company',
        'location' => 'Yaoundé',
        'employment_type' => 'full_time',
        'salary_min' => 850000,
        'salary_max' => 1400000,
        'required_experience' => '2 ans',
        'is_active' => true,
        'posted_at' => now(),
    ]);

    Application::create([
        'user_id' => $candidateFromThisRecruiter->id,
        'job_offer_id' => $jobOffer->id,
        'status' => 'pending',
        'applied_at' => now(),
    ]);

    Application::create([
        'user_id' => $candidateFromOtherRecruiter->id,
        'job_offer_id' => $otherJobOffer->id,
        'status' => 'pending',
        'applied_at' => now(),
    ]);

    $this->actingAs($recruiter)
        ->get(route('recruiter.candidates'))
        ->assertOk()
        ->assertSee($candidateFromThisRecruiter->name)
        ->assertDontSee($candidateFromOtherRecruiter->name);
});

it('prevents recruiters and admins from viewing the public job offers page', function () {
    $recruiter = User::factory()->create([
        'email' => 'recruiter-no-offers@acme.test',
        'is_recruiter' => true,
    ]);

    $admin = User::factory()->create([
        'email' => 'admin-no-offers@acme.test',
        'is_admin' => true,
        'is_recruiter' => false,
    ]);

    $this->actingAs($recruiter)->get(route('job-offer.index'))->assertForbidden();
    $this->actingAs($admin)->get(route('job-offer.index'))->assertForbidden();
});

it('shows the candidate profile edit page with skills, education, experience and language forms', function () {
    $candidate = User::factory()->create([
        'name' => 'Marie Candidate',
        'email' => 'candidate-profile@acme.test',
        'is_recruiter' => false,
    ]);

    $this->actingAs($candidate)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Compétences')
        ->assertSee('Formations')
        ->assertSee('Expériences')
        ->assertSee('Langues');
});

it('lets a recruiter contact a candidate who applied to one of their offers', function () {
    $recruiter = User::factory()->create([
        'name' => 'Acme Labs',
        'email' => 'recruiter-message@acme.test',
        'is_recruiter' => true,
    ]);

    $candidate = User::factory()->create([
        'name' => 'Candidate For Message',
        'email' => 'candidate-message@acme.test',
        'is_recruiter' => false,
    ]);

    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Product Designer',
        'description' => 'Design great products',
        'company' => 'Acme Labs',
        'location' => 'Yaoundé',
        'employment_type' => 'full_time',
        'salary_min' => 800000,
        'salary_max' => 1200000,
        'required_experience' => '2 ans',
        'is_active' => true,
        'posted_at' => now(),
    ]);

    Application::create([
        'user_id' => $candidate->id,
        'job_offer_id' => $jobOffer->id,
        'status' => 'pending',
        'applied_at' => now(),
    ]);

    $this->actingAs($recruiter)
        ->get(route('recruiter.candidates'))
        ->assertOk()
        ->assertSee('Message');
});
