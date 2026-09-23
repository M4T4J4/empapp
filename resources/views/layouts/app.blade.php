<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'EmpApp')</title>
        <style>
            :root {
                --bg: #f4f7fb;
                --card: #ffffff;
                --card-alt: #eef5ff;
                --primary: #1d4ed8;
                --primary-dark: #163ea8;
                --text: #152033;
                --muted: #5e6b85;
                --border: #dfe7f4;
                --success: #1f9d61;
                --warning: #f39c12;
                --danger: #dc2626;
                --shadow: 0 10px 30px rgba(19, 35, 73, 0.08);
            }

            * { box-sizing: border-box; }
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                background: var(--bg);
                color: var(--text);
            }
            a { color: inherit; text-decoration: none; }
            .container { width: min(1200px, calc(100% - 32px)); margin: 0 auto; }
            .topbar {
                background: #0f172a; color: #fff; position: sticky; top: 0; z-index: 50; box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
            }
            .topbar-inner {
                height: 74px; display: flex; align-items: center; justify-content: space-between; gap: 24px;
            }
            .brand {
                font-size: 1.5rem; font-weight: 800; letter-spacing: -0.04em;
            }
            .brand span { color: #60a5fa; }
            .nav {
                display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
            }
            .nav a {
                color: rgba(255,255,255,0.82); font-weight: 600; font-size: 0.96rem;
            }
            .nav a:hover { color: #fff; }
            .btn {
                display: inline-flex; align-items: center; justify-content: center; gap: 8px;
                border: 1px solid transparent; border-radius: 12px; padding: 0.8rem 1.2rem;
                font-weight: 700; cursor: pointer; transition: all 0.2s ease;
            }
            .btn-primary { background: var(--primary); color: white; }
            .btn-primary:hover { background: var(--primary-dark); }
            .btn-secondary { background: #fff; color: var(--text); border-color: var(--border); }
            .btn-danger { background: var(--danger); color: white; }
            .page { padding: 32px 0 80px; }
            .hero {
                background: linear-gradient(135deg, #eff6ff, #f8fafc 60%, #ecfeff);
                border: 1px solid var(--border); border-radius: 26px; padding: 48px 32px;
                box-shadow: var(--shadow);
            }
            .hero h1 { font-size: clamp(2.2rem, 5vw, 4rem); margin: 0 0 16px; line-height: 1.05; letter-spacing: -0.06em; }
            .hero p { color: var(--muted); font-size: 1.08rem; max-width: 720px; }
            .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; margin-top: 26px; }
            .grid { display: grid; gap: 20px; }
            .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .card {
                background: var(--card); border: 1px solid var(--border); border-radius: 18px; padding: 22px; box-shadow: var(--shadow);
            }
            .stats { display: grid; gap: 18px; grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .stat-card { background: linear-gradient(180deg, #fff, #eff6ff); border-radius: 18px; padding: 22px; border: 1px solid var(--border); }
            .stat-number { font-size: 2rem; font-weight: 800; letter-spacing: -0.04em; margin: 8px 0; }
            .muted { color: var(--muted); }
            .section-title { font-size: 1.8rem; margin: 0 0 16px; letter-spacing: -0.04em; }
            .job-card {
                background: var(--card); border: 1px solid var(--border); border-radius: 20px; padding: 20px; display: flex; flex-direction: column; gap: 14px;
            }
            .job-card h3 { margin: 0; font-size: 1.3rem; }
            .badge {
                display: inline-flex; align-items: center; padding: 6px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; background: #e0ebff; color: var(--primary-dark);
            }
            .tag-row { display: flex; flex-wrap: wrap; gap: 8px; }
            .tag { background: #f3f6fb; border: 1px solid var(--border); color: var(--muted); border-radius: 999px; padding: 6px 10px; font-size: 0.78rem; font-weight: 700; }
            .form-card { max-width: 620px; margin: 24px auto; background: var(--card); border: 1px solid var(--border); border-radius: 24px; padding: 32px; box-shadow: var(--shadow); }
            .form-grid { display: grid; gap: 16px; }
            label { display: block; font-weight: 700; margin-bottom: 8px; }
            input, select, textarea {
                width: 100%; border: 1px solid var(--border); border-radius: 12px; background: #fff; padding: 0.9rem 1rem; font: inherit; color: var(--text);
            }
            textarea { resize: vertical; min-height: 120px; }
            .auth-shell { min-height: calc(100vh - 74px); display: grid; place-items: center; padding: 40px 0; }
            .alert { padding: 12px 16px; border-radius: 12px; border: 1px solid; margin-bottom: 18px; }
            .alert-success { background: rgba(31,157,97,0.12); border-color: rgba(31,157,97,0.4); color: #0f6d43; }
            .alert-error { background: rgba(220,38,38,0.08); border-color: rgba(220,38,38,0.22); color: #9d1b1b; }
            .profile-box { display: grid; grid-template-columns: 220px 1fr; gap: 28px; }
            .avatar {
                width: 180px; height: 180px; border-radius: 50%; background: linear-gradient(135deg, #dbeafe, #e2e8f0); display: grid; place-items: center; font-size: 3rem; font-weight: 800; color: var(--primary-dark); border: 6px solid #fff; box-shadow: var(--shadow);
            }
            .list { display: grid; gap: 14px; }
            .list-item { padding: 16px 18px; border: 1px solid var(--border); background: #fff; border-radius: 14px; }
            .footer { padding: 30px 0 60px; color: var(--muted); text-align: center; }
            @media (max-width: 900px) {
                .stats, .grid-3, .grid-4, .profile-box { grid-template-columns: 1fr 1fr; }
                .profile-box { grid-template-columns: 1fr; }
            }
            @media (max-width: 640px) {
                .stats, .grid-3, .grid-4 { grid-template-columns: 1fr; }
                .topbar-inner { height: auto; padding: 18px 0; flex-direction: column; align-items: flex-start; }
                .nav { width: 100%; }
                .hero { padding: 28px 18px; }
            }
        </style>
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
