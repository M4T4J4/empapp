<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecruiterController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $offers = JobOffer::query()
            ->where('user_id', $user->id)
            ->latest('posted_at')
            ->paginate(8);

        $applications = Application::query()
            ->whereHas('jobOffer', fn ($query) => $query->where('user_id', $user->id))
            ->with(['jobOffer', 'user', 'resume'])
            ->latest('applied_at')
            ->take(10)
            ->get();

        return view('recruiter.dashboard', compact('offers', 'applications'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('recruiter.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_description' => ['nullable', 'string', 'max:2000'],
            'company_website' => ['nullable', 'url', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'company_location' => ['nullable', 'string', 'max:255'],
            'company_size' => ['nullable', 'string', 'max:100'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['company_logo'] = $request->file('logo')->store('company-logos', 'public');
        }

        $user->update($validated);

        return redirect()->route('recruiter.profile')->with('success', 'Profil entreprise mis à jour.');
    }

    public function jobs()
    {
        $offers = JobOffer::query()
            ->where('user_id', Auth::id())
            ->latest('posted_at')
            ->paginate(10);

        return view('recruiter.jobs', compact('offers'));
    }

    public function stats()
    {
        $user = Auth::user();

        $stats = [
            'offers' => JobOffer::where('user_id', $user->id)->count(),
            'applications' => Application::whereHas('jobOffer', fn ($query) => $query->where('user_id', $user->id))->count(),
            'candidates' => User::where('is_recruiter', false)->count(),
        ];

        return view('recruiter.stats', compact('stats'));
    }

    public function offerStats()
    {
        $user = Auth::user();

        $stats = JobOffer::where('user_id', $user->id)
            ->selectRaw('count(*) as total, sum(case when is_active = 1 then 1 else 0 end) as active')
            ->first();

        return response()->json($stats);
    }
}
