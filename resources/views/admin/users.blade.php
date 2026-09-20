@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="card">
            <h1 class="section-title">Gestion des utilisateurs</h1>
            <div class="list">
                @foreach ($users as $user)
                    <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div>
                            <strong>{{ $user->name }}</strong><br>
                            <span class="muted">{{ $user->email }}</span>
                        </div>
                        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                            <span class="badge">{{ $user->is_recruiter ? 'Entreprise' : 'Candidat' }}</span>
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                @csrf
                                <button type="submit" class="btn {{ $user->is_admin ? 'btn-secondary' : 'btn-primary' }}" style="padding:0.65rem 0.9rem;">{{ $user->is_admin ? 'Retirer admin' : 'Rendre admin' }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $users->links() }}
        </section>
    </div>
@endsection
