@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="flex min-h-[70vh] items-center justify-center py-10">
        <div class="form-card w-full max-w-2xl">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-500 text-xl font-black text-white shadow-lg shadow-indigo-200">E</div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900">Créer mon compte</h1>
                <p class="mt-2 text-sm text-slate-500">Rejoignez notre plateforme emploi.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error mb-6">
                    <ul class="ml-5 list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Nom complet</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required class="input-field">
                    </div>

                    <div class="md:col-span-2">
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input-field">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Type de compte</label>
                        <div class="flex flex-wrap gap-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <label class="flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm">
                                <input type="radio" name="is_recruiter" value="0" {{ old('is_recruiter', 0) == '0' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                Candidat
                            </label>
                            <label class="flex items-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm">
                                <input type="radio" name="is_recruiter" value="1" {{ old('is_recruiter') == '1' ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                Recruteur
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="company_name" class="mb-2 block text-sm font-semibold text-slate-700">Nom de l'entreprise <span class="text-slate-400">(optionnel pour les candidats)</span></label>
                        <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Ex. Entreprise XYZ" class="input-field">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Mot de passe</label>
                        <input id="password" type="password" name="password" required class="input-field">
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirmer</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="input-field">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-full">Créer mon compte</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700">Me connecter</a>
            </p>
        </div>
    </div>
@endsection
