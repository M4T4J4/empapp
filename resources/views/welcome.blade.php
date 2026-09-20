@extends('layouts.app')

@section('title', 'EmpApp | Accueil')

@section('content')
    <section class="overflow-hidden rounded-[28px] border border-slate-200 bg-gradient-to-br from-sky-50 via-white to-indigo-50 p-8 shadow-sm sm:p-10 lg:p-14">
        <div class="grid items-center gap-10 lg:grid-cols-[1.2fr_0.8fr]">
            <div>
                <p class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-blue-700">Plateforme candidat • Premium</p>
                <h1 class="max-w-xl text-4xl font-black tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">La recherche d’emploi devient plus fluide.</h1>
                <p class="mt-5 max-w-xl text-lg text-slate-600">Construisez un profil premium, suivez vos candidatures, découvrez des offres ciblées et gérez votre parcours professionnel comme une expérience moderne.</p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Mon dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Créer mon compte</a>
                        <a href="{{ route('login') }}" class="btn btn-secondary">Se connecter</a>
                    @endauth
                    <a href="{{ route('job-offer.index') }}" class="btn btn-secondary">Voir les offres</a>
                </div>
            </div>

            <div class="rounded-3xl border border-sky-100 bg-white/80 p-6 shadow-lg shadow-sky-100/60">
                <div class="grid gap-4">
                    <div class="rounded-2xl bg-slate-900 p-5 text-white">
                        <p class="text-xs uppercase tracking-[0.2em] text-sky-300">Profil</p>
                        <div class="mt-3 flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">92%</div>
                                <div class="text-sm text-slate-300">Complétion du profil</div>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-sky-500/20 text-xl">★</div>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-sm text-slate-500">Offres</div>
                            <div class="mt-2 text-3xl font-black text-slate-900">1.2k</div>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="text-sm text-slate-500">Candidatures</div>
                            <div class="mt-2 text-3xl font-black text-slate-900">240</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mt-10 grid gap-6 md:grid-cols-3">
        <div class="card">
            <span class="badge mb-4">Profil</span>
            <h3 class="mb-2 text-xl font-bold text-slate-900">Profil professionnel</h3>
            <p class="text-slate-600">Présentez votre parcours, vos disponibilités et vos expertises à des recruteurs qualifiés.</p>
        </div>
        <div class="card">
            <span class="badge mb-4">Apply</span>
            <h3 class="mb-2 text-xl font-bold text-slate-900">Candidatures</h3>
            <p class="text-slate-600">Suivez vos dossiers, gérez votre historique et postulez en quelques gestes seulement.</p>
        </div>
        <div class="card">
            <span class="badge mb-4">Alerts</span>
            <h3 class="mb-2 text-xl font-bold text-slate-900">Alertes emploi</h3>
            <p class="text-slate-600">Recevez des opportunités personnalisées selon vos compétences, vos préférences et votre ville.</p>
        </div>
    </div>

    <section class="mt-12">
        <h2 class="mb-6 text-3xl font-black tracking-tight text-slate-900">Pourquoi les candidats utilisent EmpApp</h2>
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm font-medium text-slate-500">Profils complets</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">100%</div>
                <div class="mt-2 text-sm text-slate-600">Suivi de compétences et parcours</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm font-medium text-slate-500">Offres ciblées</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">24/7</div>
                <div class="mt-2 text-sm text-slate-600">Découverte de postes adaptés</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm font-medium text-slate-500">Candidatures</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">Fast</div>
                <div class="mt-2 text-sm text-slate-600">Processus plus rapide et clair</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm font-medium text-slate-500">Alertes</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">Live</div>
                <div class="mt-2 text-sm text-slate-600">Notifications personnalisées</div>
            </div>
        </div>
    </section>
@endsection
