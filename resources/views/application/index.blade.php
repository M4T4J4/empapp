@extends('layouts.app')

@section('title', 'Mes candidatures')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Suivi des candidatures</p>
            <h1>Mes candidatures</h1>
            <p>Gardez un œil sur vos dossiers en cours et les étapes avancées.</p>
        </section>

        <div class="list">
            @forelse ($applications as $application)
                @php $job = $application->jobOffer; @endphp
                <div class="card" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div>
                        <strong>{{ $job?->title ?? 'Offre' }}</strong>
                        <div class="muted" style="margin-top:6px;">{{ $job?->company ?? '' }} · Statut : {{ $application->status }}</div>
                    </div>
                    <div style="display:flex; gap:10px; flex-wrap:wrap;">
                        <a href="{{ route('job-offer.show', $job) }}" class="btn btn-primary" style="padding:0.7rem 1rem;">Voir offre</a>
                        <form method="POST" action="{{ route('application.cancel', $application) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="padding:0.7rem 1rem;">Retirer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card"><p class="muted">Aucune candidature enregistrée.</p></div>
            @endforelse
        </div>
    </div>
@endsection
