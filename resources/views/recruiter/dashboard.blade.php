@extends('layouts.app')

@section('title', 'Dashboard recruteur')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <div style="display:grid; gap:24px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 12px; font-weight:700; color:var(--primary-dark);">Espace recruteur</p>
            <h1>Bienvenue {{ $user->company_name ?? $user->name }}</h1>
            <p>Gérez vos offres, suivez les candidatures et consultez les profils les plus pertinents.</p>
            <div class="hero-actions">
                <a href="{{ route('recruiter.jobs') }}" class="btn btn-primary">Mes offres</a>
                <a href="{{ route('recruiter.profile') }}" class="btn btn-secondary">Profil entreprise</a>
                <a href="{{ route('recruiter.applications') }}" class="btn btn-secondary">Candidatures</a>
            </div>
        </section>

        <div class="stats">
            <div class="stat-card">
                <div class="muted">Offres publiées</div>
                <div class="stat-number">{{ $offers->total() }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Candidatures</div>
                <div class="stat-number">{{ $applications->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Statut à traiter</div>
                <div class="stat-number">{{ $applications->where('status', 'pending')->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Mises à jour</div>
                <div class="stat-number">{{ $applications->where('status', '!=', 'pending')->count() }}</div>
            </div>
        </div>

        <div class="grid grid-2" style="grid-template-columns: 1.2fr 1fr; gap:24px;">
            <section class="card">
                <h2 class="section-title" style="font-size:1.5rem;">Offres récentes</h2>
                <div class="list">
                    @forelse ($offers as $job)
                        <div class="list-item">
                            <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:center;">
                                <strong>{{ $job->title }}</strong>
                                <span class="badge">{{ $job->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>
                            <div class="muted" style="margin-top:8px;">{{ $job->location }} · {{ $job->employment_type }}</div>
                        </div>
                    @empty
                        <p class="muted">Aucune offre publiée pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="card">
                <h2 class="section-title" style="font-size:1.5rem;">Nouvelles candidatures</h2>
                <div class="list">
                    @forelse ($applications as $application)
                        <div class="list-item">
                            <strong>{{ $application->user?->name ?? 'Candidat' }}</strong>
                            <div class="muted" style="margin-top:8px;">{{ $application->jobOffer?->title ?? 'Offre' }} · {{ $application->status }}</div>
                        </div>
                    @empty
                        <p class="muted">Aucune candidature reçue.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
