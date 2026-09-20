@extends('layouts.app')

@section('title', 'Profil entreprise')

@section('content')
    <div class="card overflow-hidden p-0">
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-900 p-6 text-white md:p-8">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    @if ($user->company_logo)
                        <img src="{{ Storage::url($user->company_logo) }}" alt="Logo de {{ $user->company_name ?? $user->name }}" class="h-24 w-24 rounded-2xl border-4 border-white/20 object-cover shadow-lg shadow-slate-900/30">
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border-4 border-white/20 bg-gradient-to-br from-sky-400 to-blue-600 text-3xl font-black text-white shadow-lg shadow-slate-900/20">
                            {{ strtoupper(substr($user->company_name ?? $user->name ?? 'E', 0, 1)) }}
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Entreprise</p>
                        <h1 class="mt-2 text-3xl font-black tracking-tight md:text-4xl">{{ $user->company_name ?? $user->name }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6 p-6 md:p-8">
            <div class="flex flex-wrap gap-2">
                <span class="tag">{{ $user->company_location ?? 'Localisation inconnue' }}</span>
                <span class="tag">{{ $user->company_size ?? 'Taille non renseignée' }}</span>
            </div>

            <p class="text-base leading-7 text-slate-600">{{ $user->company_description ?? 'Aucune description disponible pour cette entreprise.' }}</p>

            @if ($user->company_website)
                <div>
                    <a href="{{ $user->company_website }}" class="btn btn-secondary" target="_blank" rel="noopener">Visiter le site web</a>
                </div>
            @endif
        </div>
    </div>
@endsection
