@extends('layouts.app')

@section('title', 'Mes CV')

@section('content')
    <div class="d-grid gap-5">
        <section class="card">
            <div class="mb-5">
                <p class="small fw-bold text-uppercase text-primary-emphasis">CV</p>
                <h1 class="mt-2 fs-2 fw-bolder text-dark">Mes CV</h1>
                <p class="mt-2 text-secondary">Ajoutez et gérez vos documents de candidature pour les envoyer rapidement.</p>
            </div>

            <form method="POST" action="{{ route('resume.store') }}" enctype="multipart/form-data" class="row row-cols-1 row-cols-md-2 g-4">
                @csrf

                <div class="col-xl-6">
                    <label for="title" class="mb-2 d-block small fw-semibold text-body-secondary">Titre du CV</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Ex. CV Développeur Laravel" class="input-field" required>
                </div>

                <div class="col-xl-3">
                    <label for="file" class="mb-2 d-block small fw-semibold text-body-secondary">Fichier</label>
                    <input id="file" type="file" name="file" accept=".pdf,.doc,.docx" class="input-field form-control">
                </div>

                <div class="col-xl-3 d-flex align-items-end">
                    <label class="d-flex align-items-center gap-2 rounded-3 border border-secondary-subtle bg-light px-3 py-3 small fw-medium text-body-secondary">
                        <input type="checkbox" name="is_default" value="1" class="form-check-input m-0">
                        CV principal
                    </label>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Ajouter un CV</button>
                </div>
            </form>
        </section>

        <section class="card">
            <h2 class="mb-5 fs-3 fw-bolder text-dark">Mes documents</h2>

            <div class="d-grid gap-4">
                @forelse ($resumes as $resume)
                    <div class="rounded-3 border border-secondary-subtle bg-light p-4">
                            <div class="d-flex flex-column gap-4 flex-md-row align-items-md-center justify-content-md-between">
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <strong class="fs-5 text-dark">{{ $resume->title }}</strong>
                                    @if ($resume->is_default)
                                        <span class="badge">Par défaut</span>
                                    @endif
                                </div>
                                <div class="mt-1 small text-secondary">{{ $resume->file_path ? 'Fichier attaché' : 'Aucun fichier associé' }}</div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                @if ($resume->file_path)
                                    <a href="{{ route('resume.download', $resume) }}" class="btn btn-secondary">Télécharger</a>
                                @endif

                                <form method="POST" action="{{ route('resume.setDefault', $resume) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">Définir par défaut</button>
                                </form>

                                <form method="POST" action="{{ route('resume.destroy', $resume) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-secondary">Aucun CV enregistré pour le moment.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
