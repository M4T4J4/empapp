@extends('layouts.app')

@section('title', 'Mes offres')

@section('content')
    <div style="display:grid; gap:20px;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <h1 class="section-title" style="margin:0;">Mes offres d’emploi</h1>
            <a href="{{ route('recruiter.job.create') }}" class="btn btn-primary">Publier une offre</a>
        </div>

        <div class="list">
            @forelse ($offers as $job)
                <div class="list-item">
                    <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:center;">
                        <strong>{{ $job->title }}</strong>
                        <span class="badge">{{ $job->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="muted" style="margin-top:8px;">{{ $job->location }} · {{ $job->employment_type }}</div>
                    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="{{ route('recruiter.job.edit', $job) }}" class="btn btn-secondary" style="padding:0.7rem 1rem;">Modifier</a>
                        <form method="POST" action="{{ route('recruiter.job.toggle', $job) }}">
                            @csrf
                            <button type="submit" class="btn btn-secondary" style="padding:0.7rem 1rem;">{{ $job->is_active ? 'Désactiver' : 'Activer' }}</button>
                        </form>
                        <form method="POST" action="{{ route('recruiter.job.destroy', $job) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:0.7rem 1rem;">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card">
                    <p class="muted">Aucune offre publiée.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
