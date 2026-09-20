@extends('layouts.app')

@section('title', 'Statistiques recruteur')

@section('content')
    <div class="space-y-6">
        <section class="rounded-[28px] border border-slate-200 bg-gradient-to-br from-slate-900 via-slate-800 to-blue-900 p-8 text-white shadow-lg shadow-slate-200/60">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-300">Statistiques</p>
            <h1 class="mt-3 text-4xl font-black tracking-tight">Suivi de performance</h1>
            <p class="mt-3 max-w-2xl text-slate-200">Visualisez rapidement le volume de vos offres, candidatures et profils qualifiés.</p>
        </section>

        <div class="grid gap-5 md:grid-cols-3">
            <div class="card">
                <div class="text-sm text-slate-500">Offres publiées</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $stats['offers'] }}</div>
                <div class="mt-3 text-sm text-emerald-600">Activité en cours</div>
            </div>
            <div class="card">
                <div class="text-sm text-slate-500">Candidatures reçues</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $stats['applications'] }}</div>
                <div class="mt-3 text-sm text-blue-600">Dossiers suivis</div>
            </div>
            <div class="card">
                <div class="text-sm text-slate-500">Candidats visibles</div>
                <div class="mt-3 text-4xl font-black tracking-tight text-slate-900">{{ $stats['candidates'] }}</div>
                <div class="mt-3 text-sm text-violet-600">Profils éligibles</div>
            </div>
        </div>
    </div>
@endsection
