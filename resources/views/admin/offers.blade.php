@extends('layouts.app')

@section('title', 'Gestion des offres')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="card">
            <h1 class="section-title">Gestion des offres</h1>
            <div class="list">
                @foreach ($offers as $offer)
                    <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div>
                            <strong>{{ $offer->title }}</strong><br>
                            <span class="muted">{{ $offer->user->company_name ?? $offer->user->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('admin.offers.toggle-approval', $offer) }}">
                            @csrf
                            <button type="submit" class="btn {{ $offer->is_active ? 'btn-secondary' : 'btn-primary' }}" style="padding:0.65rem 0.9rem;">{{ $offer->is_active ? 'Dévalider' : 'Valider' }}</button>
                        </form>
                    </div>
                @endforeach
            </div>
            {{ $offers->links() }}
        </section>
    </div>
@endsection
