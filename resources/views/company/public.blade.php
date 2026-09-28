@extends('layouts.app')

@section('title', 'Profil entreprise')

@section('content')
    <div class="card" style="display:grid; gap:18px;">
        @if ($user->company_logo)
            <img src="{{ Storage::url($user->company_logo) }}" alt="Logo de {{ $user->company_name ?? $user->name }}" style="max-width:220px; max-height:140px; object-fit:contain;">
        @endif
        <h1>{{ $user->company_name ?? $user->name }}</h1>
        <p class="muted">{{ $user->company_description ?? 'Aucune description disponible.' }}</p>
        <div class="tag-row">
            <span class="tag">{{ $user->company_location ?? 'Localisation inconnue' }}</span>
            <span class="tag">{{ $user->company_size ?? 'Taille non renseignée' }}</span>
        </div>
        <div>
            <a href="{{ $user->company_website ?? '#' }}" class="btn btn-secondary" target="_blank" rel="noopener">Site web</a>
            @auth
                @if (Auth::id() === $user->id && Auth::user()->is_recruiter)
                    <a href="{{ route('recruiter.profile') }}" class="btn btn-primary">Modifier le profil</a>
                @elseif (! Auth::user()->is_recruiter && ! Auth::user()->is_admin && $user->is_recruiter)
                    <a href="{{ route('message.show', $user) }}" class="btn btn-primary">Contacter l’entreprise</a>
                @endif
            @endauth
        </div>
    </div>
@endsection
