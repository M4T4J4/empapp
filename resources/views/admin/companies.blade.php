@extends('layouts.app')

@section('title', 'Gestion des entreprises')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="card">
            <h1 class="section-title">Gestion des entreprises</h1>
            <div class="list">
                @foreach ($companies as $company)
                    <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div>
                            <strong>{{ $company->company_name ?? $company->name }}</strong><br>
                            <span class="muted">{{ $company->email }}</span>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                            <span class="badge">{{ $company->is_verified ? 'Validée' : 'À valider' }}</span>
                            <form method="POST" action="{{ route('admin.companies.toggle-approval', $company) }}">
                                @csrf
                                <button type="submit" class="btn {{ $company->is_verified ? 'btn-secondary' : 'btn-primary' }}" style="padding:0.65rem 0.9rem;">{{ $company->is_verified ? 'Refuser' : 'Valider' }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $companies->links() }}
        </section>
    </div>
@endsection
