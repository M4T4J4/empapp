@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $user = Auth::user();
        $recentJobs = \App\Models\JobOffer::query()->where('is_active', true)->latest('posted_at')->limit(4)->get();
        $applications = $user->applications()->with('jobOffer')->latest('applied_at')->limit(3)->get();
        $favorites = $user->favorites()->with('jobOffer')->latest()->limit(3)->get();
    @endphp

    <div style="display:grid; gap:24px;">
        <div class="hero">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;">
                <div>
                    <p class="muted" style="margin:0 0 10px; font-weight:700; color:var(--primary-dark);">Bienvenue, {{ $user->name }}</p>
                    <h1>Votre recherche d’emploi commence ici.</h1>
                    <p>Surveillez vos candidatures, gérez votre profil et découvrez les offres qui correspondent à votre parcours.</p>
                    <div class="hero-actions">
                        <a href="{{ route('job-offer.index') }}" class="btn btn-primary">Voir les offres</a>
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Mon profil</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats">
            <div class="stat-card">
                <div class="muted">Offres actives</div>
                <div class="stat-number">{{ \App\Models\JobOffer::where('is_active', true)->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Candidatures</div>
                <div class="stat-number">{{ $user->applications()->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Favoris</div>
                <div class="stat-number">{{ $user->favorites()->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Notifications</div>
                <div class="stat-number">{{ $user->notifications()->where('is_read', false)->count() }}</div>
            </div>
        </div>

        <div class="grid grid-2" style="grid-template-columns: 1.35fr 1fr; gap:24px;">
            <section class="card">
                <h2 class="section-title" style="font-size:1.5rem;">Offres récentes</h2>
                <div class="list">
                    @forelse ($recentJobs as $job)
                        <div class="list-item">
                            <div style="display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap;">
                                <strong>{{ $job->title }}</strong>
                                <span class="badge">{{ $job->employment_type }}</span>
                            </div>
                            <div class="muted" style="margin-top:8px;">{{ $job->company }} · {{ $job->location }}</div>
                            <div style="margin-top:10px;">
                                <a href="{{ route('job-offer.show', $job) }}" class="btn btn-primary" style="padding:0.6rem 0.9rem;">Voir</a>
                            </div>
                        </div>
                    @empty
                        <p class="muted">Aucune offre pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="card">
                <h2 class="section-title" style="font-size:1.5rem;">Mes candidatures</h2>
                <div class="list">
                    @forelse ($applications as $application)
                        <div class="list-item">
                            <strong>{{ $application->jobOffer?->title ?? 'Offre' }}</strong>
                            <div class="muted" style="margin-top:8px;">Statut : {{ $application->status }}</div>
                        </div>
                    @empty
                        <p class="muted">Aucune candidature pour le moment.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="card">
            <h2 class="section-title" style="font-size:1.5rem;">Favoris récents</h2>
            <div class="list">
                @forelse ($favorites as $favorite)
                    <div class="list-item">
                        <strong>{{ $favorite->jobOffer?->title ?? 'Offre' }}</strong>
                        <div class="muted" style="margin-top:8px;">{{ $favorite->jobOffer?->company ?? '' }}</div>
                    </div>
                @empty
                    <p class="muted">Vous n’avez pas encore ajouté d’offre en favori.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
