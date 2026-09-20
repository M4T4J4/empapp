@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Administration</p>
            <h1>Tableau de bord</h1>
            <p>Supervision de la plateforme, des utilisateurs, des offres et des contenus.</p>
        </section>

        <div class="stats">
            <div class="stat-card">
                <div class="muted">Utilisateurs</div>
                <div class="stat-number">{{ $stats['users'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Candidats</div>
                <div class="stat-number">{{ $stats['candidates'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Entreprises</div>
                <div class="stat-number">{{ $stats['companies'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Offres</div>
                <div class="stat-number">{{ $stats['offers'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Premium</div>
                <div class="stat-number">{{ $stats['premium_users'] }}</div>
            </div>
            <div class="stat-card">
                <div class="muted">Bloqués</div>
                <div class="stat-number">{{ $stats['blocked_users'] }}</div>
            </div>
        </div>

        <div class="grid grid-2" style="grid-template-columns: 1.2fr 0.8fr;">
            <section class="card">
                <h2 class="section-title">Utilisateurs récents</h2>
                <div class="list">
                    @foreach ($recentUsers as $user)
                        <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                            <div>
                                <strong>{{ $user->name }}</strong><br>
                                <span class="muted">{{ $user->email }}</span>
                            </div>
                            <span class="badge">{{ $user->is_recruiter ? 'Entreprise' : 'Candidat' }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="card">
                <h2 class="section-title">Notifications</h2>
                <div class="list">
                    @foreach ($notifications as $notification)
                        <div class="list-item">
                            <strong>{{ $notification->title }}</strong>
                            <div class="muted" style="margin-top:6px;">{{ $notification->message }}</div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <section class="card">
            <h2 class="section-title">Offres récentes</h2>
            <div class="list">
                @foreach ($recentOffers as $offer)
                    <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div>
                            <strong>{{ $offer->title }}</strong><br>
                            <span class="muted">{{ $offer->user->company_name ?? $offer->user->name }}</span>
                        </div>
                        <span class="badge">{{ $offer->is_active ? 'Validée' : 'En attente' }}</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
