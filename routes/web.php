<?php

use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Routes offres d'emploi pour les candidats
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Authentification
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Inscription
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register']);


    // Connexion
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);

});


/*
|--------------------------------------------------------------------------
| Déconnexion
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Routes protégées
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        // Administrateur
        if (Auth::user()?->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // Recruteur
        if (Auth::user()?->is_recruiter) {
            return redirect()->route('recruiter.dashboard');
        }

        // Candidat
        return view('dashboard');

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMINISTRATION
    |--------------------------------------------------------------------------
    |
    | Le middleware "admin" vérifie que l'utilisateur possède
    | is_admin = true.
    |
    */

    Route::middleware('admin')->group(function () {


        /*
        |--------------------------------------------------------------------------
        | Dashboard administrateur
        |--------------------------------------------------------------------------
        */

        Route::get('/admin', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Gestion des utilisateurs
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/users', [AdminController::class, 'users'])
            ->name('admin.users');


        /*
        |--------------------------------------------------------------------------
        | Gestion des candidats
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/candidates', [AdminController::class, 'candidates'])
            ->name('admin.candidates');


        /*
        |--------------------------------------------------------------------------
        | Gestion des entreprises
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/companies', [AdminController::class, 'companies'])
            ->name('admin.companies');


        /*
        |--------------------------------------------------------------------------
        | Gestion des offres
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/offers', [AdminController::class, 'offers'])
            ->name('admin.offers');


        /*
        |--------------------------------------------------------------------------
        | Gestion des catégories
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/categories', [AdminController::class, 'categories'])
            ->name('admin.categories');


        /*
        |--------------------------------------------------------------------------
        | Gestion des régions
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/regions', [AdminController::class, 'regions'])
            ->name('admin.regions');


        /*
        |--------------------------------------------------------------------------
        | Rapports
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/reports', [AdminController::class, 'reports'])
            ->name('admin.reports');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/admin/notifications', [AdminController::class, 'notifications'])
            ->name('admin.notifications');


        /*
        |--------------------------------------------------------------------------
        | Activer / désactiver un utilisateur
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/admin/users/{user}/toggle-status',
            [AdminController::class, 'toggleUserStatus']
        )->name('admin.users.toggle-status');


        /*
        |--------------------------------------------------------------------------
        | Bloquer / débloquer un utilisateur
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/admin/users/{user}/toggle-block',
            [AdminController::class, 'toggleUserBlock']
        )->name('admin.users.toggle-block');


        /*
        |--------------------------------------------------------------------------
        | Approuver / désapprouver une entreprise
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/admin/companies/{user}/toggle-approval',
            [AdminController::class, 'toggleCompanyApproval']
        )->name('admin.companies.toggle-approval');


        /*
        |--------------------------------------------------------------------------
        | Approuver / désapprouver une offre
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/admin/offers/{jobOffer}/toggle-approval',
            [AdminController::class, 'toggleOfferApproval']
        )->name('admin.offers.toggle-approval');


        /*
        |--------------------------------------------------------------------------
        | Supprimer du contenu
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/admin/content/{type}/{id}',
            [AdminController::class, 'deleteContent']
        )->name('admin.content.delete');

    });


    /*
    |--------------------------------------------------------------------------
    | Autres routes protégées
    |--------------------------------------------------------------------------
    |
    | Garde ici tes autres routes :
    | profil, compétences, CV, candidatures, favoris, etc.
    |
    */


});


/*
|--------------------------------------------------------------------------
| Route temporaire de debug
|--------------------------------------------------------------------------
|
| Permet de vérifier que l'utilisateur administrateur existe
| bien dans la base de données Render.
|
*/

Route::get('/users-debug', function () {

    return User::select(
        'id',
        'name',
        'email',
        'is_admin'
    )->get();

});