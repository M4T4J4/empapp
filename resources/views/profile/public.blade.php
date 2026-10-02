@extends('layouts.app')

@section('title', 'Profil public')

@section('content')
    <div class="card" style="display:grid; gap:18px;">
        <h1>{{ $user->name }}</h1>
        <p class="muted">{{ $user->headline ?? 'Profil public' }}</p>
        <div class="tag-row">
            <span class="tag">{{ $user->location ?? 'Localisation non renseignée' }}</span>
            <span class="tag">{{ $user->employment_preference ?? 'Disponibilité non renseignée' }}</span>
        </div>
        <p>{{ $user->bio ?? 'Aucune bio renseignée.' }}</p>
    </div>
@endsection
