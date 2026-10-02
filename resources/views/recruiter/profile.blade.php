@extends('layouts.app')

@section('title', 'Profil entreprise')

@section('content')
    <div class="form-card">
        <h1 class="section-title" style="margin-bottom:8px;">Profil de l’entreprise</h1>
        <p class="muted" style="margin-top:0; margin-bottom:24px;">Renseignez les informations visibles par les candidats.</p>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('recruiter.profile.update') }}" enctype="multipart/form-data" class="form-grid">
            @csrf
            @method('PUT')

            <div>
                <label for="company_name">Nom de l’entreprise</label>
                <input id="company_name" type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}">
            </div>

            <div>
                <label for="company_description">Présentation</label>
                <textarea id="company_description" name="company_description">{{ old('company_description', $user->company_description) }}</textarea>
            </div>

            <div>
                <label for="company_website">Site web</label>
                <input id="company_website" type="url" name="company_website" value="{{ old('company_website', $user->company_website) }}">
            </div>

            <div>
                <label for="company_phone">Téléphone</label>
                <input id="company_phone" type="text" name="company_phone" value="{{ old('company_phone', $user->company_phone) }}">
            </div>

            <div>
                <label for="company_location">Ville / siège</label>
                <input id="company_location" type="text" name="company_location" value="{{ old('company_location', $user->company_location) }}">
            </div>

            <div>
                <label for="company_size">Taille d’entreprise</label>
                <input id="company_size" type="text" name="company_size" value="{{ old('company_size', $user->company_size) }}" placeholder="50-200 salariés">
            </div>

            <div>
                <label for="logo">Logo</label>
                <input id="logo" type="file" name="logo" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection
