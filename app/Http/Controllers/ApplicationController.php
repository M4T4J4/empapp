<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, JobOffer $jobOffer)
    {
        // Vérifier si l'utilisateur a déjà postulé
        if (Auth::user()->applications()->where('job_offer_id', $jobOffer->id)->exists()) {
            return redirect()->back()->with('error', 'Vous avez déjà postulé à cette offre!');
        }

        $validated = $request->validate([
            'resume_id' => ['nullable', 'exists:resumes,id'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
        ]);

        $application = Auth::user()->applications()->create([
            'job_offer_id' => $jobOffer->id,
            'resume_id' => $validated['resume_id'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        // Notifications : confirmation côté candidat + alerte côté recruteur
        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Candidature envoyée',
            'message' => "Vous avez postulé pour l'offre: {$jobOffer->title}",
            'type' => 'application',
            'related_id' => $application->id,
        ]);

        Notification::create([
            'user_id' => $jobOffer->user_id,
            'title' => 'Nouvelle candidature',
            'message' => "Une candidature a été reçue pour l'offre: {$jobOffer->title}.",
            'type' => 'application',
            'related_id' => $application->id,
        ]);

        return redirect()->route('application.index')->with('success', 'Candidature envoyée!');
    }

    public function index()
    {
        $applications = Auth::user()->applications()->with('jobOffer')
            ->latest('applied_at')
            ->paginate(10);

        return view('application.index', compact('applications'));
    }

    public function show(Application $application)
    {
        $this->authorize('view', $application);
        return view('application.show', compact('application'));
    }

    public function cancel(Application $application)
    {
        $this->authorize('delete', $application);

        if (!in_array($application->status, ['pending', 'viewed'])) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas retirer cette candidature!');
        }

        $application->delete();

        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Candidature retirée',
            'message' => "Vous avez retiré votre candidature pour: {$application->jobOffer->title}",
            'type' => 'application',
        ]);

        return redirect()->route('application.index')->with('success', 'Candidature retirée!');
    }

    public function recruiterIndex(Request $request)
    {
        $user = Auth::user();

        $applications = Application::query()
            ->whereHas('jobOffer', fn ($query) => $query->where('user_id', $user->id))
            ->with(['jobOffer', 'user', 'resume'])
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('jobOffer', fn ($q) => $q->where('title', 'like', "%{$search}%"));
            })
            ->latest('applied_at')
            ->paginate(12);

        return view('recruiter.applications', compact('applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $this->authorize('updateStatus', $application);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,viewed,accepted,rejected'],
        ]);

        $previousStatus = $application->status;
        $newStatus = $validated['status'];

        if ($previousStatus === $newStatus) {
            return redirect()->back()->with('success', 'Statut déjà défini.');
        }

        $application->update(['status' => $newStatus]);

        $statusMap = [
            'pending' => 'En attente',
            'viewed' => 'Vue',
            'accepted' => 'Acceptée',
            'rejected' => 'Refusée',
        ];

        $previousStatusLabel = $statusMap[$previousStatus] ?? $previousStatus;
        $newStatusLabel = $statusMap[$newStatus] ?? $newStatus;

        Notification::create([
            'user_id' => $application->user_id,
            'title' => 'Changement de statut',
            'message' => "Le statut de votre candidature pour {$application->jobOffer->title} est passé de {$previousStatusLabel} à {$newStatusLabel}.",
            'type' => 'status_update',
            'related_id' => $application->id,
        ]);

        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    public function candidates(Request $request)
    {
        $user = Auth::user();

        $query = \App\Models\User::query()
            ->where('is_recruiter', false)
            ->whereHas('applications', function ($query) use ($user) {
                $query->whereHas('jobOffer', fn ($jobQuery) => $jobQuery->where('user_id', $user->id));
            })
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->filled('location'), fn ($q) => $q->where('location', 'like', "%{$request->location}%"))
            ->when($request->filled('employment_preference'), fn ($q) => $q->where('employment_preference', $request->employment_preference));

        $candidates = $query->paginate(12);

        return view('recruiter.candidates', compact('candidates'));
    }
}
