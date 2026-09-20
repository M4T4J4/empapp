@extends('layouts.app')

@section('title', 'Gestion des notifications')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="card">
            <h1 class="section-title">Gestion des notifications</h1>
            <div class="list">
                @foreach ($notifications as $notification)
                    <div class="list-item">
                        <strong>{{ $notification->title }}</strong>
                        <div class="muted" style="margin-top:6px;">{{ $notification->message }}</div>
                        <div class="muted" style="margin-top:6px; font-size: 0.8rem;">{{ $notification->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                @endforeach
            </div>
            {{ $notifications->links() }}
        </section>
    </div>
@endsection
