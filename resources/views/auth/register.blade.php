@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="auth-shell auth-register-shell">
        <div class="register-layout">
            <aside class="register-intro">
                <a href="{{ route('home') }}" class="register-kicker">Emp<span>App</span></a>
                <div>
                    <p class="eyebrow">Votre prochaine étape</p>
                    <h1>Un profil qui ouvre les bonnes portes.</h1>
                    <p class="register-intro-copy">Créez votre espace pour suivre votre parcours, découvrir des opportunités et avancer avec plus de clarté.</p>
                </div>
                <div class="register-points" aria-label="Avantages de l'inscription">
                    <div><span class="register-point-mark">01</span><span>Un profil professionnel complet</span></div>
                    <div><span class="register-point-mark">02</span><span>Des offres adaptées à votre projet</span></div>
                    <div><span class="register-point-mark">03</span><span>Un suivi simple de vos candidatures</span></div>
                </div>
            </aside>

            <div class="form-card register-card">
                <div class="register-heading">
                    <div>
                        <p class="eyebrow">Nouveau membre</p>
                        <h2 class="section-title">Créer mon compte</h2>
                    </div>
                    <span class="register-step">01 / 01</span>
                </div>
                <p class="muted register-subtitle">Quelques informations pour commencer.</p>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="form-grid register-form">
                @csrf

                <div>
                    <label for="name">Nom complet</label>
                    <input class="input-field" id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Ex. Marie Ngono" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input class="input-field" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="vous@exemple.com" required>
                </div>

                <div class="password-field">
                    <label for="password">Mot de passe</label>
                    <div class="password-input-wrap">
                        <input class="input-field" id="password" type="password" name="password" autocomplete="new-password" aria-describedby="password-hint" required>
                        <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Afficher le mot de passe">Afficher</button>
                    </div>
                    <p class="field-hint" id="password-hint">Utilisez au moins 8 caractères avec des lettres et des chiffres.</p>
                </div>

                <div class="password-field">
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <div class="password-input-wrap">
                        <input class="input-field" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required>
                        <button class="password-toggle" type="button" data-password-toggle="password_confirmation" aria-label="Afficher la confirmation du mot de passe">Afficher</button>
                    </div>
                </div>

                <fieldset class="role-field">
                    <legend>Je souhaite rejoindre EmpApp comme</legend>
                    <div class="role-options">
                        <label class="role-option">
                            <input type="radio" name="is_recruiter" value="0" checked>
                            <span><strong>Candidat</strong><small>Je cherche une opportunité</small></span>
                        </label>
                        <label class="role-option">
                            <input type="radio" name="is_recruiter" value="1">
                            <span><strong>Recruteur</strong><small>Je recrute des talents</small></span>
                        </label>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary register-submit">Créer mon compte <span aria-hidden="true">→</span></button>
            </form>

            <p class="register-login-link">
                Déjà inscrit ? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:700;">Me connecter</a>
            </p>
            </div>
        </div>
    </div>
@endsection
