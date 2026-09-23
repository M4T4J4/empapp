@extends('layouts.app')

@section('title', 'Recherche candidats')

@section('content')
    <div style="display:grid; gap:20px;">
        <div class="card">
            <h1 class="section-title" style="margin:0 0 16px;">Recherche et filtrage des candidats</h1>
            <form method="GET" action="{{ route('recruiter.candidates') }}" style="display:grid; gap:12px; grid-template-columns: 1.2fr 1fr 1fr 120px; align-items:end;">
                <div>
                    <label for="search">Nom</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Jean Dupont">
                </div>
                <div>
                    <label for="location">Localisation</label>
                    <input id="location" type="text" name="location" value="{{ request('location') }}" placeholder="Paris">
                </div>
                <div>
                    <label for="employment_preference">Disponibilité</label>
                    <select id="employment_preference" name="employment_preference">
                        <option value="">Tous</option>
                        <option value="full_time" {{ request('employment_preference') === 'full_time' ? 'selected' : '' }}>Temps plein</option>
                        <option value="part_time" {{ request('employment_preference') === 'part_time' ? 'selected' : '' }}>Temps partiel</option>
                        <option value="contract" {{ request('employment_preference') === 'contract' ? 'selected' : '' }}>Contrat</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="height:52px;">Chercher</button>
            </form>
        </div>

        <div class="grid grid-3">
            @forelse ($candidates as $candidate)
                <article class="job-card">
                    <div style="display:flex; justify-content:space-between; gap:12px; align-items:center;">
                        <strong>{{ $candidate->name }}</strong>
                        <span class="badge">{{ $candidate->employment_preference ?? 'Ouvert' }}</span>
                    </div>
                    <div class="muted">{{ $candidate->location ?? 'Localisation non renseignée' }}</div>
                    <p class="muted" style="margin:0;">{{ Str::limit($candidate->bio ?? 'Profil disponible', 140) }}</p>
                    <div style="margin-top:auto;">
                        <a href="{{ route('profile.show', ['user' => $candidate->id]) }}" class="btn btn-primary" style="padding:0.7rem 1rem;">Voir profil</a>
                    </div>
                </article>
            @empty
                <div class="card" style="grid-column:1/-1;">
                    <p class="muted">Aucun candidat ne correspond aux filtres actuels.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
