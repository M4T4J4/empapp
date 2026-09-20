@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
    @php
        $user = Auth::user()->load(['skills', 'languages', 'educations', 'experiences']);
    @endphp

    <div class="space-y-8">
        <section class="card">
            <h1 class="mb-2 text-3xl font-black tracking-tight text-slate-900">Modifier mon profil</h1>
            <p class="text-slate-600">Mettez à jour vos informations professionnelles et complétez votre profil candidat.</p>
        </section>

        <section class="card">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nom complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="input-field">
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="input-field">
                </div>

                <div>
                    <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">Téléphone</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="input-field">
                </div>

                <div>
                    <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Localisation</label>
                    <input id="location" type="text" name="location" value="{{ old('location', $user->location) }}" class="input-field">
                </div>

                <div>
                    <label for="headline" class="mb-2 block text-sm font-semibold text-slate-700">Headline</label>
                    <input id="headline" type="text" name="headline" value="{{ old('headline', $user->headline) }}" class="input-field">
                </div>

                <div>
                    <label for="employment_preference" class="mb-2 block text-sm font-semibold text-slate-700">Préférence d’emploi</label>
                    <select id="employment_preference" name="employment_preference" class="input-field">
                        <option value="">Non précisée</option>
                        <option value="full_time" {{ old('employment_preference', $user->employment_preference) === 'full_time' ? 'selected' : '' }}>Temps plein / CDI</option>
                        <option value="part_time" {{ old('employment_preference', $user->employment_preference) === 'part_time' ? 'selected' : '' }}>Temps partiel</option>
                        <option value="cdd" {{ old('employment_preference', $user->employment_preference) === 'cdd' ? 'selected' : '' }}>CDD</option>
                        <option value="contract" {{ old('employment_preference', $user->employment_preference) === 'contract' ? 'selected' : '' }}>Contrat / Freelance</option>
                        <option value="temporary" {{ old('employment_preference', $user->employment_preference) === 'temporary' ? 'selected' : '' }}>Temporaire</option>
                        <option value="stage" {{ old('employment_preference', $user->employment_preference) === 'stage' ? 'selected' : '' }}>Stage</option>
                        <option value="internship" {{ old('employment_preference', $user->employment_preference) === 'internship' ? 'selected' : '' }}>Stage / Alternance</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="bio" class="mb-2 block text-sm font-semibold text-slate-700">Biographie</label>
                    <textarea id="bio" name="bio" rows="4" class="input-field">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label for="profile_photo" class="mb-2 block text-sm font-semibold text-slate-700">Photo de profil</label>
                    <input id="profile_photo" type="file" name="profile_photo" accept="image/*" class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </section>

        <section class="card">
            <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">CV</h2>

            <form method="POST" action="{{ route('resume.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid gap-3 md:grid-cols-[1fr_auto] md:items-end">
                    <div>
                        <label for="resume_title" class="mb-1 block text-sm font-medium text-slate-700">Titre</label>
                        <input id="resume_title" type="text" name="title" value="{{ old('title') }}" placeholder="Ex. CV Développeur Laravel" class="input-field" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>

                <div>
                    <label for="resume_file" class="mb-1 block text-sm font-medium text-slate-700">Fichier</label>
                    <input id="resume_file" type="file" name="file" accept=".pdf,.doc,.docx" class="input-field file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white" required>
                </div>

                <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700">
                    <input id="resume_default" type="checkbox" name="is_default" value="1" class="h-4 w-4 rounded text-blue-600 focus:ring-blue-500">
                    <label for="resume_default">Afficher comme CV principal</label>
                </div>
            </form>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Compétences</h2>

                <form method="POST" action="{{ route('skill.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="skill_name" class="mb-1 block text-sm font-medium text-slate-700">Nom</label>
                        <input id="skill_name" type="text" name="name" placeholder="Ex. Laravel" class="input-field" required>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label for="skill_level" class="mb-1 block text-sm font-medium text-slate-700">Niveau</label>
                            <select id="skill_level" name="proficiency_level" class="input-field" required>
                                <option value="beginner">Débutant</option>
                                <option value="intermediate" selected>Intermédiaire</option>
                                <option value="expert">Expert</option>
                            </select>
                        </div>
                        <div>
                            <label for="skill_years" class="mb-1 block text-sm font-medium text-slate-700">Années</label>
                            <input id="skill_years" type="number" min="0" name="years_experience" value="1" class="input-field">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>

                <div class="mt-5 flex flex-wrap gap-2">
                    @forelse ($user->skills as $skill)
                        <form method="POST" action="{{ route('skill.destroy', $skill->id) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tag cursor-pointer border border-slate-200 bg-slate-100 text-slate-700 hover:bg-slate-200">
                                {{ $skill->name }} ×
                            </button>
                        </form>
                    @empty
                        <p class="text-sm text-slate-500">Aucune compétence ajoutée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Formations</h2>

                <form method="POST" action="{{ route('education.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="school" class="mb-1 block text-sm font-medium text-slate-700">École</label>
                        <input id="school" type="text" name="school" class="input-field" required>
                    </div>
                    <div>
                        <label for="degree" class="mb-1 block text-sm font-medium text-slate-700">Diplôme</label>
                        <input id="degree" type="text" name="degree" class="input-field" required>
                    </div>
                    <div>
                        <label for="field_of_study" class="mb-1 block text-sm font-medium text-slate-700">Domaine</label>
                        <input id="field_of_study" type="text" name="field_of_study" class="input-field" required>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label for="start_date" class="mb-1 block text-sm font-medium text-slate-700">Début</label>
                            <input id="start_date" type="date" name="start_date" class="input-field" required>
                        </div>
                        <div>
                            <label for="end_date" class="mb-1 block text-sm font-medium text-slate-700">Fin</label>
                            <input id="end_date" type="date" name="end_date" class="input-field">
                        </div>
                    </div>
                    <div>
                        <label for="grade" class="mb-1 block text-sm font-medium text-slate-700">Mention</label>
                        <input id="grade" type="text" name="grade" class="input-field">
                    </div>
                    <div>
                        <label for="education_description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
                        <textarea id="education_description" name="description" rows="3" class="input-field"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>

                <div class="mt-5 space-y-3">
                    @forelse ($user->educations as $education)
                        <form method="POST" action="{{ route('education.destroy', $education->id) }}" class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            @csrf
                            @method('DELETE')
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <strong class="text-slate-900">{{ $education->degree }}</strong>
                                    <div class="text-sm text-slate-600">{{ $education->school }}</div>
                                </div>
                                <button type="submit" class="text-xs font-semibold text-red-600">Supprimer</button>
                            </div>
                        </form>
                    @empty
                        <p class="text-sm text-slate-500">Aucune formation ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Expériences</h2>

                <form method="POST" action="{{ route('experience.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="experience_title" class="mb-1 block text-sm font-medium text-slate-700">Titre</label>
                        <input id="experience_title" type="text" name="title" class="input-field" required>
                    </div>
                    <div>
                        <label for="experience_company" class="mb-1 block text-sm font-medium text-slate-700">Entreprise</label>
                        <input id="experience_company" type="text" name="company" class="input-field" required>
                    </div>
                    <div>
                        <label for="experience_type" class="mb-1 block text-sm font-medium text-slate-700">Type</label>
                        <select id="experience_type" name="employment_type" class="input-field" required>
                            <option value="full_time">Temps plein</option>
                            <option value="part_time">Temps partiel</option>
                            <option value="contract">Contrat</option>
                            <option value="temporary">Temporaire</option>
                            <option value="internship">Stage</option>
                        </select>
                    </div>
                    <div>
                        <label for="experience_location" class="mb-1 block text-sm font-medium text-slate-700">Localisation</label>
                        <input id="experience_location" type="text" name="location" class="input-field">
                    </div>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label for="experience_start" class="mb-1 block text-sm font-medium text-slate-700">Début</label>
                            <input id="experience_start" type="date" name="start_date" class="input-field" required>
                        </div>
                        <div>
                            <label for="experience_end" class="mb-1 block text-sm font-medium text-slate-700">Fin</label>
                            <input id="experience_end" type="date" name="end_date" class="input-field">
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input id="is_current" type="checkbox" name="is_current" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="is_current" class="text-sm font-medium text-slate-700">Poste actuel</label>
                    </div>
                    <div>
                        <label for="experience_description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
                        <textarea id="experience_description" name="description" rows="3" class="input-field"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>

                <div class="mt-5 space-y-3">
                    @forelse ($user->experiences as $experience)
                        <form method="POST" action="{{ route('experience.destroy', $experience->id) }}" class="rounded-2xl border border-slate-200 bg-slate-50 p-3">
                            @csrf
                            @method('DELETE')
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <strong class="text-slate-900">{{ $experience->title }}</strong>
                                    <div class="text-sm text-slate-600">{{ $experience->company }}</div>
                                </div>
                                <button type="submit" class="text-xs font-semibold text-red-600">Supprimer</button>
                            </div>
                        </form>
                    @empty
                        <p class="text-sm text-slate-500">Aucune expérience ajoutée.</p>
                    @endforelse
                </div>
            </div>

            <div class="card">
                <h2 class="mb-4 text-2xl font-black tracking-tight text-slate-900">Langues</h2>

                <form method="POST" action="{{ route('language.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="language_id" class="mb-1 block text-sm font-medium text-slate-700">Langue</label>
                        <select id="language_id" name="language_id" class="input-field" required>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="language_level" class="mb-1 block text-sm font-medium text-slate-700">Niveau</label>
                        <select id="language_level" name="proficiency_level" class="input-field" required>
                            <option value="elementary">A1 — Débutant</option>
                            <option value="limited_working">A2 — Élémentaire</option>
                            <option value="professional_working">B1 — Intermédiaire</option>
                            <option value="full_professional">B2 — Bon niveau</option>
                            <option value="native">C1 — Très bon niveau</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>

                <div class="mt-5 flex flex-wrap gap-2">
                    @forelse ($user->languages as $language)
                        <form method="POST" action="{{ route('language.destroy', $language->id) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tag cursor-pointer border border-slate-200 bg-slate-100 text-slate-700 hover:bg-slate-200">
                                {{ $language->name }} ×
                            </button>
                        </form>
                    @empty
                        <p class="text-sm text-slate-500">Aucune langue ajoutée.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
