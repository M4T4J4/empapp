@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="auth-shell auth-register-shell">
        <div class="register-layout">
            <aside class="register-intro">
                <a href="{{ route('home') }}" class="register-kicker">Emp<span>App</span></a>
                <div>
                    <p class="eyebrow">Ravi de vous revoir</p>
                    <h1>Retrouvez votre prochaine opportunité.</h1>
                    <p class="register-intro-copy">Reconnectez-vous pour suivre vos candidatures, consulter vos alertes et avancer dans votre projet professionnel.</p>
                </div>
                <div class="register-points" aria-label="Fonctionnalités de votre espace">
                    <div><span class="register-point-mark">01</span><span>Vos candidatures au même endroit</span></div>
                    <div><span class="register-point-mark">02</span><span>Des alertes selon vos objectifs</span></div>
                    <div><span class="register-point-mark">03</span><span>Un profil toujours prêt à évoluer</span></div>
                </div>
            </aside>

            <div class="form-card register-card">
                <div class="register-heading">
                    <div>
                        <p class="eyebrow">Espace membre</p>
                        <h1 class="section-title">Connexion</h1>
                    </div>
                    <span class="register-step">01 / 01</span>
                </div>
                <p class="muted register-subtitle">Accédez à votre espace personnel.</p>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="form-grid register-form login-form">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input class="input-field" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="vous@exemple.com" required>
                </div>

                <div class="password-field">
                    <label for="password">Mot de passe</label>
                    <div class="password-input-wrap">
                        <input class="input-field" id="password" type="password" name="password" autocomplete="current-password" required>
                        <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Afficher le mot de passe">Afficher</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary register-submit">Se connecter <span aria-hidden="true">→</span></button>
            </form>

            <p class="register-login-link">
                Pas encore inscrit ? <a href="{{ route('register') }}" style="color:var(--primary); font-weight:700;">Créer un compte</a>
            </p>
            </div>
        </div>
    </div>
@endsection
