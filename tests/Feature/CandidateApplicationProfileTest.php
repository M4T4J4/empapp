<?php

use App\Models\Education;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

it('lets candidates add education and skills from profile editing', function () {
    $candidate = User::factory()->create(['is_recruiter' => false]);

    $this->actingAs($candidate)
        ->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('Ajouter une formation')
        ->assertSee('Ajouter une compétence')
        ->assertSee(route('resume.index'), false);

    $this->post(route('education.store'), [
        'school' => 'Université de Douala',
        'degree' => 'Licence',
        'field_of_study' => 'Informatique',
        'start_date' => '2020-09-01',
        'end_date' => '2023-06-30',
    ])->assertRedirect(route('profile.edit'));

    $this->post(route('skill.store'), [
        'name' => 'Laravel',
        'proficiency_level' => 'expert',
        'years_experience' => 4,
    ])->assertRedirect(route('profile.edit'));

    $this->assertDatabaseHas('education', [
        'user_id' => $candidate->id,
        'school' => 'Université de Douala',
        'field_of_study' => 'Informatique',
    ]);

    $this->assertDatabaseHas('user_skills', [
        'user_id' => $candidate->id,
        'proficiency_level' => 'expert',
        'years_experience' => 4,
    ]);
});

it('lets candidates attach their own resume and gives the owning recruiter a profile summary', function () {
    Storage::fake('private');

    $candidate = User::factory()->create([
        'is_recruiter' => false,
        'headline' => 'Développeuse Laravel',
        'bio' => 'Quatre ans de développement web.',
        'location' => 'Douala',
    ]);
    $recruiter = User::factory()->create(['is_recruiter' => true]);
    $otherRecruiter = User::factory()->create(['is_recruiter' => true]);
    $resume = $candidate->resumes()->create([
        'title' => 'CV Développeuse',
        'file_path' => 'resumes/candidate-cv.pdf',
        'is_default' => true,
    ]);
    Storage::disk('private')->put($resume->file_path, 'private resume content');

    $candidate->educations()->create([
        'school' => 'Université de Douala',
        'degree' => 'Licence',
        'field_of_study' => 'Informatique',
        'start_date' => '2020-09-01',
        'end_date' => '2023-06-30',
    ]);
    $skill = \App\Models\Skill::create(['name' => 'Laravel']);
    $candidate->skills()->attach($skill, [
        'proficiency_level' => 'expert',
        'years_experience' => 4,
    ]);

    $jobOffer = JobOffer::create([
        'user_id' => $recruiter->id,
        'title' => 'Développeuse web',
        'description' => 'Développer des applications web.',
        'company' => 'Acme',
        'location' => 'Douala',
        'employment_type' => 'full_time',
        'is_active' => true,
        'posted_at' => now(),
    ]);
    $foreignResume = $otherRecruiter->resumes()->create([
        'title' => 'CV privé',
        'file_path' => 'resumes/other.pdf',
    ]);

    $this->actingAs($candidate)
        ->get(route('job-offer.show', $jobOffer))
        ->assertOk()
        ->assertSee('name="resume_id"', false)
        ->assertSee('name="cover_letter"', false);

    $this->post(route('application.store', $jobOffer), [
        'resume_id' => $foreignResume->id,
    ])->assertSessionHasErrors('resume_id');

    $this->post(route('application.store', $jobOffer), [
        'resume_id' => $resume->id,
        'cover_letter' => 'Je souhaite rejoindre votre équipe.',
    ])->assertRedirect(route('application.index'));

    $this->actingAs($recruiter)
        ->get(route('recruiter.applications'))
        ->assertOk()
        ->assertSee('Développeuse Laravel')
        ->assertSee('Quatre ans de développement web.')
        ->assertSee('Université de Douala')
        ->assertSee('Laravel')
        ->assertSee('Je souhaite rejoindre votre équipe.')
        ->assertSee('CV Développeuse')
        ->assertSee(route('resume.download', $resume), false);

    $this->get(route('resume.download', $resume))
        ->assertDownload('candidate-cv.pdf');

    $this->actingAs($otherRecruiter)
        ->get(route('resume.download', $resume))
        ->assertForbidden();
});
});
