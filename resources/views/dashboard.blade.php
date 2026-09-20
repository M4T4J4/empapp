@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $user = Auth::user();
        $recentJobs = \App\Models\JobOffer::query()->where('is_active', true)->latest('posted_at')->limit(4)->get();
        $applications = $user->applications()->with('jobOffer')->latest('applied_at')->limit(3)->get();
        $favorites = $user->favorites()->with('jobOffer')->latest()->limit(3)->get();
    @endphp

    <div class="space-y-6">
        <section class="overflow-hidden rounded-[28px] border border-slate-200 bg-gradient-to-br from-sky-50 via-white to-indigo-50 p-8 shadow-sm">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">Bienvenue, {{ $user->name }}</p>
                    <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-900">Votre recherche d’emploi commence ici.</h1>
                    <p class="mt-3 max-w-2xl text-slate-600">Surveillez vos candidatures, gérez votre profil et découvrez les offres qui correspondent à votre parcours.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('job-offer.index') }}" class="btn btn-primary">Voir les offres</a>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Mon profil</a>
                </div>
            </div>
        </section>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Offres actives</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ \App\Models\JobOffer::where('is_active', true)->count() }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Candidatures</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $user->applications()->count() }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Favoris</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $user->favorites()->count() }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Notifications</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $user->notifications()->where('is_read', false)->count() }}</div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
            <section class="card">
                <h2 class="mb-5 text-2xl font-black tracking-tight text-slate-900">Offres récentes</h2>
                <div class="space-y-4">
                    @forelse ($recentJobs as $job)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <strong class="text-lg text-slate-900">{{ $job->title }}</strong>
                                <span class="badge">{{ $job->employment_type }}</span>
                            </div>
                            <div class="mt-2 text-sm text-slate-500">{{ $job->company }} · {{ $job->location }}</div>
                            <div class="mt-4">
                                <a href="{{ route('job-offer.show', $job) }}" class="btn btn-primary">Voir</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-600">Aucune offre pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="card">
                <h2 class="mb-5 text-2xl font-black tracking-tight text-slate-900">Mes candidatures</h2>
                <div class="space-y-4">
                    @forelse ($applications as $application)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <strong class="text-slate-900">{{ $application->jobOffer?->title ?? 'Offre' }}</strong>
                            <div class="mt-2 text-sm text-slate-500">Statut : {{ $application->status }}</div>
                        </div>
                    @empty
                        <p class="text-slate-600">Aucune candidature pour le moment.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <section class="card">
            <h2 class="mb-5 text-2xl font-black tracking-tight text-slate-900">Favoris récents</h2>
            <div class="space-y-4">
                @forelse ($favorites as $favorite)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <strong class="text-slate-900">{{ $favorite->jobOffer?->title ?? 'Offre' }}</strong>
                        <div class="mt-2 text-sm text-slate-500">{{ $favorite->jobOffer?->company ?? '' }}</div>
                    </div>
                @empty
                    <p class="text-slate-600">Vous n’avez pas encore ajouté d’offre en favori.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
