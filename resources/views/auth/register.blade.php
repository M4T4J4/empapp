@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="auth-shell">
        <div class="form-card">
            <h1 class="section-title" style="margin-bottom:8px;">Créer mon compte</h1>
            <p class="muted" style="margin-top:0; margin-bottom:24px;">Rejoignez notre plateforme emploi.</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="form-grid">
                @csrf

                <div>
                    <label for="name">Nom complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div>
                    <label for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <div>
                    <label>Type de compte</label>
                    <div style="display:flex; gap:16px; margin-top:8px;">
                        <label style="display:flex; align-items:center; gap:8px;">
                            <input type="radio" name="is_recruiter" value="0" checked>
                            <span>Candidat</span>
                        </label>
                        <label style="display:flex; align-items:center; gap:8px;">
                            <input type="radio" name="is_recruiter" value="1">
                            <span>Recruteur</span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Créer mon compte</button>
            </form>

            <p style="margin-top:18px; color:var(--muted); text-align:center;">
                Déjà inscrit ? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:700;">Me connecter</a>
            </p>
        </div>
    </div>
@endsection
