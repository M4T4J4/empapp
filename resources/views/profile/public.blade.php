@extends('layouts.app')

@section('title', 'Profil public')

@section('content')
    <div class="card" style="display:grid; gap:18px;">
        @if ($user->profile_photo)
            <img src="{{ Storage::url($user->profile_photo) }}" alt="Photo de profil de {{ $user->name }}" style="width:140px; height:140px; border-radius:50%; object-fit:cover;">
        @endif
        <h1>{{ $user->name }}</h1>
        <p class="muted">{{ $user->headline ?? 'Profil public' }}</p>
        <div class="tag-row">
            <span class="tag">{{ $user->location ?? 'Localisation non renseignée' }}</span>
            <span class="tag">{{ $user->employment_preference ?? 'Disponibilité non renseignée' }}</span>
        </div>
        <p>{{ $user->bio ?? 'Aucune bio renseignée.' }}</p>
        @auth
            @if (Auth::user()->is_recruiter && ! Auth::user()->is_admin && ! $user->is_recruiter)
                <a href="{{ route('message.show', $user) }}" class="btn btn-primary">Contacter le candidat</a>
            @endif
        @endauth
    </div>
@endsection
