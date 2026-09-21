<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'EmpApp')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
        <header class="sticky top-0 z-50 border-b border-slate-800/20 bg-slate-950/95 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4 py-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 text-xl font-black tracking-tight text-white">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-sky-400 to-blue-600 text-sm font-black text-white shadow-lg shadow-blue-500/30">E</span>
                        <span>Emp</span><span class="text-sky-400">App</span>
                    </a>

                    <button
                        id="mobile-menu-button"
                        type="button"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-700 bg-slate-900 p-2 text-slate-200 transition hover:bg-slate-800 md:hidden"
                        aria-controls="main-navigation"
                        aria-expanded="false"
                        aria-label="Ouvrir le menu"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M4 7h16M4 12h16M4 17h16"/>
                        </svg>
                    </button>
                </div>

                <nav id="main-navigation" class="hidden flex-col gap-2 border-t border-slate-800/20 pb-3 pt-2 md:flex md:flex-row md:flex-wrap md:items-center md:justify-end md:gap-2 md:border-t-0 md:pb-0 md:pt-0">
                    @guest
                        <div class="flex flex-col gap-1.5 md:flex-row md:items-center md:gap-2">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V20h14V9.5"/></svg>
                                <span>Accueil</span>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/></svg>
                                <span>Connexion</span>
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-2.5 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-500 md:text-sm">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 8v6M17 11h6"/></svg>
                                <span>Inscription</span>
                            </a>
                        </div>
                    @endguest

                    @auth
                        @if (Auth::user()?->is_admin)
                            <div class="flex flex-col gap-1.5 md:flex-row md:items-center md:gap-2">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-4H3v4Zm10-10h8V3h-8v8Z"/></svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 8v6M17 11h6"/></svg>
                                    <span>Utilisateurs</span>
                                </a>
                                <a href="{{ route('admin.offers') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z"/><path d="M8 5v14"/><path d="M16 5v14"/></svg>
                                    <span>Offres</span>
                                </a>
                                <a href="{{ route('admin.notifications') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5"/><path d="M10 20a2 2 0 0 0 4 0"/></svg>
                                    <span>Notifications</span>
                                </a>
                            </div>
                        @elseif (Auth::user()?->is_recruiter)
                            <div class="flex flex-col gap-1.5 md:flex-row md:items-center md:gap-2">
                                <a href="{{ route('recruiter.dashboard') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13h8V3H3v10Zm10 8h8V11h-8v10ZM3 21h8v-4H3v4Zm10-10h8V3h-8v8Z"/></svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('recruiter.jobs') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z"/><path d="M8 5v14"/><path d="M16 5v14"/></svg>
                                    <span>Offres</span>
                                </a>
                                <a href="{{ route('recruiter.applications') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 3h8l4 4v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M14 3v5h5"/><path d="M8 13h8M8 17h8"/></svg>
                                    <span>Candidatures</span>
                                </a>
                                <a href="{{ route('message.index') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8M8 13h6"/></svg>
                                    <span>Messages</span>
                                </a>
                                <a href="{{ route('recruiter.profile') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 1 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                                    <span>Profil</span>
                                </a>
                            </div>
                        @else
                            <div class="flex flex-col gap-1.5 md:flex-row md:items-center md:gap-2">
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 13.5 12 4l8 9.5"/><path d="M6 11.5V20h12v-8.5"/></svg>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('job-offer.index') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9A2.5 2.5 0 0 1 17.5 19h-11A2.5 2.5 0 0 1 4 16.5v-9Z"/><path d="M8 5v14"/><path d="M16 5v14"/></svg>
                                    <span>Offres</span>
                                </a>
                                <a href="{{ route('application.index') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 3h8l4 4v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M14 3v5h5"/><path d="M8 13h8M8 17h8"/></svg>
                                    <span>Candidatures</span>
                                </a>
                                <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 1 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                                    <span>Profil</span>
                                </a>
                                <a href="{{ route('message.index') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8M8 13h6"/></svg>
                                    <span>Messages</span>
                                </a>
                                <a href="{{ route('favorite.index') }}" class="inline-flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-xs font-medium text-slate-200 transition hover:bg-slate-800 hover:text-white md:text-sm">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 21-1.45-1.32C5.4 15.36 2 12.28 2 8.5A4.5 4.5 0 0 1 6.5 4c1.74 0 3.41.81 4.5 2.09A6.22 6.22 0 0 1 15.5 4 4.5 4.5 0 0 1 20 8.5c0 3.78-3.4 6.86-8.55 11.18L12 21Z"/></svg>
                                    <span>Favoris</span>
                                </a>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-2.5 py-1.5 text-xs font-semibold text-white transition hover:bg-slate-700 md:text-sm">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        @if (session('success') || session('error'))
            <div class="toast-container" aria-live="polite" aria-atomic="true">
                @if (session('success'))
                    <div class="toast toast-success" role="status">
                        <div class="toast-title">Succès</div>
                        <div class="toast-message">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="toast toast-error" role="alert">
                        <div class="toast-title">Erreur</div>
                        <div class="toast-message">{{ session('error') }}</div>
                    </div>
                @endif
            </div>
        @endif

        <footer class="border-t border-slate-200 bg-white/80 py-8 text-center text-sm text-slate-500">
            © {{ date('Y') }} EmpApp — Plateforme de recherche d’emploi
        </footer>
    </body>
</html>
