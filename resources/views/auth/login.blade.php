@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="flex min-h-[70vh] items-center justify-center py-10">
        <div class="form-card w-full max-w-xl">
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-sky-500 text-xl font-black text-white shadow-lg shadow-blue-200">E</div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900">Connexion</h1>
                <p class="mt-2 text-sm text-slate-500">Accédez à votre espace candidat ou recruteur.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-error mb-5">
                    <ul class="ml-5 list-disc space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input-field">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Mot de passe</label>
                    <input id="password" type="password" name="password" required class="input-field">
                </div>

                <button type="submit" class="btn btn-primary w-full">Se connecter</button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Pas encore inscrit ?
                <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700">Créer un compte</a>
            </p>
        </div>
    </div>
@endsection
