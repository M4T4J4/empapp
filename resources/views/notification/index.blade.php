@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="hero">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                <div>
                    <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Centre de messages</p>
                    <h1>Notifications</h1>
                </div>
                <form method="POST" action="{{ route('notification.readAll') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Tout marquer comme lu</button>
                </form>
            </div>
        </section>

        <div class="list">
            @forelse ($notifications as $notification)
                <div class="card" style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap; {{ $notification->is_read ? 'opacity:0.8;' : '' }}">
                    <div>
                        <strong>{{ $notification->title }}</strong>
                        <div class="muted" style="margin-top:6px;">{{ $notification->message }}</div>
                    </div>
                    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        @if (!$notification->is_read)
                            <form method="POST" action="{{ route('notification.read', $notification) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding:0.65rem 0.9rem;">Lu</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('notification.destroy', $notification) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding:0.65rem 0.9rem;">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="card"><p class="muted">Aucune notification.</p></div>
            @endforelse
        </div>
    </div>
@endsection
