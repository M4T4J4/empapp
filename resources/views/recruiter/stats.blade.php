@extends('layouts.app')

@section('title', 'Statistiques recruteur')

@section('content')
    <div style="display:grid; gap:20px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Statistiques</p>
            <h1>Tableau de bord recruteur</h1>
        </section>

        <div class="stats">
            <div class="stat-card">
                <div class="muted">Offres</div>
                <div class="stat-number">{{ $stats['offers'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Candidatures</div>
                <div class="stat-number">{{ $stats['applications'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Candidats</div>
                <div class="stat-number">{{ $stats['candidates'] }}</div>
            </div>
        </div>
    </div>
@endsection
