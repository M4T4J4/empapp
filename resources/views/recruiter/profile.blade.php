@extends('layouts.app')

@section('title', 'Profil entreprise')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-8 text-white shadow-lg shadow-slate-200/60">
            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    @if ($user->company_logo)
                        <img src="{{ Storage::url($user->company_logo) }}" alt="Logo de l’entreprise" class="h-20 w-20 rounded-2xl border-4 border-white/20 object-cover shadow-lg shadow-slate-900/30">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 to-blue-600 text-2xl font-black text-white shadow-lg shadow-slate-900/20">
                            {{ strtoupper(substr($user->company_name ?? $user->name ?? 'E', 0, 1)) }}
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Entreprise</p>
                        <h1 class="mt-2 text-4xl font-black tracking-tight">{{ $user->company_name ?? 'Profil de l’entreprise' }}</h1>
                    </div>
                </div>
            </div>
            <p class="mt-5 max-w-2xl text-slate-200">Mettez à jour les informations visibles par les candidats et donnez une image plus crédible à votre marque employeur.</p>
        </section>

        <div class="card mx-auto max-w-5xl">
            @if ($errors->any())
                <div class="alert alert-error mb-6">
                    <ul class="ml-5 list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('recruiter.profile.update') }}" enctype="multipart/form-data" class="grid gap-5 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div class="md:col-span-2">
                    <label for="company_name" class="mb-2 block text-sm font-semibold text-slate-700">Nom de l’entreprise</label>
                    <input id="company_name" type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" class="input-field" placeholder="Ex : Acme Labs">
                </div>

                <div class="md:col-span-2">
                    <label for="company_description" class="mb-2 block text-sm font-semibold text-slate-700">Présentation</label>
                    <textarea id="company_description" name="company_description" rows="5" class="input-field" placeholder="Décrivez votre entreprise, votre culture et vos missions.">{{ old('company_description', $user->company_description) }}</textarea>
                </div>

                <div>
                    <label for="company_website" class="mb-2 block text-sm font-semibold text-slate-700">Site web</label>
                    <input id="company_website" type="url" name="company_website" value="{{ old('company_website', $user->company_website) }}" class="input-field" placeholder="https://example.com">
                </div>

                <div>
                    <label for="company_phone" class="mb-2 block text-sm font-semibold text-slate-700">Téléphone</label>
                    <input id="company_phone" type="text" name="company_phone" value="{{ old('company_phone', $user->company_phone) }}" class="input-field" placeholder="+237 6xx xx xx xx">
                </div>

                <div>
                    <label for="company_location" class="mb-2 block text-sm font-semibold text-slate-700">Ville / siège</label>
                    <input id="company_location" type="text" name="company_location" value="{{ old('company_location', $user->company_location) }}" class="input-field" placeholder="Yaoundé, Douala...">
                </div>

                <div>
                    <label for="company_size" class="mb-2 block text-sm font-semibold text-slate-700">Taille d’entreprise</label>
                    <input id="company_size" type="text" name="company_size" value="{{ old('company_size', $user->company_size) }}" class="input-field" placeholder="50-200 salariés">
                </div>

                <div class="md:col-span-2">
                    <label for="logo" class="mb-2 block text-sm font-semibold text-slate-700">Logo de l’entreprise</label>
                    <input id="logo" type="file" name="logo" accept="image/*" class="w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                </div>

                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
@endsection
