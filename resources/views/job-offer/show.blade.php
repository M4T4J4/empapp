@extends('layouts.app')

@section('title', $jobOffer->title)

@section('content')
    <div style="display:grid; gap:22px;">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap;">
                <div>
                    <span class="badge">{{ strtoupper($jobOffer->employment_type) }}</span>
                    <h1 style="font-size:2.3rem; letter-spacing:-0.05em; margin:16px 0 8px;">{{ $jobOffer->title }}</h1>
                    <div class="muted" style="font-weight:700; font-size:1.05rem;">{{ $jobOffer->company }} · {{ $jobOffer->location }}</div>
                </div>
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    @auth
                        <form method="POST" action="{{ route('favorite.store', $jobOffer) }}">
                            @csrf
                            <button type="submit" class="btn btn-secondary">{{ $isFavorite ? 'Déjà favori' : 'Ajouter aux favoris' }}</button>
                        </form>
                    @endauth
                    @auth
                        <form method="POST" action="{{ route('application.store', $jobOffer) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary" {{ $hasApplied ? 'disabled' : '' }}>
                                {{ $hasApplied ? 'Déjà postulée' : 'Postuler' }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Connectez-vous pour postuler</a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="grid grid-3" style="grid-template-columns: 2fr 1fr;">
            <section class="card">
                <h2 class="section-title" style="font-size:1.4rem;">Description du poste</h2>
                <p class="muted" style="line-height:1.8; margin:0;">{{ $jobOffer->description }}</p>

                <div style="margin-top:24px;">
                    <h3 style="margin:0 0 10px;">Compétences requises</h3>
                    <div class="tag-row">
                        @foreach (json_decode($jobOffer->required_skills ?? '[]', true) as $skill)
                            <span class="tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>

                @if ($jobOffer->benefits)
                    <div style="margin-top:24px;">
                        <h3 style="margin:0 0 10px;">Avantages</h3>
                        <div class="tag-row">
                            @foreach (json_decode($jobOffer->benefits ?? '[]', true) as $benefit)
                                <span class="tag">{{ $benefit }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>

            <aside class="card">
                <h2 class="section-title" style="font-size:1.35rem;">Informations</h2>
                <div class="list">
                    <div class="list-item"><strong>Expérience :</strong><br> {{ $jobOffer->required_experience ?? 'Non spécifiée' }}</div>
                    <div class="list-item"><strong>Niveau d’études :</strong><br> {{ $jobOffer->education_level ?? 'Non spécifié' }}</div>
                    <div class="list-item"><strong>Mode de travail :</strong><br> {{ $jobOffer->work_mode ? str_replace('_', ' ', $jobOffer->work_mode) : 'Non spécifié' }}</div>
                    <div class="list-item"><strong>Domaine :</strong><br> {{ $jobOffer->domain ?? 'Non spécifié' }}</div>
                    <div class="list-item"><strong>Région / ville :</strong><br> {{ $jobOffer->region ?? 'Non spécifiée' }} · {{ $jobOffer->city ?? 'Non spécifiée' }}</div>
                    <div class="list-item"><strong>Salaire :</strong><br> {{ $jobOffer->salary_min ? $jobOffer->salary_min . '€' : 'Selon profil' }} - {{ $jobOffer->salary_max ? $jobOffer->salary_max . '€' : '' }}</div>
                    <div class="list-item"><strong>Date limite :</strong><br> {{ $jobOffer->deadline ? $jobOffer->deadline->format('d/m/Y') : 'Non définie' }}</div>
                </div>
            </aside>
        </div>
    </div>
@endsection
