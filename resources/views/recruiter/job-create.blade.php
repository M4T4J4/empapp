@extends('layouts.app')

@section('title', 'Publier une offre')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-8 text-white shadow-lg shadow-slate-200/60">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Offres</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight">Publier une offre</h1>
            <p class="mt-3 max-w-2xl text-slate-200">Rédigez une annonce claire, attractive et facile à comprendre pour les candidats.</p>
        </section>

        <div class="card mx-auto max-w-5xl">
            <form method="POST" action="{{ route('recruiter.job.store') }}" class="grid gap-5 md:grid-cols-2">
                @csrf

                <div>
                    <label for="company" class="mb-2 block text-sm font-semibold text-slate-700">Entreprise</label>
                    <input id="company" type="text" name="company" value="{{ old('company', Auth::user()->company_name ?? Auth::user()->name) }}" class="input-field" required>
                </div>

                <div>
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Intitulé du poste</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" class="input-field" required>
                </div>

                <div>
                    <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">Localisation</label>
                    <input id="location" type="text" name="location" value="{{ old('location') }}" class="input-field" required>
                </div>

                <div>
                    <label for="city" class="mb-2 block text-sm font-semibold text-slate-700">Ville</label>
                    <input id="city" type="text" name="city" value="{{ old('city') }}" class="input-field">
                </div>

                <div>
                    <label for="region" class="mb-2 block text-sm font-semibold text-slate-700">Région</label>
                    <select id="region" name="region" class="input-field">
                        <option value="">Sélectionnez</option>
                        <option value="Centre" {{ old('region') === 'Centre' ? 'selected' : '' }}>Centre</option>
                        <option value="Littoral" {{ old('region') === 'Littoral' ? 'selected' : '' }}>Littoral</option>
                        <option value="Nord" {{ old('region') === 'Nord' ? 'selected' : '' }}>Nord</option>
                        <option value="Sud" {{ old('region') === 'Sud' ? 'selected' : '' }}>Sud</option>
                        <option value="Ouest" {{ old('region') === 'Ouest' ? 'selected' : '' }}>Ouest</option>
                        <option value="Adamaoua" {{ old('region') === 'Adamaoua' ? 'selected' : '' }}>Adamaoua</option>
                        <option value="Est" {{ old('region') === 'Est' ? 'selected' : '' }}>Est</option>
                        <option value="Extreme-Nord" {{ old('region') === 'Extreme-Nord' ? 'selected' : '' }}>Extrême-Nord</option>
                        <option value="Nord-Ouest" {{ old('region') === 'Nord-Ouest' ? 'selected' : '' }}>Nord-Ouest</option>
                        <option value="Sud-Ouest" {{ old('region') === 'Sud-Ouest' ? 'selected' : '' }}>Sud-Ouest</option>
                    </select>
                </div>

                <div>
                    <label for="domain" class="mb-2 block text-sm font-semibold text-slate-700">Domaine</label>
                    <input id="domain" type="text" name="domain" value="{{ old('domain') }}" class="input-field" placeholder="IT, Marketing, Finance">
                </div>

                <div>
                    <label for="employment_type" class="mb-2 block text-sm font-semibold text-slate-700">Type de contrat</label>
                    <select id="employment_type" name="employment_type" class="input-field">
                        <option value="full_time">Temps plein / CDI</option>
                        <option value="part_time">Temps partiel</option>
                        <option value="cdd">CDD</option>
                        <option value="contract">Contrat / Freelance</option>
                        <option value="temporary">Temporaire</option>
                        <option value="stage">Stage</option>
                        <option value="internship">Stage / Alternance</option>
                    </select>
                </div>

                <div>
                    <label for="work_mode" class="mb-2 block text-sm font-semibold text-slate-700">Mode de travail</label>
                    <select id="work_mode" name="work_mode" class="input-field">
                        <option value="remote">Télétravail</option>
                        <option value="hybrid">Hybride</option>
                        <option value="on_site">Présentiel</option>
                    </select>
                </div>

                <div>
                    <label for="salary_min" class="mb-2 block text-sm font-semibold text-slate-700">Salaire minimum</label>
                    <input id="salary_min" type="number" step="0.01" name="salary_min" value="{{ old('salary_min') }}" class="input-field">
                </div>

                <div>
                    <label for="salary_max" class="mb-2 block text-sm font-semibold text-slate-700">Salaire maximum</label>
                    <input id="salary_max" type="number" step="0.01" name="salary_max" value="{{ old('salary_max') }}" class="input-field">
                </div>

                <div>
                    <label for="required_experience" class="mb-2 block text-sm font-semibold text-slate-700">Expérience requise</label>
                    <input id="required_experience" type="text" name="required_experience" value="{{ old('required_experience') }}" class="input-field" placeholder="3+ ans, Senior, Junior">
                </div>

                <div>
                    <label for="education_level" class="mb-2 block text-sm font-semibold text-slate-700">Niveau d’études</label>
                    <select id="education_level" name="education_level" class="input-field">
                        <option value="">Non spécifié</option>
                        <option value="Bachelor">Bachelor</option>
                        <option value="Master">Master</option>
                        <option value="Diplôme">Diplôme</option>
                    </select>
                </div>

                <div>
                    <label for="deadline" class="mb-2 block text-sm font-semibold text-slate-700">Date limite</label>
                    <input id="deadline" type="date" name="deadline" value="{{ old('deadline') }}" class="input-field">
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                    <textarea id="description" name="description" rows="6" class="input-field" required>{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="required_skills" class="mb-2 block text-sm font-semibold text-slate-700">Compétences</label>
                    <input id="required_skills" type="text" name="required_skills" value="{{ old('required_skills') }}" class="input-field" placeholder="Ex : Laravel, Gestion de projet">
                </div>

                <div>
                    <label for="benefits" class="mb-2 block text-sm font-semibold text-slate-700">Avantages</label>
                    <input id="benefits" type="text" name="benefits" value="{{ old('benefits') }}" class="input-field" placeholder="Ex : voiture, télétravail">
                </div>

                <div>
                    <label for="is_active" class="mb-2 block text-sm font-semibold text-slate-700">Offre active</label>
                    <select id="is_active" name="is_active" class="input-field">
                        <option value="1" selected>Oui</option>
                        <option value="0">Non</option>
                    </select>
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="btn btn-primary">Publier</button>
                </div>
            </form>
        </div>
    </div>
@endsection
