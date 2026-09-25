<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'EmpApp')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <header class="topbar">
            <div class="container topbar-inner">
                <a href="{{ route('home') }}" class="brand">Emp<span>App</span></a>
                <nav class="nav">
                    <a href="{{ route('home') }}">Accueil</a>
                    <a href="{{ route('job-offer.index') }}">Offres</a>
                    @auth
                        @if (Auth::user()?->is_admin)
                            <a href="{{ route('admin.dashboard') }}">Admin</a>
                            <a href="{{ route('admin.users') }}">Utilisateurs</a>
                            <a href="{{ route('admin.offers') }}">Offres</a>
                            <a href="{{ route('admin.notifications') }}">Notifications</a>
                        @elseif (Auth::user()?->is_recruiter)
                            <a href="{{ route('recruiter.dashboard') }}">Dashboard</a>
                            <a href="{{ route('recruiter.jobs') }}">Offres</a>
                            <a href="{{ route('recruiter.applications') }}">Candidatures</a>
                            <a href="{{ route('recruiter.profile') }}">Entreprise</a>
                        @else
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            <a href="{{ route('profile.show') }}">Profil</a>
                            <a href="{{ route('favorite.index') }}">Favoris</a>
                            <a href="{{ route('application.index') }}">Candidatures</a>
                            <a href="{{ route('notification.index') }}">Notifications</a>
                            <a href="{{ route('message.index') }}">Messages</a>
                            <a href="{{ route('alert.index') }}">Alertes</a>
                            <a href="{{ route('candidate.recommendations') }}">Recommandations</a>
                            <a href="{{ route('premium.index') }}">Premium</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display:inline; margin-left:4px;">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding:0.6rem 1rem; border-radius: 12px;">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Connexion</a>
                        <a href="{{ route('register') }}">Inscription</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="container page">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>

        <footer class="container footer">
            © {{ date('Y') }} EmpApp — Plateforme de recherche d’emploi
        </footer>
    </body>
</html>
