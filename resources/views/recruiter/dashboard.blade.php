@extends('layouts.app')

@section('title', 'Dashboard recruteur')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <div class="space-y-6">
        <section class="overflow-hidden rounded-[28px] border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-8 text-white shadow-lg shadow-slate-200/60">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Espace recruteur</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight">Bienvenue {{ $user->company_name ?? $user->name }}</h1>
            <p class="mt-3 max-w-2xl text-slate-200">Gérez vos offres, suivez les candidatures et consultez les profils les plus pertinents.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('recruiter.jobs') }}" class="btn btn-primary">Mes offres</a>
                <a href="{{ route('recruiter.profile') }}" class="btn btn-secondary">Profil entreprise</a>
                <a href="{{ route('recruiter.applications') }}" class="btn btn-secondary">Candidatures</a>
            </div>
        </section>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Offres publiées</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $offers->total() }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Candidatures</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $applications->count() }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">À traiter</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $applications->where('status', 'pending')->count() }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-500">Mises à jour</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $applications->where('status', '!=', 'pending')->count() }}</div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.25fr_0.75fr]">
            <section class="card">
                <h2 class="mb-5 text-2xl font-black tracking-tight text-slate-900">Offres récentes</h2>
                <div class="space-y-4">
                    @forelse ($offers as $job)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <div class="flex items-center justify-between gap-3">
                                <strong class="text-lg text-slate-900">{{ $job->title }}</strong>
                                <span class="badge">{{ $job->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>
                            <div class="mt-2 text-sm text-slate-500">{{ $job->location }} · {{ $job->employment_type }}</div>
                        </div>
                    @empty
                        <p class="text-slate-600">Aucune offre publiée pour le moment.</p>
                    @endforelse
                </div>
            </section>

            <section class="card">
                <h2 class="mb-5 text-2xl font-black tracking-tight text-slate-900">Nouvelles candidatures</h2>
                <div class="space-y-4">
                    @forelse ($applications as $application)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <strong class="text-slate-900">{{ $application->user?->name ?? 'Candidat' }}</strong>
                            <div class="mt-2 text-sm text-slate-500">{{ $application->jobOffer?->title ?? 'Offre' }} · {{ $application->status }}</div>
                        </div>
                    @empty
                        <p class="text-slate-600">Aucune candidature reçue.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
