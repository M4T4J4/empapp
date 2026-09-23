@extends('layouts.app')

@section('title', 'Publier une offre')

@section('content')
    <div class="form-card">
        <h1 class="section-title" style="margin-bottom:8px;">Publier une offre</h1>
        <form method="POST" action="{{ route('recruiter.job.store') }}" class="form-grid">
            @csrf

            <div>
                <label for="company">Entreprise</label>
                <input id="company" type="text" name="company" value="{{ old('company', Auth::user()->company_name ?? Auth::user()->name) }}" required>
            </div>

            <div>
                <label for="title">Intitulé du poste</label>
                <input id="title" type="text" name="title" value="{{ old('title') }}" required>
            </div>

            <div>
                <label for="location">Localisation</label>
                <input id="location" type="text" name="location" value="{{ old('location') }}" required>
            </div>

            <div>
                <label for="city">Ville</label>
                <input id="city" type="text" name="city" value="{{ old('city') }}">
            </div>

            <div>
                <label for="region">Région</label>
                <select id="region" name="region">
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
                <label for="domain">Domaine</label>
                <input id="domain" type="text" name="domain" value="{{ old('domain') }}" placeholder="IT, Marketing, Finance">
            </div>

            <div>
                <label for="employment_type">Type de contrat</label>
                <select id="employment_type" name="employment_type">
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
                <label for="work_mode">Mode de travail</label>
                <select id="work_mode" name="work_mode">
                    <option value="remote">Télétravail</option>
                    <option value="hybrid">Hybride</option>
                    <option value="on_site">Présentiel</option>
                </select>
            </div>

            <div>
                <label for="salary_min">Salaire minimum</label>
                <input id="salary_min" type="number" step="0.01" name="salary_min" value="{{ old('salary_min') }}">
            </div>

            <div>
                <label for="salary_max">Salaire maximum</label>
                <input id="salary_max" type="number" step="0.01" name="salary_max" value="{{ old('salary_max') }}">
            </div>

            <div>
                <label for="required_experience">Expérience requise</label>
                <input id="required_experience" type="text" name="required_experience" value="{{ old('required_experience') }}" placeholder="3+ ans, Senior, Junior">
            </div>

            <div>
                <label for="education_level">Niveau d’études</label>
                <select id="education_level" name="education_level">
                    <option value="">Non spécifié</option>
                    <option value="Bachelor">Bachelor</option>
                    <option value="Master">Master</option>
                    <option value="Diplôme">Diplôme</option>
                </select>
            </div>

            <div>
                <label for="deadline">Date limite</label>
                <input id="deadline" type="date" name="deadline" value="{{ old('deadline') }}">
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="required_skills">Compétences (séparées par des virgules)</label>
                <input id="required_skills" type="text" name="required_skills" value="{{ old('required_skills') }}">
            </div>

            <div>
                <label for="benefits">Avantages (séparés par des virgules)</label>
                <input id="benefits" type="text" name="benefits" value="{{ old('benefits') }}">
            </div>

            <div>
                <label for="is_active">Offre active</label>
                <select id="is_active" name="is_active">
                    <option value="1" selected>Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Publier</button>
        </form>
    </div>
@endsection
