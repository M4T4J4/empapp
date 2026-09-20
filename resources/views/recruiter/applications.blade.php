@extends('layouts.app')

@section('title', 'Candidatures')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-6 text-white shadow-lg shadow-slate-200/60 md:p-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Candidatures</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">Candidatures reçues</h1>
        </section>

        <div class="card">
            <form method="GET" action="{{ route('recruiter.applications') }}" class="grid gap-4 md:grid-cols-[1.4fr_1fr_auto] md:items-end">
                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">Recherche</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou poste" class="input-field">
                </div>
                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Statut</label>
                    <select id="status" name="status" class="input-field">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="viewed" {{ request('status') === 'viewed' ? 'selected' : '' }}>Vu</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Acceptée</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Refusée</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse ($applications as $application)
                <div class="card">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <strong class="text-lg text-slate-900">{{ $application->user?->name ?? 'Candidat' }}</strong>
                            <div class="mt-1 text-sm text-slate-500">{{ $application->jobOffer?->title ?? 'Offre' }} · {{ $application->jobOffer?->company }}</div>
                        </div>
                        <span class="badge">{{ $application->status }}</span>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <form method="POST" action="{{ route('recruiter.application.status', $application) }}" class="flex flex-wrap items-center gap-2">
                            @csrf
                            @method('PUT')
                            <select name="status" class="input-field max-w-[180px]">
                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="viewed" {{ $application->status === 'viewed' ? 'selected' : '' }}>Vu</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Acceptée</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Refusée</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </form>
                        <a href="{{ route('message.show', $application->user) }}" class="btn btn-secondary">Message</a>
                        @if ($application->resume)
                            <a href="{{ route('resume.download', $application->resume) }}" class="btn btn-secondary">Télécharger CV</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card">
                    <p class="text-slate-600">Aucune candidature n’a été reçue.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
