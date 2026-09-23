@extends('layouts.app')

@section('title', 'Modifier une offre')

@section('content')
    <div class="form-card">
        <h1 class="section-title" style="margin-bottom:8px;">Modifier une offre</h1>
        <form method="POST" action="{{ route('recruiter.job.update', $jobOffer) }}" class="form-grid">
            @csrf
            @method('PUT')

            <div>
                <label for="company">Entreprise</label>
                <input id="company" type="text" name="company" value="{{ old('company', $jobOffer->company) }}" required>
            </div>

            <div>
                <label for="title">Intitulé du poste</label>
                <input id="title" type="text" name="title" value="{{ old('title', $jobOffer->title) }}" required>
            </div>

            <div>
                <label for="location">Localisation</label>
                <input id="location" type="text" name="location" value="{{ old('location', $jobOffer->location) }}" required>
            </div>

            <div>
                <label for="city">Ville</label>
                <input id="city" type="text" name="city" value="{{ old('city', $jobOffer->city) }}">
            </div>

            <div>
                <label for="region">Région</label>
                <select id="region" name="region">
                    <option value="">Sélectionnez</option>
                    <option value="Centre" {{ old('region', $jobOffer->region) === 'Centre' ? 'selected' : '' }}>Centre</option>
                    <option value="Littoral" {{ old('region', $jobOffer->region) === 'Littoral' ? 'selected' : '' }}>Littoral</option>
                    <option value="Nord" {{ old('region', $jobOffer->region) === 'Nord' ? 'selected' : '' }}>Nord</option>
                    <option value="Sud" {{ old('region', $jobOffer->region) === 'Sud' ? 'selected' : '' }}>Sud</option>
                    <option value="Ouest" {{ old('region', $jobOffer->region) === 'Ouest' ? 'selected' : '' }}>Ouest</option>
                    <option value="Adamaoua" {{ old('region', $jobOffer->region) === 'Adamaoua' ? 'selected' : '' }}>Adamaoua</option>
                    <option value="Est" {{ old('region', $jobOffer->region) === 'Est' ? 'selected' : '' }}>Est</option>
                    <option value="Extreme-Nord" {{ old('region', $jobOffer->region) === 'Extreme-Nord' ? 'selected' : '' }}>Extrême-Nord</option>
                    <option value="Nord-Ouest" {{ old('region', $jobOffer->region) === 'Nord-Ouest' ? 'selected' : '' }}>Nord-Ouest</option>
                    <option value="Sud-Ouest" {{ old('region', $jobOffer->region) === 'Sud-Ouest' ? 'selected' : '' }}>Sud-Ouest</option>
                </select>
            </div>

            <div>
                <label for="domain">Domaine</label>
                <input id="domain" type="text" name="domain" value="{{ old('domain', $jobOffer->domain) }}" placeholder="IT, Marketing, Finance">
            </div>

            <div>
                <label for="employment_type">Type de contrat</label>
                <select id="employment_type" name="employment_type">
                    @foreach (['full_time' => 'Temps plein / CDI', 'part_time' => 'Temps partiel', 'cdd' => 'CDD', 'contract' => 'Contrat / Freelance', 'temporary' => 'Temporaire', 'stage' => 'Stage', 'internship' => 'Stage / Alternance'] as $key => $label)
                        <option value="{{ $key }}" {{ old('employment_type', $jobOffer->employment_type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="work_mode">Mode de travail</label>
                <select id="work_mode" name="work_mode">
                    @foreach (['remote' => 'Télétravail', 'hybrid' => 'Hybride', 'on_site' => 'Présentiel'] as $key => $label)
                        <option value="{{ $key }}" {{ old('work_mode', $jobOffer->work_mode) === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="salary_min">Salaire minimum</label>
                <input id="salary_min" type="number" step="0.01" name="salary_min" value="{{ old('salary_min', $jobOffer->salary_min) }}">
            </div>

            <div>
                <label for="salary_max">Salaire maximum</label>
                <input id="salary_max" type="number" step="0.01" name="salary_max" value="{{ old('salary_max', $jobOffer->salary_max) }}">
            </div>

            <div>
                <label for="required_experience">Expérience requise</label>
                <input id="required_experience" type="text" name="required_experience" value="{{ old('required_experience', $jobOffer->required_experience) }}" placeholder="3+ ans, Senior, Junior">
            </div>

            <div>
                <label for="education_level">Niveau d’études</label>
                <select id="education_level" name="education_level">
                    <option value="" {{ old('education_level', $jobOffer->education_level) === '' ? 'selected' : '' }}>Non spécifié</option>
                    <option value="Bachelor" {{ old('education_level', $jobOffer->education_level) === 'Bachelor' ? 'selected' : '' }}>Bachelor</option>
                    <option value="Master" {{ old('education_level', $jobOffer->education_level) === 'Master' ? 'selected' : '' }}>Master</option>
                    <option value="Diplôme" {{ old('education_level', $jobOffer->education_level) === 'Diplôme' ? 'selected' : '' }}>Diplôme</option>
                </select>
            </div>

            <div>
                <label for="deadline">Date limite</label>
                <input id="deadline" type="date" name="deadline" value="{{ old('deadline', $jobOffer->deadline ? $jobOffer->deadline->format('Y-m-d') : '') }}">
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description', $jobOffer->description) }}</textarea>
            </div>

            <div>
                <label for="required_skills">Compétences</label>
                <input id="required_skills" type="text" name="required_skills" value="{{ old('required_skills', implode(', ', json_decode($jobOffer->required_skills ?? '[]', true) ?: [])) }}">
            </div>

            <div>
                <label for="benefits">Avantages</label>
                <input id="benefits" type="text" name="benefits" value="{{ old('benefits', implode(', ', json_decode($jobOffer->benefits ?? '[]', true) ?: [])) }}">
            </div>

            <div>
                <label for="is_active">Offre active</label>
                <select id="is_active" name="is_active">
                    <option value="1" {{ old('is_active', $jobOffer->is_active) ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ ! old('is_active', $jobOffer->is_active) ? 'selected' : '' }}>Non</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection
