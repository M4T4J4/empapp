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
| Routes des offres d'emploi
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/job-offers', function (Request $request) {

        // Les recruteurs et administrateurs ne peuvent pas accéder
        // à l'espace de recherche des candidats.
        if (Auth::user()?->is_recruiter || Auth::user()?->is_admin) {
            abort(403, 'Accès interdit pour ce type de compte.');
        }

        return app(JobOfferController::class)->index($request);

    })->name('job-offer.index');


    Route::get('/job-offers/{jobOffer}', function (JobOffer $jobOffer) {

        // Les recruteurs et administrateurs ne peuvent pas accéder
        // à cet espace.
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
    | Pas de AdminMiddleware.
    | On vérifie directement is_admin dans chaque route.
    |
    */


    // Dashboard administrateur
    Route::get('/admin', function () {

        if (!Auth::check()) {
            abort(403, 'Utilisateur non connecté.');
        }

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->dashboard();

    })->name('admin.dashboard');


    // Utilisateurs
    Route::get('/admin/users', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->users();

    })->name('admin.users');


    // Candidats
    Route::get('/admin/candidates', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->candidates();

    })->name('admin.candidates');


    // Entreprises
    Route::get('/admin/companies', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->companies();

    })->name('admin.companies');


    // Offres
    Route::get('/admin/offers', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->offers();

    })->name('admin.offers');


    // Catégories
    Route::get('/admin/categories', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->categories();

    })->name('admin.categories');


    // Régions
    Route::get('/admin/regions', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->regions();

    })->name('admin.regions');


    // Rapports
    Route::get('/admin/reports', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->reports();

    })->name('admin.reports');


    // Notifications
    Route::get('/admin/notifications', function () {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->notifications();

    })->name('admin.notifications');


    /*
    |--------------------------------------------------------------------------
    | Actions administrateur
    |--------------------------------------------------------------------------
    */


    // Activer / désactiver un utilisateur
    Route::post('/admin/users/{user}/toggle-status', function (User $user) {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->toggleUserStatus($user);

    })->name('admin.users.toggle-status');


    // Bloquer / débloquer un utilisateur
    Route::post('/admin/users/{user}/toggle-block', function (User $user) {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->toggleUserBlock($user);

    })->name('admin.users.toggle-block');


    // Approuver / désapprouver une entreprise
    Route::post('/admin/companies/{user}/toggle-approval', function (User $user) {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->toggleCompanyApproval($user);

    })->name('admin.companies.toggle-approval');


    // Approuver / désapprouver une offre
    Route::post('/admin/offers/{jobOffer}/toggle-approval', function (JobOffer $jobOffer) {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->toggleOfferApproval($jobOffer);

    })->name('admin.offers.toggle-approval');


    // Supprimer du contenu
    Route::delete('/admin/content/{type}/{id}', function ($type, $id) {

        if (!Auth::user()->is_admin) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return app(AdminController::class)->deleteContent($type, $id);

    })->name('admin.content.delete');


    /*
    |--------------------------------------------------------------------------
    | Autres routes protégées
    |--------------------------------------------------------------------------
    |
    | Garde ici tes autres routes :
    | profil, compétences, CV, candidatures, favoris,
    | notifications, alertes, etc.
    |
    */

});


/*
|--------------------------------------------------------------------------
| DEBUG - Vérification des utilisateurs
|--------------------------------------------------------------------------
*/

Route::get('/users-debug', function () {

    return User::select(
        'id',
        'name',
        'email',
        'is_admin'
    )->get();

});


/*
|--------------------------------------------------------------------------
| DEBUG - Vérification de l'utilisateur connecté
|--------------------------------------------------------------------------
*/

Route::get('/admin-test', function () {

    if (!Auth::check()) {
        return 'PAS CONNECTE';
    }

    return [
        'id' => Auth::user()->id,
        'name' => Auth::user()->name,
        'email' => Auth::user()->email,
        'is_admin' => Auth::user()->is_admin,
        'is_recruiter' => Auth::user()->is_recruiter,
    ];

})->middleware('auth');