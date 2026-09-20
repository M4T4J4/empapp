@extends('layouts.app')

@section('title', 'Mes favoris')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Favoris</p>
            <h1>Mes offres favorites</h1>
            <p>Retrouvez rapidement les postes qui vous intéressent le plus.</p>
        </section>

        <div class="list">
            @forelse ($favorites as $favorite)
                @php $job = $favorite->jobOffer; @endphp
                <div class="card" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div>
                        <strong>{{ $job?->title ?? 'Offre' }}</strong>
                        <div class="muted" style="margin-top:6px;">{{ $job?->company ?? '' }} · {{ $job?->location ?? '' }}</div>
                    </div>
                    <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                        <a href="{{ route('job-offer.show', $job) }}" class="btn btn-primary" style="padding:0.7rem 1rem;">Voir</a>
                        <form method="POST" action="{{ route('favorite.destroy', $favorite) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:0.7rem 1rem;">Retirer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card"><p class="muted">Aucune offre favorite pour le moment.</p></div>
            @endforelse
        </div>
    </div>
@endsection
