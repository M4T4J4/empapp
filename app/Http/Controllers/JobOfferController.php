<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    protected function normalizeEmploymentType(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($value) {
            'cdi', 'full_time' => 'full_time',
            'cdd', 'contract' => 'contract',
            'stage', 'internship' => 'internship',
            'freelance', 'independant', 'independent' => 'contract',
            'temporary', 'part_time' => $value,
            default => $value,
        };
    }

    protected function parseListValue(mixed $value): ?array
    {
        if (is_null($value)) {
            return null;
        }

        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', $value)));
        }

        return array_values(array_filter(array_map('trim', preg_split('/[,;\n]+/', (string) $value))));
    }

    public function create()
    {
        return view('recruiter.job-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'domain' => ['nullable', 'string', 'max:255'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'required_experience' => ['nullable', 'string', 'max:255'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'work_mode' => ['nullable', 'in:remote,hybrid,on_site'],
            'required_skills' => ['nullable'],
            'benefits' => ['nullable'],
            'deadline' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['employment_type'] = $this->normalizeEmploymentType($validated['employment_type']);
        $validated['required_skills'] = $this->parseListValue($validated['required_skills'] ?? null);
        $validated['benefits'] = $this->parseListValue($validated['benefits'] ?? null);
        $validated['user_id'] = Auth::id();
        $validated['posted_at'] = now();
        $validated['company'] = $validated['company'] ?? Auth::user()->company_name ?? Auth::user()->name;

        JobOffer::create($validated);

        return redirect()->route('recruiter.jobs')->with('success', 'Offre publiée avec succès.');
    }

    public function edit(JobOffer $jobOffer)
    {
        if ($jobOffer->user_id !== Auth::id()) {
            abort(403);
        }

        return view('recruiter.job-edit', compact('jobOffer'));
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        if ($jobOffer->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'domain' => ['nullable', 'string', 'max:255'],
            'salary_min' => ['nullable', 'numeric', 'min:0'],
            'salary_max' => ['nullable', 'numeric', 'min:0'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'required_experience' => ['nullable', 'string', 'max:255'],
            'education_level' => ['nullable', 'string', 'max:255'],
            'work_mode' => ['nullable', 'in:remote,hybrid,on_site'],
            'required_skills' => ['nullable'],
            'benefits' => ['nullable'],
            'deadline' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['employment_type'] = $this->normalizeEmploymentType($validated['employment_type']);
        $validated['required_skills'] = $this->parseListValue($validated['required_skills'] ?? null);
        $validated['benefits'] = $this->parseListValue($validated['benefits'] ?? null);

        $jobOffer->update($validated);

        return redirect()->route('recruiter.jobs')->with('success', 'Offre mise à jour.');
    }

    public function destroy(JobOffer $jobOffer)
    {
        if ($jobOffer->user_id !== Auth::id()) {
            abort(403);
        }

        $jobOffer->delete();

        return redirect()->route('recruiter.jobs')->with('success', 'Offre supprimée.');
    }

    public function toggle(JobOffer $jobOffer)
    {
        if ($jobOffer->user_id !== Auth::id()) {
            abort(403);
        }

        $jobOffer->update(['is_active' => ! $jobOffer->is_active]);

        return redirect()->back()->with('success', 'Statut de l’offre mis à jour.');
    }

    public function index(Request $request)
    {
        $query = JobOffer::query()->where('is_active', true);

        $search = trim((string) $request->input('search', ''));
        $profession = trim((string) $request->input('profession', ''));
        $company = trim((string) $request->input('company', ''));
        $location = trim((string) $request->input('location', ''));
        $city = trim((string) $request->input('city', ''));
        $region = trim((string) $request->input('region', ''));
        $domain = trim((string) $request->input('domain', ''));
        $employmentType = $request->input('employment_type');
        $requiredExperience = trim((string) $request->input('required_experience', ''));
        $educationLevel = trim((string) $request->input('education_level', ''));
        $workMode = $request->input('work_mode');
        $salaryMin = $request->input('salary_min');
        $salaryMax = $request->input('salary_max');
        $sort = $request->input('sort', 'recent');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($profession !== '') {
            $query->where('title', 'like', "%{$profession}%");
        }

        if ($company !== '') {
            $query->where('company', 'like', "%{$company}%");
        }

        if ($location !== '') {
            $query->where(function ($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                    ->orWhere('city', 'like', "%{$location}%")
                    ->orWhere('region', 'like', "%{$location}%");
            });
        }

        if ($city !== '') {
            $query->where('city', 'like', "%{$city}%");
        }

        if ($region !== '') {
            $query->where('region', 'like', "%{$region}%");
        }

        if ($domain !== '') {
            $query->where('domain', 'like', "%{$domain}%");
        }

        if ($employmentType !== null && $employmentType !== '') {
            $query->where('employment_type', $employmentType);
        }

        if ($requiredExperience !== '') {
            $query->where('required_experience', 'like', "%{$requiredExperience}%");
        }

        if ($educationLevel !== '') {
            $query->where('education_level', 'like', "%{$educationLevel}%");
        }

        if ($workMode !== null && $workMode !== '') {
            $query->where('work_mode', $workMode);
        }

        if ($salaryMin !== null && $salaryMin !== '') {
            $query->where('salary_max', '>=', (float) $salaryMin);
        }

        if ($salaryMax !== null && $salaryMax !== '') {
            $query->where('salary_min', '<=', (float) $salaryMax);
        }

        if ($sort === 'salary_high') {
            $query->orderByDesc('salary_max')->orderByDesc('posted_at');
        } elseif ($sort === 'salary_low') {
            $query->orderBy('salary_min')->orderByDesc('posted_at');
        } elseif ($sort === 'recommended') {
            $query->orderByDesc('posted_at');
        } else {
            $query->latest('posted_at');
        }

        $jobOffers = $query->paginate(15)->appends($request->query());

        return view('job-offer.index', compact('jobOffers', 'sort'));
    }

    public function show(JobOffer $jobOffer)
    {
        $isFavorite = false;
        $hasApplied = false;

        if (Auth::check()) {
            $isFavorite = Auth::user()->favorites()->where('job_offer_id', $jobOffer->id)->exists();
            $hasApplied = Auth::user()->applications()->where('job_offer_id', $jobOffer->id)->exists();
        }

        return view('job-offer.show', compact('jobOffer', 'isFavorite', 'hasApplied'));
    }

    public function share(JobOffer $jobOffer)
    {
        return redirect()->back()->with('success', 'Offre partagée avec succès.');
    }
}
