@extends('layouts.app')

@section('title', 'Profil entreprise')

@section('content')
    <div class="card" style="display:grid; gap:18px;">
        <h1>{{ $user->company_name ?? $user->name }}</h1>
        <p class="muted">{{ $user->company_description ?? 'Aucune description disponible.' }}</p>
        <div class="tag-row">
            <span class="tag">{{ $user->company_location ?? 'Localisation inconnue' }}</span>
            <span class="tag">{{ $user->company_size ?? 'Taille non renseignée' }}</span>
        </div>
        <div>
            <a href="{{ $user->company_website ?? '#' }}" class="btn btn-secondary" target="_blank" rel="noopener">Site web</a>
        </div>
    </div>
@endsection
