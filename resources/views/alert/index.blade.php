@extends('layouts.app')

@section('title', 'Mes alertes')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Alertes emploi</p>
            <h1>Gérez vos alertes personnalisées.</h1>
            <p>Créez des filtres pour recevoir les offres qui correspondent à votre recherche, votre localisation et votre niveau de salaire.</p>
        </section>

        <div class="grid" style="grid-template-columns: 1.05fr 1.35fr; gap:24px;">
            <section class="card">
                <h2 class="section-title" style="font-size:1.5rem;">Créer une alerte</h2>

                <form method="POST" action="{{ route('alert.store') }}" class="form-grid">
                    @csrf

                    <div>
                        <label for="keywords">Mots-clés</label>
                        <input id="keywords" name="keywords" type="text" value="{{ old('keywords') }}" placeholder="ex. Laravel, Product, Data">
                    </div>

                    <div>
                        <label for="location">Ville / région</label>
                        <input id="location" name="location" type="text" value="{{ old('location') }}" placeholder="Paris, Lyon, Remote">
                    </div>

                    <div>
                        <label for="employment_type">Type de contrat</label>
                        <select id="employment_type" name="employment_type">
                            <option value="">Tous</option>
                            <option value="full_time" {{ old('employment_type') === 'full_time' ? 'selected' : '' }}>CDI / Temps plein</option>
                            <option value="part_time" {{ old('employment_type') === 'part_time' ? 'selected' : '' }}>Temps partiel</option>
                            <option value="cdd" {{ old('employment_type') === 'cdd' ? 'selected' : '' }}>CDD</option>
                            <option value="contract" {{ old('employment_type') === 'contract' ? 'selected' : '' }}>Contrat / Freelance</option>
                            <option value="temporary" {{ old('employment_type') === 'temporary' ? 'selected' : '' }}>Temporaire</option>
                            <option value="stage" {{ old('employment_type') === 'stage' ? 'selected' : '' }}>Stage</option>
                            <option value="internship" {{ old('employment_type') === 'internship' ? 'selected' : '' }}>Stage / Alternance</option>
                        </select>
                    </div>

                    <div class="grid" style="grid-template-columns: repeat(2, minmax(0, 1fr)); gap:16px;">
                        <div>
                            <label for="min_salary">Salaire min (FCFA)</label>
                            <input id="min_salary" name="min_salary" type="number" step="1000" min="0" value="{{ old('min_salary') }}" placeholder="300000">
                        </div>

                        <div>
                            <label for="max_salary">Salaire max (FCFA)</label>
                            <input id="max_salary" name="max_salary" type="number" step="1000" min="0" value="{{ old('max_salary') }}" placeholder="1200000">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Créer l’alerte</button>
                </form>
            </section>

            <section class="card">
                <h2 class="section-title" style="font-size:1.5rem;">Mes alertes</h2>
                <div class="list">
                    @forelse ($alerts as $alert)
                        <div class="list-item" style="margin-bottom: 14px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:10px;">
                                <strong>{{ $alert->location ?: 'Toute la France' }}</strong>
                                <span class="badge">{{ $alert->is_active ? 'Active' : 'Inactive' }}</span>
                            </div>

                            <div class="tag-row" style="margin-bottom:10px;">
                                @if ($alert->keywords)
                                    @foreach (is_array($alert->keywords) ? $alert->keywords : [$alert->keywords] as $keyword)
                                        <span class="tag">{{ $keyword }}</span>
                                    @endforeach
                                @endif
                                @if ($alert->employment_type)
                                    <span class="tag">{{ str_replace('_', ' ', $alert->employment_type) }}</span>
                                @endif
                                @if ($alert->min_salary || $alert->max_salary)
                                    <span class="tag">{{ $alert->min_salary ? number_format($alert->min_salary, 0, ',', ' ') : '0' }}€ - {{ $alert->max_salary ? number_format($alert->max_salary, 0, ',', ' ') : '∞' }}€</span>
                                @endif
                            </div>

                            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                                <form method="POST" action="{{ route('alert.update', $alert) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_active" value="{{ $alert->is_active ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-secondary" style="padding:0.7rem 1rem;">{{ $alert->is_active ? 'Désactiver' : 'Activer' }}</button>
                                </form>

                                <form method="POST" action="{{ route('alert.destroy', $alert) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding:0.7rem 1rem;">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="card"><p class="muted">Aucune alerte pour le moment.</p></div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
