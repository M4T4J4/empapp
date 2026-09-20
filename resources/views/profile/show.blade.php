@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <div class="space-y-6">
        <section class="card overflow-hidden p-0">
            <div class="grid gap-6 p-6 md:grid-cols-[220px_1fr] md:p-8">
                <div class="flex items-center justify-center">
                    @if ($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="Photo de profil" class="h-44 w-44 rounded-full object-cover ring-4 ring-sky-100 shadow-md">
                    @else
                        <div class="flex h-44 w-44 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-600 text-4xl font-black text-white shadow-lg shadow-sky-200">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">Profil candidat</p>
                    <h1 class="mt-2 text-4xl font-black tracking-tight text-slate-900">{{ $user->name }}</h1>
                    <div class="mt-3 text-lg font-semibold text-slate-600">{{ $user->headline ?? 'Headline non renseignée' }}</div>
                    <p class="mt-4 max-w-2xl text-slate-600">{{ $user->bio ?? 'Ajoutez une courte présentation...' }}</p>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @if ($user->location)
                            <span class="tag">{{ $user->location }}</span>
                        @endif
                        @if ($user->employment_preference)
                            <span class="tag">{{ str_replace('_', ' ', $user->employment_preference) }}</span>
                        @endif
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3 text-sm text-slate-600">
                        @if ($user->email)
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5">{{ $user->email }}</span>
                        @endif
                        @if ($user->phone)
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5">{{ $user->phone }}</span>
                        @endif
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier le profil</a>
                        <a href="{{ route('resume.index') }}" class="btn btn-secondary">Mon CV</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="mb-5 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">CV</p>
                </div>
                <a href="{{ route('resume.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Gérer mes CV</a>
            </div>

            <form method="POST" action="{{ route('resume.store') }}" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-[1.3fr_1fr_auto] md:items-end">
                @csrf

                <div>
                    <label for="resume_title" class="mb-2 block text-sm font-semibold text-slate-700">Titre du CV</label>
                    <input id="resume_title" type="text" name="title" value="{{ old('title') }}" placeholder="Ex. CV Développeur Laravel" class="input-field" required>
                </div>

                <div>
                    <label for="resume_file" class="mb-2 block text-sm font-semibold text-slate-700">Fichier</label>
                    <input id="resume_file" type="file" name="file" accept=".pdf,.doc,.docx" class="input-field file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white">
                </div>

                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm font-medium text-slate-700">
                    <input id="resume_default" type="checkbox" name="is_default" value="1" class="h-4 w-4 rounded text-blue-600 focus:ring-blue-500">
                    <label for="resume_default">CV principal</label>
                </div>

                <div class="md:col-span-3">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>

            <div class="mt-5 space-y-3">
                @forelse ($user->resumes as $resume)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <strong class="text-slate-900">{{ $resume->title }}</strong>
                                    @if ($resume->is_default)
                                        <span class="badge">Par défaut</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-sm text-slate-500">{{ $resume->file_path ? 'Fichier disponible' : 'Aucun fichier associé' }}</div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if ($resume->file_path)
                                    <a href="{{ route('resume.download', $resume) }}" class="btn btn-secondary">Télécharger</a>
                                @endif
                                <form method="POST" action="{{ route('resume.setDefault', $resume) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">Définir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-600">Aucun CV ajouté pour le moment.</p>
                @endforelse
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2">
            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Compétences</h2>
                <div class="flex flex-wrap gap-2">
                    @forelse ($user->skills as $skill)
                        <span class="tag">{{ $skill->name }} ({{ $skill->pivot->proficiency_level }})</span>
                    @empty
                        <p class="text-slate-600">Aucune compétence ajoutée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Langues</h2>
                <div class="flex flex-wrap gap-2">
                    @forelse ($user->languages as $language)
                        <span class="tag">{{ $language->name }} · {{ $language->pivot->proficiency_level }}</span>
                    @empty
                        <p class="text-slate-600">Aucune langue ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-2">
            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Formations</h2>
                <div class="space-y-4">
                    @forelse ($user->educations as $education)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <strong class="text-slate-900">{{ $education->degree }}</strong>
                            <div class="mt-1 text-sm text-slate-500">{{ $education->school }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $education->field_of_study ?? 'Domaine non précisé' }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $education->start_date?->format('Y') }} - {{ $education->end_date?->format('Y') ?? 'Aujourd’hui' }}</div>
                        </div>
                    @empty
                        <p class="text-slate-600">Aucune formation enregistrée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Expériences</h2>
                <div class="space-y-4">
                    @forelse ($user->experiences as $experience)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <strong class="text-slate-900">{{ $experience->title }}</strong>
                            <div class="mt-1 text-sm text-slate-500">{{ $experience->company }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $experience->location ?? 'Lieu non précisé' }}</div>
                            <div class="mt-1 text-sm text-slate-500">{{ $experience->start_date?->format('Y') }} - {{ $experience->end_date?->format('Y') ?? 'Aujourd’hui' }}</div>
                        </div>
                    @empty
                        <p class="text-slate-600">Aucune expérience ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
