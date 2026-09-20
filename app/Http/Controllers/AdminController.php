<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $this->authorize('access-admin');

        $stats = [
            'users' => User::count(),
            'candidates' => User::where('is_recruiter', false)->count(),
            'companies' => User::where('is_recruiter', true)->count(),
            'offers' => JobOffer::count(),
            'pending_offers' => JobOffer::where('is_active', false)->count(),
            'premium_users' => User::where('is_premium', true)->count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
        ];

        $recentUsers = User::latest()->take(8)->get();
        $recentOffers = JobOffer::with('user')->latest()->take(8)->get();
        $notifications = Notification::latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentOffers', 'notifications'));
    }

    public function users()
    {
        $this->authorize('access-admin');

        $users = User::latest()->paginate(12);

        return view('admin.users', compact('users'));
    }

    public function candidates()
    {
        $this->authorize('access-admin');

        $candidates = User::where('is_recruiter', false)->latest()->paginate(12);

        return view('admin.candidates', compact('candidates'));
    }

    public function companies()
    {
        $this->authorize('access-admin');

        $companies = User::where('is_recruiter', true)->latest()->paginate(12);

        return view('admin.companies', compact('companies'));
    }

    public function offers()
    {
        $this->authorize('access-admin');

        $offers = JobOffer::with('user')->latest()->paginate(12);

        return view('admin.offers', compact('offers'));
    }

    public function categories()
    {
        $this->authorize('access-admin');

        return view('admin.categories');
    }

    public function regions()
    {
        $this->authorize('access-admin');

        return view('admin.regions');
    }

    public function reports()
    {
        $this->authorize('access-admin');

        $reports = collect([
            [
                'title' => 'Profil d’entreprise signalé',
                'type' => 'entreprise',
                'status' => 'À examiner',
            ],
            [
                'title' => 'Offre suspecte',
                'type' => 'offre',
                'status' => 'En modération',
            ],
            [
                'title' => 'Annonce frauduleuse',
                'type' => 'contenu',
                'status' => 'Bloquée',
            ],
        ]);

        return view('admin.reports', compact('reports'));
    }

    public function notifications()
    {
        $this->authorize('access-admin');

        $notifications = Notification::with('user')->latest()->paginate(15);

        return view('admin.notifications', compact('notifications'));
    }

    public function toggleUserStatus(User $user)
    {
        $this->authorize('access-admin');

        $user->update(['is_admin' => ! $user->is_admin]);

        return redirect()->back()->with('success', 'Statut utilisateur mis à jour.');
    }

    public function toggleOfferApproval(JobOffer $jobOffer)
    {
        $this->authorize('access-admin');

        $jobOffer->update(['is_active' => ! $jobOffer->is_active]);

        return redirect()->back()->with('success', 'Validation de l’offre mise à jour.');
    }

    public function toggleUserBlock(User $user)
    {
        $this->authorize('access-admin');

        $user->update(['is_blocked' => ! $user->is_blocked]);

        return redirect()->back()->with('success', 'Statut de blocage mis à jour.');
    }

    public function toggleCompanyApproval(User $user)
    {
        $this->authorize('access-admin');

        $user->update(['is_verified' => ! $user->is_verified]);

        return redirect()->back()->with('success', 'Validation de l’entreprise mise à jour.');
    }

    public function deleteContent(string $type, int $id)
    {
        $this->authorize('access-admin');

        if ($type === 'user') {
            User::findOrFail($id)->delete();
        }

        if ($type === 'offer') {
            JobOffer::findOrFail($id)->delete();
        }

        if ($type === 'application') {
            Application::findOrFail($id)->delete();
        }

        return redirect()->back()->with('success', 'Contenu supprimé.');
    }
}
