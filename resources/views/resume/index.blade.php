@extends('layouts.app')

@section('title', 'Mes CV')

@section('content')
    <div class="space-y-6">
        <section class="card">
            <div class="mb-5">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-blue-700">CV</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900">Mes CV</h1>
                <p class="mt-2 text-slate-600">Ajoutez et gérez vos documents de candidature pour les envoyer rapidement.</p>
            </div>

            <form method="POST" action="{{ route('resume.store') }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                @csrf

                <div class="xl:col-span-2">
                    <label for="title" class="mb-2 block text-sm font-semibold text-slate-700">Titre du CV</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="Ex. CV Développeur Laravel" class="input-field" required>
                </div>

                <div>
                    <label for="file" class="mb-2 block text-sm font-semibold text-slate-700">Fichier</label>
                    <input id="file" type="file" name="file" accept=".pdf,.doc,.docx" class="input-field file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white">
                </div>

                <div class="flex items-end">
                    <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-3 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="is_default" value="1" class="h-4 w-4 rounded text-blue-600 focus:ring-blue-500">
                        CV principal
                    </label>
                </div>

                <div class="xl:col-span-4">
                    <button type="submit" class="btn btn-primary">Ajouter un CV</button>
                </div>
            </form>
        </section>

        <section class="card">
            <h2 class="mb-5 text-2xl font-black tracking-tight text-slate-900">Mes documents</h2>

            <div class="space-y-4">
                @forelse ($resumes as $resume)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <div class="flex items-center gap-2">
                                    <strong class="text-lg text-slate-900">{{ $resume->title }}</strong>
                                    @if ($resume->is_default)
                                        <span class="badge">Par défaut</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-sm text-slate-500">{{ $resume->file_path ? 'Fichier attaché' : 'Aucun fichier associé' }}</div>
                            </div>

                            <div class="flex flex-wrap gap-2">
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
                    <p class="text-slate-600">Aucun CV enregistré pour le moment.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
