@extends('layouts.app')

@section('title', 'Mes offres')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-6 text-white shadow-lg shadow-slate-200/60 md:p-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Recrutement</p>
                    <h1 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">Mes offres d’emploi</h1>
                </div>
                <a href="{{ route('recruiter.job.create') }}" class="btn btn-primary">Publier une offre</a>
            </div>
        </section>

        <div class="grid gap-5">
            @forelse ($offers as $job)
                <article class="card flex flex-col gap-5">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-black text-slate-900">{{ $job->title }}</h2>
                            <div class="mt-2 text-sm text-slate-500">{{ $job->location }} · {{ $job->employment_type }} · {{ $job->company }}</div>
                        </div>
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.08em] {{ $job->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-700' }}">
                            {{ $job->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <p class="text-sm leading-6 text-slate-600">
                        {{ Str::limit($job->description, 180) }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('recruiter.job.edit', $job) }}" class="btn btn-secondary">Modifier</a>
                        <form method="POST" action="{{ route('recruiter.job.toggle', $job) }}">
                            @csrf
                            <button type="submit" class="btn btn-secondary">{{ $job->is_active ? 'Désactiver' : 'Activer' }}</button>
                        </form>
                        <form method="POST" action="{{ route('recruiter.job.destroy', $job) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="card">
                    <p class="text-slate-600">Aucune offre publiée pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
