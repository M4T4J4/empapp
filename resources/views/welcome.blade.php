@extends('layouts.app')

@section('title', 'EmpApp | Accueil')

@section('content')
    <section class="hero">
        <p class="muted" style="margin:0 0 12px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Plateforme candidat • Premium</p>
        <h1>La recherche d’emploi devient plus fluide.</h1>
        <p>Construisez un profil premium, suivez vos candidatures, découvrez des offres ciblées et gérez votre parcours professionnel comme une expérience mobile-first moderne.</p>

        <div class="hero-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Mon dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Créer mon compte</a>
                <a href="{{ route('login') }}" class="btn btn-secondary">Se connecter</a>
            @endauth
            <a href="{{ route('job-offer.index') }}" class="btn btn-secondary">Voir les offres</a>
        </div>
    </section>

    <div class="grid grid-3" style="margin-top:32px;">
        <div class="card">
            <div class="badge" style="margin-bottom:12px;">Profile</div>
            <h3 style="margin-top:0;">Profil professionnel</h3>
            <p class="muted">Présentez votre parcours, vos disponibilités et vos expertises à des recruteurs qualifiés.</p>
        </div>
        <div class="card">
            <div class="badge" style="margin-bottom:12px;">Apply</div>
            <h3 style="margin-top:0;">Candidatures</h3>
            <p class="muted">Suivez vos dossiers, gérez votre historique et postulez en quelques gestes seulement.</p>
        </div>
        <div class="card">
            <div class="badge" style="margin-bottom:12px;">Alerts</div>
            <h3 style="margin-top:0;">Alertes emploi</h3>
            <p class="muted">Recevez des opportunités personnalisées selon vos compétences, vos préférences et votre ville.</p>
        </div>
    </div>

    <section style="margin-top:40px;">
        <h2 class="section-title">Pourquoi les candidats utilisent EmpApp</h2>
        <div class="grid grid-4">
            <div class="stat-card">
                <div class="muted">Profils complets</div>
                <div class="stat-number">100%</div>
                <div class="muted">Suivi de compétences et parcours</div>
            </div>
            <div class="stat-card">
                <div class="muted">Offres ciblées</div>
                <div class="stat-number">24/7</div>
                <div class="muted">Découverte de postes adaptés</div>
            </div>
            <div class="stat-card">
                <div class="muted">Candidatures</div>
                <div class="stat-number">Fast</div>
                <div class="muted">Processus plus rapide et clair</div>
            </div>
            <div class="stat-card">
                <div class="muted">Alertes</div>
                <div class="stat-number">Live</div>
                <div class="muted">Notifications personnalisées</div>
            </div>
        </div>
    </section>
@endsection
