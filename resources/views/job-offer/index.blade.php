@extends('layouts.app')

@section('title', 'Offres d’emploi')

@section('content')
    <div style="display:grid; gap:22px;">
        <div class="card" style="padding:20px 22px;">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:16px;">
                <h1 class="section-title" style="margin:0;">Offres d’emploi</h1>
                <div class="tag-row">
                    <span class="tag">Offres récentes</span>
                    <span class="tag">Offres recommandées</span>
                </div>
            </div>

            <form method="GET" action="{{ route('job-offer.index') }}" style="display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap:12px; align-items:end;">
                <div>
                    <label for="search">Mot-clé</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Ex. Laravel, dev, marketing">
                </div>
                <div>
                    <label for="profession">Métier</label>
                    <input id="profession" type="text" name="profession" value="{{ request('profession') }}" placeholder="Développeur, Designer...">
                </div>
                <div>
                    <label for="company">Entreprise</label>
                    <input id="company" type="text" name="company" value="{{ request('company') }}" placeholder="Nom de l’entreprise">
                </div>
                <div>
                    <label for="location">Localisation</label>
                    <input id="location" type="text" name="location" value="{{ request('location') }}" placeholder="Paris, Lyon, Remote">
                </div>
                <div>
                    <label for="city">Ville</label>
                    <input id="city" type="text" name="city" value="{{ request('city') }}" placeholder="Paris">
                </div>
                <div>
                    <label for="region">Région</label>
                    <select id="region" name="region">
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
                    <label for="domain">Domaine</label>
                    <input id="domain" type="text" name="domain" value="{{ request('domain') }}" placeholder="IT, Marketing, Finance">
                </div>
                <div>
                    <label for="employment_type">Type</label>
                    <select id="employment_type" name="employment_type">
                        <option value="">Tous</option>
                        <option value="full_time" {{ request('employment_type') === 'full_time' ? 'selected' : '' }}>Temps plein</option>
                        <option value="part_time" {{ request('employment_type') === 'part_time' ? 'selected' : '' }}>Temps partiel</option>
                        <option value="contract" {{ request('employment_type') === 'contract' ? 'selected' : '' }}>Contrat</option>
                        <option value="temporary" {{ request('employment_type') === 'temporary' ? 'selected' : '' }}>Temporaire</option>
                        <option value="internship" {{ request('employment_type') === 'internship' ? 'selected' : '' }}>Stage</option>
                    </select>
                </div>
                <div>
                    <label for="required_experience">Expérience</label>
                    <select id="required_experience" name="required_experience">
                        <option value="">Toutes</option>
                        <option value="junior" {{ request('required_experience') === 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="intermediate" {{ request('required_experience') === 'intermediate' ? 'selected' : '' }}>Intermédiaire</option>
                        <option value="senior" {{ request('required_experience') === 'senior' ? 'selected' : '' }}>Senior</option>
                        <option value="5+ years" {{ request('required_experience') === '5+ years' ? 'selected' : '' }}>5+ ans</option>
                    </select>
                </div>
                <div>
                    <label for="education_level">Niveau d’études</label>
                    <select id="education_level" name="education_level">
                        <option value="">Tous</option>
                        <option value="Bachelor" {{ request('education_level') === 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                        <option value="Master" {{ request('education_level') === 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="Diplôme" {{ request('education_level') === 'Diplôme' ? 'selected' : '' }}>Diplôme</option>
                    </select>
                </div>
                <div>
                    <label for="work_mode">Télétravail</label>
                    <select id="work_mode" name="work_mode">
                        <option value="">Tous</option>
                        <option value="remote" {{ request('work_mode') === 'remote' ? 'selected' : '' }}>Télétravail</option>
                        <option value="hybrid" {{ request('work_mode') === 'hybrid' ? 'selected' : '' }}>Hybride</option>
                        <option value="on_site" {{ request('work_mode') === 'on_site' ? 'selected' : '' }}>Présentiel</option>
                    </select>
                </div>
                <div>
                    <label for="salary_min">Salaire min (FCFA)</label>
                    <input id="salary_min" type="number" name="salary_min" value="{{ request('salary_min') }}" placeholder="300000">
                </div>
                <div>
                    <label for="salary_max">Salaire max (FCFA)</label>
                    <input id="salary_max" type="number" name="salary_max" value="{{ request('salary_max') }}" placeholder="1200000">
                </div>
                <div>
                    <label for="sort">Tri</label>
                    <select id="sort" name="sort">
                        <option value="recent" {{ request('sort', 'recent') === 'recent' ? 'selected' : '' }}>Plus récentes</option>
                        <option value="recommended" {{ request('sort') === 'recommended' ? 'selected' : '' }}>Recommandées</option>
                        <option value="salary_high" {{ request('sort') === 'salary_high' ? 'selected' : '' }}>Salaire élevé</option>
                        <option value="salary_low" {{ request('sort') === 'salary_low' ? 'selected' : '' }}>Salaire faible</option>
                    </select>
                </div>
                <div style="display:flex; gap:8px; align-items:end;">
                    <button type="submit" class="btn btn-primary" style="height:52px;">Filtrer</button>
                    <a href="{{ route('job-offer.index') }}" class="btn btn-secondary" style="height:52px;">Réinitialiser</a>
                </div>
            </form>
        </div>

        <div class="grid grid-3">
            @forelse ($jobOffers as $jobOffer)
                <article class="job-card">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                        <span class="badge">{{ strtoupper($jobOffer->employment_type) }}</span>
                        <span class="muted" style="font-size:0.8rem;">{{ $jobOffer->posted_at?->format('d M Y') }}</span>
                    </div>
                    <div>
                        <h3>{{ $jobOffer->title }}</h3>
                        <div class="muted" style="margin-top:8px; font-weight:700;">{{ $jobOffer->company }}</div>
                        <div class="muted" style="margin-top:4px;">{{ $jobOffer->location }} · {{ $jobOffer->city ?? '' }} · {{ $jobOffer->region ?? '' }}</div>
                    </div>
                    <p class="muted" style="margin:0; line-height:1.6;">
                        {{ str($jobOffer->description)->limit(150) }}
                    </p>
                    <div class="tag-row">
                        @foreach (json_decode($jobOffer->required_skills ?? '[]', true) as $skill)
                            <span class="tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; margin-top:auto;">
                        <a href="{{ route('job-offer.show', $jobOffer) }}" class="btn btn-primary" style="padding:0.7rem 1rem;">Voir détail</a>
                        @auth
                            <form method="POST" action="{{ route('favorite.store', $jobOffer) }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="padding:0.7rem 1rem;">Favori</button>
                            </form>
                        @endauth
                    </div>
                </article>
            @empty
                <div class="card" style="grid-column:1/-1;">
                    <p class="muted">Aucune offre ne correspond à votre recherche.</p>
                </div>
            @endforelse
        </div>

        @if ($jobOffers->hasPages())
            <div class="card" style="padding:16px; text-align:center;">
                {{ $jobOffers->links() }}
            </div>
        @endif
    </div>
@endsection
