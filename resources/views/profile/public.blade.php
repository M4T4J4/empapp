@extends('layouts.app')

@section('title', 'Profil public')

@section('content')
    <div class="card overflow-hidden p-0">
        <div class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-700 p-6 text-white md:p-8">
            <div class="flex flex-col gap-5 md:flex-row md:items-center">
                @if ($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" alt="Photo de {{ $user->name }}" class="h-24 w-24 rounded-full border-4 border-white/20 object-cover shadow-lg shadow-slate-900/20">
                @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-full border-4 border-white/20 bg-white/10 text-3xl font-black text-white shadow-lg shadow-slate-900/20">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-100">Candidat</p>
                    <h1 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">{{ $user->name }}</h1>
                </div>
            </div>
        </div>

        <div class="space-y-6 p-6 md:p-8">
            <p class="text-lg font-semibold text-slate-700">{{ $user->headline ?? 'Profil public' }}</p>

            <div class="flex flex-wrap gap-2">
                <span class="tag">{{ $user->location ?? 'Localisation non renseignée' }}</span>
                <span class="tag">{{ $user->employment_preference ?? 'Disponibilité non renseignée' }}</span>
            </div>

            <p class="text-base leading-7 text-slate-600">{{ $user->bio ?? 'Aucune bio renseignée.' }}</p>
        </div>
    </div>
@endsection
