<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\JobOffer;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\RecruiterController;
use Illuminate\Support\Facades\Auth;

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/job-offers', function (Request $request) {
        if (Auth::user()?->is_recruiter || Auth::user()?->is_admin) {
            abort(403, 'Accès interdit pour ce type de compte.');
        }

        return app(JobOfferController::class)->index($request);
    })->name('job-offer.index');

    Route::get('/job-offers/{jobOffer}', function (JobOffer $jobOffer) {
        if (Auth::user()?->is_recruiter || Auth::user()?->is_admin) {
            abort(403, 'Accès interdit pour ce type de compte.');
        }

        return app(JobOfferController::class)->show($jobOffer);
    })->name('job-offer.show');
});

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Routes protégées (authentifiées)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()?->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::user()?->is_recruiter) {
            return redirect()->route('recruiter.dashboard');
        }

        return view('dashboard');
    })->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/admin', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/candidates', [App\Http\Controllers\AdminController::class, 'candidates'])->name('admin.candidates');
        Route::get('/admin/companies', [App\Http\Controllers\AdminController::class, 'companies'])->name('admin.companies');
        Route::get('/admin/offers', [App\Http\Controllers\AdminController::class, 'offers'])->name('admin.offers');
        Route::get('/admin/categories', [App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
        Route::get('/admin/regions', [App\Http\Controllers\AdminController::class, 'regions'])->name('admin.regions');
        Route::get('/admin/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/admin/notifications', [App\Http\Controllers\AdminController::class, 'notifications'])->name('admin.notifications');
        Route::post('/admin/users/{user}/toggle-status', [App\Http\Controllers\AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
        Route::post('/admin/users/{user}/toggle-block', [App\Http\Controllers\AdminController::class, 'toggleUserBlock'])->name('admin.users.toggle-block');
        Route::post('/admin/companies/{user}/toggle-approval', [App\Http\Controllers\AdminController::class, 'toggleCompanyApproval'])->name('admin.companies.toggle-approval');
        Route::post('/admin/offers/{jobOffer}/toggle-approval', [App\Http\Controllers\AdminController::class, 'toggleOfferApproval'])->name('admin.offers.toggle-approval');
        Route::delete('/admin/content/{type}/{id}', [App\Http\Controllers\AdminController::class, 'deleteContent'])->name('admin.content.delete');
    });

    Route::get('/recruiter/dashboard', [RecruiterController::class, 'dashboard'])->name('recruiter.dashboard');
    Route::get('/recruiter/profile', [RecruiterController::class, 'profile'])->name('recruiter.profile');
    Route::put('/recruiter/profile', [RecruiterController::class, 'updateProfile'])->name('recruiter.profile.update');
    Route::get('/recruiter/jobs', [RecruiterController::class, 'jobs'])->name('recruiter.jobs');
    Route::get('/recruiter/jobs/create', [JobOfferController::class, 'create'])->name('recruiter.job.create');
    Route::post('/recruiter/jobs', [JobOfferController::class, 'store'])->name('recruiter.job.store');
    Route::get('/recruiter/jobs/{jobOffer}/edit', [JobOfferController::class, 'edit'])->name('recruiter.job.edit');
    Route::put('/recruiter/jobs/{jobOffer}', [JobOfferController::class, 'update'])->name('recruiter.job.update');
    Route::delete('/recruiter/jobs/{jobOffer}', [JobOfferController::class, 'destroy'])->name('recruiter.job.destroy');
    Route::post('/recruiter/jobs/{jobOffer}/toggle', [JobOfferController::class, 'toggle'])->name('recruiter.job.toggle');
    Route::get('/recruiter/applications', [ApplicationController::class, 'recruiterIndex'])->name('recruiter.applications');
    Route::put('/recruiter/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('recruiter.application.status');
    Route::get('/recruiter/candidates', [ApplicationController::class, 'candidates'])->name('recruiter.candidates');

    // Profil
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Compétences
    Route::post('/skills', [SkillController::class, 'store'])->name('skill.store');
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy'])->name('skill.destroy');

    // Formations
    Route::post('/education', [EducationController::class, 'store'])->name('education.store');
    Route::put('/education/{education}', [EducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}', [EducationController::class, 'destroy'])->name('education.destroy');

    // Expériences
    Route::post('/experience', [ExperienceController::class, 'store'])->name('experience.store');
    Route::put('/experience/{experience}', [ExperienceController::class, 'update'])->name('experience.update');
    Route::delete('/experience/{experience}', [ExperienceController::class, 'destroy'])->name('experience.destroy');

    // Langues
    Route::post('/languages', [LanguageController::class, 'store'])->name('language.store');
    Route::delete('/languages/{language}', [LanguageController::class, 'destroy'])->name('language.destroy');

    // CV
    Route::get('/resumes', [ResumeController::class, 'index'])->name('resume.index');
    Route::get('/resumes/{resume}/download', [ResumeController::class, 'download'])->name('resume.download');
    Route::post('/resumes', [ResumeController::class, 'store'])->name('resume.store');
    Route::put('/resumes/{resume}', [ResumeController::class, 'update'])->name('resume.update');
    Route::post('/resumes/{resume}/set-default', [ResumeController::class, 'setDefault'])->name('resume.setDefault');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resume.destroy');

    // Candidatures
    Route::get('/applications', [ApplicationController::class, 'index'])->name('application.index');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('application.show');
    Route::post('/job-offers/{jobOffer}/apply', [ApplicationController::class, 'store'])->name('application.store');
    Route::delete('/applications/{application}', [ApplicationController::class, 'cancel'])->name('application.cancel');

    // Favoris
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/job-offers/{jobOffer}/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notification.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notification.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notification.readAll');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notification.destroy');

    // Profil public
    Route::get('/profile/public/{user}', [App\Http\Controllers\ProfileController::class, 'publicProfile'])->name('profile.public');
    Route::get('/company/{user}', [App\Http\Controllers\ProfileController::class, 'companyProfile'])->name('company.public');
    Route::get('/candidate/recommendations', [App\Http\Controllers\ProfileController::class, 'recommendations'])->name('candidate.recommendations');
    Route::get('/matching', [App\Http\Controllers\ProfileController::class, 'matching'])->name('candidate.matching');
    Route::post('/job-offers/{jobOffer}/share', [App\Http\Controllers\JobOfferController::class, 'share'])->name('job-offer.share');
    Route::get('/cv/generate', [App\Http\Controllers\ResumeController::class, 'generate'])->name('resume.generate');
    Route::post('/cv/import', [App\Http\Controllers\ResumeController::class, 'import'])->name('resume.import');
    Route::get('/premium', [App\Http\Controllers\PremiumController::class, 'index'])->name('premium.index');
    Route::post('/premium/checkout', [App\Http\Controllers\PremiumController::class, 'checkout'])->name('premium.checkout');
    Route::get('/recruiter/stats', [App\Http\Controllers\RecruiterController::class, 'stats'])->name('recruiter.stats');
    Route::get('/recruiter/offer-stats', [App\Http\Controllers\RecruiterController::class, 'offerStats'])->name('recruiter.offer-stats');

    // Messages
    Route::get('/messages', [App\Http\Controllers\MessageController::class, 'index'])->name('message.index');
    Route::get('/messages/{user}', [App\Http\Controllers\MessageController::class, 'show'])->name('message.show');
    Route::post('/messages/{user}', [App\Http\Controllers\MessageController::class, 'store'])->name('message.store');

    // Alertes
    Route::get('/alerts', [AlertController::class, 'index'])->name('alert.index');
    Route::post('/alerts', [AlertController::class, 'store'])->name('alert.store');
    Route::put('/alerts/{alert}', [AlertController::class, 'update'])->name('alert.update');
    Route::delete('/alerts/{alert}', [AlertController::class, 'destroy'])->name('alert.destroy');
});


Route::get('/users-debug', function () {
    return \App\Models\User::select('id', 'name', 'email', 'is_admin')->get();
});