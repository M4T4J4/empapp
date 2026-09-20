@extends('layouts.app')

@section('title', 'Offres d’emploi')

@section('content')
    <div class="space-y-6">
        <div class="card">
            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">Jobs</p>
                    <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Offres d’emploi</h1>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span class="tag">Offres récentes</span>
                    <span class="tag">Offres recommandées</span>
                </div>
            </div>

            <form method="GET" action="{{ route('job-offer.index') }}" class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">Mot-clé</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Ex. Laravel, dev, marketing" class="input-field">
                </div>
                <div>
                    <label for="profession" class="mb-2 block text-sm font-semibold text-slate-700">Métier</label>
                    <input id="profession" type="text" name="profession" value="{{ request('profession') }}" placeholder="Développeur, Designer..." class="input-field">
                </div>
                <div>
                    <label for="company" class="mb-2 block text-sm font-semibold text-slate-700">Entreprise</label>
                    <input id="company" type="text" name="company" value="{{ request('company') }}" placeholder="Nom de l’entreprise" class="input-field">
                </div>
                <div>
                    <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Localisation</label>
                    <input id="location" type="text" name="location" value="{{ request('location') }}" placeholder="Paris, Lyon, Remote" class="input-field">
                </div>
                <div>
                    <label for="city" class="mb-2 block text-sm font-semibold text-slate-700">Ville</label>
                    <input id="city" type="text" name="city" value="{{ request('city') }}" placeholder="Paris" class="input-field">
                </div>
                <div>
                    <label for="region" class="mb-2 block text-sm font-semibold text-slate-700">Région</label>
                    <select id="region" name="region" class="input-field">
                        <option value="">Toutes</option>
                        <option value="Centre" {{ request('region') === 'Centre' ? 'selected' : '' }}>Centre</option>
                        <option value="Littoral" {{ request('region') === 'Littoral' ? 'selected' : '' }}>Littoral</option>
                        <option value="Nord" {{ request('region') === 'Nord' ? 'selected' : '' }}>Nord</option>
                        <option value="Sud" {{ request('region') === 'Sud' ? 'selected' : '' }}>Sud</option>
                        <option value="Ouest" {{ request('region') === 'Ouest' ? 'selected' : '' }}>Ouest</option>
                        <option value="Adamaoua" {{ request('region') === 'Adamaoua' ? 'selected' : '' }}>Adamaoua</option>
                        <option value="Est" {{ request('region') === 'Est' ? 'selected' : '' }}>Est</option>
                        <option value="Extreme-Nord" {{ request('region') === 'Extreme-Nord' ? 'selected' : '' }}>Extrême-Nord</option>
                        <option value="Nord-Ouest" {{ request('region') === 'Nord-Ouest' ? 'selected' : '' }}>Nord-Ouest</option>
                        <option value="Sud-Ouest" {{ request('region') === 'Sud-Ouest' ? 'selected' : '' }}>Sud-Ouest</option>
                    </select>
                </div>
                <div>
                    <label for="domain" class="mb-2 block text-sm font-semibold text-slate-700">Domaine</label>
                    <input id="domain" type="text" name="domain" value="{{ request('domain') }}" placeholder="IT, Marketing, Finance" class="input-field">
                </div>
                <div>
                    <label for="employment_type" class="mb-2 block text-sm font-semibold text-slate-700">Type</label>
                    <select id="employment_type" name="employment_type" class="input-field">
                        <option value="">Tous</option>
                        <option value="full_time" {{ request('employment_type') === 'full_time' ? 'selected' : '' }}>Temps plein</option>
                        <option value="part_time" {{ request('employment_type') === 'part_time' ? 'selected' : '' }}>Temps partiel</option>
                        <option value="contract" {{ request('employment_type') === 'contract' ? 'selected' : '' }}>Contrat</option>
                        <option value="temporary" {{ request('employment_type') === 'temporary' ? 'selected' : '' }}>Temporaire</option>
                        <option value="internship" {{ request('employment_type') === 'internship' ? 'selected' : '' }}>Stage</option>
                    </select>
                </div>
                <div>
                    <label for="required_experience" class="mb-2 block text-sm font-semibold text-slate-700">Expérience</label>
                    <select id="required_experience" name="required_experience" class="input-field">
                        <option value="">Toutes</option>
                        <option value="junior" {{ request('required_experience') === 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="intermediate" {{ request('required_experience') === 'intermediate' ? 'selected' : '' }}>Intermédiaire</option>
                        <option value="senior" {{ request('required_experience') === 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="5+ years" {{ request('required_experience') === '5+ years' ? 'selected' : '' }}>5+ ans</option>
                    </select>
                </div>
                <div>
                    <label for="education_level" class="mb-2 block text-sm font-semibold text-slate-700">Niveau d’études</label>
                    <select id="education_level" name="education_level" class="input-field">
                        <option value="">Tous</option>
                        <option value="Bachelor" {{ request('education_level') === 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                        <option value="Master" {{ request('education_level') === 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="Diplôme" {{ request('education_level') === 'Diplôme' ? 'selected' : '' }}>Diplôme</option>
                    </select>
                </div>
                <div>
                    <label for="work_mode" class="mb-2 block text-sm font-semibold text-slate-700">Télétravail</label>
                    <select id="work_mode" name="work_mode" class="input-field">
                        <option value="">Tous</option>
                        <option value="remote" {{ request('work_mode') === 'remote' ? 'selected' : '' }}>Télétravail</option>
                        <option value="hybrid" {{ request('work_mode') === 'hybrid' ? 'selected' : '' }}>Hybride</option>
                        <option value="on_site" {{ request('work_mode') === 'on_site' ? 'selected' : '' }}>Présentiel</option>
                    </select>
                </div>
                <div>
                    <label for="salary_min" class="mb-2 block text-sm font-semibold text-slate-700">Salaire min</label>
                    <input id="salary_min" type="number" name="salary_min" value="{{ request('salary_min') }}" placeholder="300000" class="input-field">
                </div>
                <div>
                    <label for="salary_max" class="mb-2 block text-sm font-semibold text-slate-700">Salaire max</label>
                    <input id="salary_max" type="number" name="salary_max" value="{{ request('salary_max') }}" placeholder="1200000" class="input-field">
                </div>
                <div>
                    <label for="sort" class="mb-2 block text-sm font-semibold text-slate-700">Tri</label>
                    <select id="sort" name="sort" class="input-field">
                        <option value="recent" {{ request('sort', 'recent') === 'recent' ? 'selected' : '' }}>Plus récentes</option>
                        <option value="recommended" {{ request('sort') === 'recommended' ? 'selected' : '' }}>Recommandées</option>
                        <option value="salary_high" {{ request('sort') === 'salary_high' ? 'selected' : '' }}>Salaire élevé</option>
                        <option value="salary_low" {{ request('sort') === 'salary_low' ? 'selected' : '' }}>Salaire faible</option>
                    </select>
                </div>
                <div class="flex items-end gap-3 xl:col-span-1">
                    <button type="submit" class="btn btn-primary h-[52px]">Filtrer</button>
                    <a href="{{ route('job-offer.index') }}" class="btn btn-secondary h-[52px]">Réinitialiser</a>
                </div>
            </form>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($jobOffers as $jobOffer)
                <article class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <span class="badge">{{ strtoupper($jobOffer->employment_type) }}</span>
                        <span class="text-xs font-medium text-slate-400">{{ $jobOffer->posted_at?->format('d M Y') }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $jobOffer->title }}</h3>
                        <div class="mt-2 text-sm font-semibold text-slate-600">{{ $jobOffer->company }}</div>
                        <div class="mt-1 text-sm text-slate-500">{{ $jobOffer->location }} · {{ $jobOffer->city ?? '' }} · {{ $jobOffer->region ?? '' }}</div>
                    </div>
                    <p class="mt-4 line-clamp-3 text-sm leading-6 text-slate-600">
                        {{ str($jobOffer->description)->limit(150) }}
                    </p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach (json_decode($jobOffer->required_skills ?? '[]', true) as $skill)
                            <span class="tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                    <div class="mt-5 flex items-center justify-between gap-3">
                        <a href="{{ route('job-offer.show', $jobOffer) }}" class="btn btn-primary">Voir détail</a>
                        @auth
                            <form method="POST" action="{{ route('favorite.store', $jobOffer) }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary">Favori</button>
                            </form>
                        @endauth
                    </div>
                </article>
            @empty
                <div class="card md:col-span-2 xl:col-span-3">
                    <p class="text-slate-600">Aucune offre ne correspond à votre recherche.</p>
                </div>
            @endforelse
        </div>

        @if ($jobOffers->hasPages())
            <div class="card flex justify-center">
                {{ $jobOffers->links() }}
            </div>
        @endif
    </div>
@endsection
