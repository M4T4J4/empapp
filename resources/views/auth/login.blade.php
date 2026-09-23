@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="auth-shell">
        <div class="form-card">
            <h1 class="section-title" style="margin-bottom:8px;">Connexion</h1>
            <p class="muted" style="margin-top:0; margin-bottom:24px;">Accédez à votre espace candidat.</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="form-grid">
                @csrf

                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div>
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>

            <p style="margin-top:18px; color:var(--muted); text-align:center;">
                Pas encore inscrit ? <a href="{{ route('register') }}" style="color:var(--primary); font-weight:700;">Créer un compte</a>
            </p>
        </div>
    </div>
@endsection
