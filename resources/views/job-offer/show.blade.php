@extends('layouts.app')

@section('title', $jobOffer->title)

@section('content')

<div class="container py-5">

```
{{-- Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- ========================================================= --}}
    {{-- CONTENU PRINCIPAL --}}
    {{-- ========================================================= --}}
    <div class="col-lg-8">

        {{-- En-tête de l'offre --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start gap-3">

                    <div>
                        <h1 class="h2 fw-bold mb-3">
                            {{ $jobOffer->title }}
                        </h1>

                        @if($jobOffer->company)
                            <div class="mb-2">
                                <i class="bi bi-building me-2"></i>
                                <strong>{{ $jobOffer->company }}</strong>
                            </div>
                        @endif

                        @if($jobOffer->location)
                            <div class="text-muted mb-2">
                                <i class="bi bi-geo-alt me-2"></i>
                                {{ $jobOffer->location }}
                            </div>
                        @endif

                        @if($jobOffer->posted_at)
                            <div class="text-muted small">
                                <i class="bi bi-calendar3 me-2"></i>
                                Publiée le
                                {{ $jobOffer->posted_at->format('d/m/Y') }}
                            </div>
                        @endif
                    </div>

                    {{-- Favori --}}
                    @auth
                        @if(!$hasApplied)
                            <form method="POST"
                                  action="{{ route('favorites.toggle', $jobOffer) }}">
                                @csrf

                                <button type="submit"
                                        class="btn btn-outline-warning"
                                        title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                                    <i class="bi {{ $isFavorite ? 'bi-star-fill' : 'bi-star' }}"></i>
                                </button>
                            </form>
                        @endif
                    @endauth

                </div>

                {{-- Informations principales --}}
                <div class="row g-3 mt-4">

                    @if($jobOffer->employment_type)
                        <div class="col-md-6">
                            <div class="bg-light rounded p-3">
                                <div class="text-muted small mb-1">
                                    Type de contrat
                                </div>
                                <strong>
                                    @switch($jobOffer->employment_type)
                                        @case('full_time')
                                            Temps plein
                                            @break

                                        @case('part_time')
                                            Temps partiel
                                            @break

                                        @case('contract')
                                            Contrat
                                            @break

                                        @case('temporary')
                                            Temporaire
                                            @break

                                        @case('internship')
                                            Stage
                                            @break

                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $jobOffer->employment_type)) }}
                                    @endswitch
                                </strong>
                            </div>
                        </div>
                    @endif

                    @if($jobOffer->work_mode)
                        <div class="col-md-6">
                            <div class="bg-light rounded p-3">
                                <div class="text-muted small mb-1">
                                    Mode de travail
                                </div>
                                <strong>
                                    @switch($jobOffer->work_mode)
                                        @case('remote')
                                            Télétravail
                                            @break

                                        @case('hybrid')
                                            Hybride
                                            @break

                                        @case('on_site')
                                            Sur site
                                            @break

                                        @default
                                            {{ ucfirst(str_replace('_', ' ', $jobOffer->work_mode)) }}
                                    @endswitch
                                </strong>
                            </div>
                        </div>
                    @endif

                    @if($jobOffer->domain)
                        <div class="col-md-6">
                            <div class="bg-light rounded p-3">
                                <div class="text-muted small mb-1">
                                    Domaine
                                </div>
                                <strong>
                                    {{ $jobOffer->domain }}
                                </strong>
                            </div>
                        </div>
                    @endif

                    @if($jobOffer->required_experience)
                        <div class="col-md-6">
                            <div class="bg-light rounded p-3">
                                <div class="text-muted small mb-1">
                                    Expérience requise
                                </div>
                                <strong>
                                    {{ $jobOffer->required_experience }}
                                </strong>
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- DESCRIPTION --}}
        {{-- ========================================================= --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <h2 class="h4 fw-bold mb-3">
                    Description du poste
                </h2>

                <div class="text-muted" style="white-space: pre-line;">
                    {{ $jobOffer->description }}
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- PROFIL / FORMATION --}}
        {{-- ========================================================= --}}
        @if($jobOffer->education_level || $jobOffer->required_experience)

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <h2 class="h4 fw-bold mb-3">
                        Profil recherché
                    </h2>

                    @if($jobOffer->education_level)
                        <div class="mb-3">
                            <strong>
                                <i class="bi bi-mortarboard me-2"></i>
                                Niveau d'études
                            </strong>

                            <div class="text-muted mt-1">
                                {{ $jobOffer->education_level }}
                            </div>
                        </div>
                    @endif

                    @if($jobOffer->required_experience)
                        <div>
                            <strong>
                                <i class="bi bi-briefcase me-2"></i>
                                Expérience
                            </strong>

                            <div class="text-muted mt-1">
                                {{ $jobOffer->required_experience }}
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- COMPÉTENCES --}}
        {{-- ========================================================= --}}
        @php
            $skills = $jobOffer->required_skills ?? [];

            if (!is_array($skills)) {
                $skills = json_decode($skills, true) ?? [];
            }
        @endphp

        @if(count($skills) > 0)

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <h2 class="h4 fw-bold mb-3">
                        Compétences requises
                    </h2>

                    <div class="d-flex flex-wrap gap-2">

                        @foreach($skills as $skill)

                            @if(is_array($skill))
                                @foreach($skill as $item)
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                        {{ $item }}
                                    </span>
                                @endforeach
                            @else
                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    {{ $skill }}
                                </span>
                            @endif

                        @endforeach

                    </div>

                </div>
            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- AVANTAGES --}}
        {{-- ========================================================= --}}
        @php
            $benefits = $jobOffer->benefits ?? [];

            if (!is_array($benefits)) {
                $benefits = json_decode($benefits, true) ?? [];
            }
        @endphp

        @if(count($benefits) > 0)

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <h2 class="h4 fw-bold mb-3">
                        Avantages
                    </h2>

                    <ul class="list-unstyled mb-0">

                        @foreach($benefits as $benefit)

                            @if(is_array($benefit))
                                @foreach($benefit as $item)
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {{ $item }}
                                    </li>
                                @endforeach
                            @else
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    {{ $benefit }}
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>
            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- BOUTON DE CANDIDATURE --}}
        {{-- ========================================================= --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 text-center">

                @auth

                    @if($hasApplied)

                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Vous avez déjà postulé à cette offre.
                        </div>

                    @else

                        <h2 class="h4 fw-bold mb-3">
                            Cette offre vous intéresse ?
                        </h2>

                        <p class="text-muted mb-4">
                            Envoyez votre candidature dès maintenant.
                        </p>

                        <a href="{{ route('applications.create', $jobOffer) }}"
                           class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-send me-2"></i>
                            Postuler maintenant
                        </a>

                    @endif

                @else

                    <h2 class="h4 fw-bold mb-3">
                        Cette offre vous intéresse ?
                    </h2>

                    <p class="text-muted mb-4">
                        Connectez-vous pour pouvoir postuler à cette offre.
                    </p>

                    <a href="{{ route('login') }}"
                       class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Se connecter
                    </a>

                @endauth

            </div>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}
    <div class="col-lg-4">

        {{-- Salaire --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <h2 class="h5 fw-bold mb-3">
                    Informations
                </h2>

                @if($jobOffer->salary_min !== null || $jobOffer->salary_max !== null)

                    <div class="mb-3">
                        <div class="text-muted small">
                            Salaire
                        </div>

                        <strong class="fs-5">
                            @if($jobOffer->salary_min !== null)
                                {{ number_format($jobOffer->salary_min, 0, ',', ' ') }}
                                FCFA
                            @endif

                            @if($jobOffer->salary_min !== null && $jobOffer->salary_max !== null)
                                -
                            @endif

                            @if($jobOffer->salary_max !== null)
                                {{ number_format($jobOffer->salary_max, 0, ',', ' ') }}
                                FCFA
                            @endif
                        </strong>
                    </div>

                @endif


                @if($jobOffer->city)
                    <div class="mb-3">
                        <div class="text-muted small">
                            Ville
                        </div>

                        <strong>
                            {{ $jobOffer->city }}
                        </strong>
                    </div>
                @endif


                @if($jobOffer->region)
                    <div class="mb-3">
                        <div class="text-muted small">
                            Région
                        </div>

                        <strong>
                            {{ $jobOffer->region }}
                        </strong>
                    </div>
                @endif


                @if($jobOffer->deadline)

                    <div>
                        <div class="text-muted small">
                            Date limite
                        </div>

                        <strong>
                            {{ $jobOffer->deadline->format('d/m/Y') }}
                        </strong>
                    </div>

                @endif

            </div>
        </div>


        {{-- Entreprise --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">

                <h2 class="h5 fw-bold mb-3">
                    Entreprise
                </h2>

                <h3 class="h6 fw-bold">
                    {{ $jobOffer->company }}
                </h3>

                @if($jobOffer->location)
                    <p class="text-muted mb-0">
                        <i class="bi bi-geo-alt me-2"></i>
                        {{ $jobOffer->location }}
                    </p>
                @endif

            </div>
        </div>


        {{-- Partage --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                <h2 class="h5 fw-bold mb-3">
                    Partager cette offre
                </h2>

                <div class="d-grid gap-2">

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                       target="_blank"
                       rel="noopener"
                       class="btn btn-outline-primary">
                        <i class="bi bi-facebook me-2"></i>
                        Facebook
                    </a>

                    <a href="https://wa.me/?text={{ urlencode($jobOffer->title . ' - ' . request()->fullUrl()) }}"
                       target="_blank"
                       rel="noopener"
                       class="btn btn-outline-success">
                        <i class="bi bi-whatsapp me-2"></i>
                        WhatsApp
                    </a>

                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="copyJobOfferLink()">
                        <i class="bi bi-link-45deg me-2"></i>
                        Copier le lien
                    </button>

                </div>

            </div>
        </div>

    </div>

</div>
```

</div>

{{-- Copier le lien --}}

<script>
    function copyJobOfferLink() {
        navigator.clipboard.writeText(window.location.href)
            .then(function () {
                alert('Lien copié avec succès.');
            })
            .catch(function () {
                alert('Impossible de copier le lien.');
            });
    }
</script>

@endsection
