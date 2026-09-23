@extends('layouts.app')

@section('title', 'Candidatures')

@section('content')
    <div style="display:grid; gap:20px;">
        <div class="card">
            <h1 class="section-title" style="margin:0 0 16px;">Candidatures reçues</h1>
            <form method="GET" action="{{ route('recruiter.applications') }}" style="display:grid; gap:12px; grid-template-columns: 1.4fr 1fr 120px; align-items:end;">
                <div>
                    <label for="search">Recherche</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou poste">
                </div>
                <div>
                    <label for="status">Statut</label>
                    <select id="status" name="status">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="viewed" {{ request('status') === 'viewed' ? 'selected' : '' }}>Vu</option>
                        <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Acceptée</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Refusée</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="height:52px;">Filtrer</button>
            </form>
        </div>

        <div class="list">
            @forelse ($applications as $application)
                <div class="list-item">
                    <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; align-items:center;">
                        <strong>{{ $application->user?->name ?? 'Candidat' }}</strong>
                        <span class="badge">{{ $application->status }}</span>
                    </div>
                    <div class="muted" style="margin-top:8px;">{{ $application->jobOffer?->title ?? 'Offre' }} · {{ $application->jobOffer?->company }}</div>
                    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                        <form method="POST" action="{{ route('recruiter.application.status', $application) }}">
                            @csrf
                            @method('PUT')
                            <select name="status" onchange="this.form.submit()" style="max-width:180px;">
                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="viewed" {{ $application->status === 'viewed' ? 'selected' : '' }}>Vu</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>Acceptée</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>Refusée</option>
                            </select>
                        </form>
                        @if ($application->resume)
                            <a href="{{ route('resume.download', $application->resume) }}" class="btn btn-secondary" style="padding:0.7rem 1rem;">Télécharger CV</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card">
                    <p class="muted">Aucune candidature n’a été reçue.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
