@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
    <div class="form-card">
        <h1 class="section-title" style="margin-bottom:8px;">Modifier mon profil</h1>
        <p class="muted" style="margin-top:0; margin-bottom:24px;">Mettez à jour vos informations professionnelles.</p>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="form-grid">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Nom complet</label>
                <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
            </div>

            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            <div>
                <label for="phone">Téléphone</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
            </div>

            <div>
                <label for="location">Localisation</label>
                <input id="location" type="text" name="location" value="{{ old('location', Auth::user()->location) }}">
            </div>

            <div>
                <label for="headline">Headline</label>
                <input id="headline" type="text" name="headline" value="{{ old('headline', Auth::user()->headline) }}">
            </div>

            <div>
                <label for="employment_preference">Préférence d’emploi</label>
                <select id="employment_preference" name="employment_preference">
                    <option value="">Non précisée</option>
                    <option value="full_time" {{ old('employment_preference', Auth::user()->employment_preference) === 'full_time' ? 'selected' : '' }}>Temps plein / CDI</option>
                    <option value="part_time" {{ old('employment_preference', Auth::user()->employment_preference) === 'part_time' ? 'selected' : '' }}>Temps partiel</option>
                    <option value="cdd" {{ old('employment_preference', Auth::user()->employment_preference) === 'cdd' ? 'selected' : '' }}>CDD</option>
                    <option value="contract" {{ old('employment_preference', Auth::user()->employment_preference) === 'contract' ? 'selected' : '' }}>Contrat / Freelance</option>
                    <option value="temporary" {{ old('employment_preference', Auth::user()->employment_preference) === 'temporary' ? 'selected' : '' }}>Temporaire</option>
                    <option value="stage" {{ old('employment_preference', Auth::user()->employment_preference) === 'stage' ? 'selected' : '' }}>Stage</option>
                    <option value="internship" {{ old('employment_preference', Auth::user()->employment_preference) === 'internship' ? 'selected' : '' }}>Stage / Alternance</option>
                </select>
            </div>

            <div>
                <label for="bio">Biographie</label>
                <textarea id="bio" name="bio">{{ old('bio', Auth::user()->bio) }}</textarea>
            </div>

            <div>
                <label for="profile_photo">Photo de profil</label>
                <input id="profile_photo" type="file" name="profile_photo" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection
