@extends('layouts.app')

@section('title', 'Gestion des candidats')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="card">
            <h1 class="section-title">Gestion des candidats</h1>
            <div class="list">
                @foreach ($candidates as $candidate)
                    <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div>
                            <strong>{{ $candidate->name }}</strong><br>
                            <span class="muted">{{ $candidate->email }}</span>
                        </div>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <span class="badge">{{ $candidate->is_admin ? 'Admin' : 'Candidat' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $candidates->links() }}
        </section>
    </div>
@endsection
