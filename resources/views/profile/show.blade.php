@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <div style="display:grid; gap:24px;">
        <section class="card profile-box" style="padding:28px;">
            <div>
                @if ($user->profile_photo)
                    <img src="{{ Storage::url($user->profile_photo) }}" alt="Photo de profil" class="avatar" style="object-fit:cover; width:180px; height:180px; border-radius:50%;">
                @else
                    <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                @endif
            </div>
            <div>
                <p class="muted" style="margin:0 0 8px; font-weight:800; letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem; color:var(--primary-dark);">Profil candidat</p>
                <h1 style="margin:0 0 8px; font-size:2.4rem; letter-spacing:-0.06em;">{{ $user->name }}</h1>
                <div class="muted" style="font-size:1.06rem; font-weight:700;">{{ $user->headline ?? 'Headline non renseignée' }}</div>
                <p style="line-height:1.7; color:var(--muted); margin-top:14px;">{{ $user->bio ?? 'Ajoutez une courte présentation...' }}</p>
                <div class="tag-row" style="margin-top:14px;">
                    @if ($user->location)
                        <span class="tag">{{ $user->location }}</span>
                    @endif
                    @if ($user->employment_preference)
                        <span class="tag">{{ str_replace('_', ' ', $user->employment_preference) }}</span>
                    @endif
                </div>
                <div style="margin-top:18px;">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier le profil</a>
                </div>
            </div>
        </section>

        <section class="grid grid-3" style="grid-template-columns: 1fr 1fr;">
            <div class="card">
                <h2 class="section-title" style="font-size:1.4rem;">Compétences</h2>
                <div class="tag-row">
                    @forelse ($user->skills as $skill)
                        <span class="tag">{{ $skill->name }} ({{ $skill->pivot->proficiency_level }})</span>
                    @empty
                        <p class="muted">Aucune compétence ajoutée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="section-title" style="font-size:1.4rem;">Langues</h2>
                <div class="tag-row">
                    @forelse ($user->languages as $language)
                        <span class="tag">{{ $language->name }} · {{ $language->pivot->proficiency_level }}</span>
                    @empty
                        <p class="muted">Aucune langue ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid grid-3" style="grid-template-columns:1fr 1fr;">
            <div class="card">
                <h2 class="section-title" style="font-size:1.4rem;">Formations</h2>
                <div class="list">
                    @forelse ($user->educations as $education)
                        <div class="list-item">
                            <strong>{{ $education->degree }}</strong>
                            <div class="muted">{{ $education->school }}</div>
                            <div class="muted">{{ $education->start_date?->format('Y') }} - {{ $education->end_date?->format('Y') ?? 'Aujourd’hui' }}</div>
                        </div>
                    @empty
                        <p class="muted">Aucune formation enregistrée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="section-title" style="font-size:1.4rem;">Expériences</h2>
                <div class="list">
                    @forelse ($user->experiences as $experience)
                        <div class="list-item">
                            <strong>{{ $experience->title }}</strong>
                            <div class="muted">{{ $experience->company }}</div>
                            <div class="muted">{{ $experience->start_date?->format('Y') }} - {{ $experience->end_date?->format('Y') ?? 'Aujourd’hui' }}</div>
                        </div>
                    @empty
                        <p class="muted">Aucune expérience ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
