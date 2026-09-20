<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user()->load([
            'skills', 'languages', 'educations', 'experiences', 'resumes'
        ]);

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $this->ensureDefaultLanguages();
        $languages = Language::orderBy('name')->get();

        return view('profile.edit', compact('user', 'languages'));
    }

    protected function ensureDefaultLanguages(): void
    {
        $defaults = [
            ['name' => 'Français', 'code' => 'fr'],
            ['name' => 'Anglais', 'code' => 'en'],
        ];

        foreach ($defaults as $language) {
            Language::firstOrCreate(
                ['code' => $language['code']],
                ['name' => $language['name']]
            );
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'headline' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'employment_preference' => ['nullable', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        if (! empty($validated['employment_preference'])) {
            $validated['employment_preference'] = match ($validated['employment_preference']) {
                'cdi', 'full_time' => 'full_time',
                'cdd', 'contract' => 'contract',
                'stage', 'internship' => 'internship',
                default => $validated['employment_preference'],
            };
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $validated['profile_photo'] = $path;
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil mis à jour!');
    }

    public function publicProfile(User $user)
    {
        return view('profile.public', compact('user'));
    }

    public function companyProfile(User $user)
    {
        return view('company.public', compact('user'));
    }

    public function recommendations()
    {
        $offers = JobOffer::query()
            ->where('is_active', true)
            ->latest('posted_at')
            ->take(6)
            ->get();

        return view('profile.recommendations', compact('offers'));
    }

    public function matching()
    {
        $offers = JobOffer::query()
            ->where('is_active', true)
            ->latest('posted_at')
            ->take(6)
            ->get();

        return view('profile.matching', compact('offers'));
    }
}
