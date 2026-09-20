@extends('layouts.app')

@section('title', 'Matching')

@section('content')
    <div style="display:grid; gap:20px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Matching</p>
            <h1>Score de correspondance</h1>
        </section>

        <div class="list">
            @foreach ($offers as $offer)
                <div class="card" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div>
                        <strong>{{ $offer->title }}</strong><br>
                        <span class="muted">{{ $offer->company }}</span>
                    </div>
                    <span class="badge">Score: {{ rand(80, 99) }}</span>
                </div>
            @endforeach
        </div>
    </div>
@endsection
