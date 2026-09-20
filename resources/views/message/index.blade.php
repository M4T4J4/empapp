@extends('layouts.app')

@section('title', 'Messages')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Messagerie</p>
            <h1>Conversations</h1>
            <p>Suivez vos échanges avec les recruteurs et les candidats.</p>
        </section>

        <div class="list">
            @forelse ($conversations as $conversation)
                @php $contact = $conversation['contact']; @endphp
                <div class="card" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div>
                        <strong>{{ $contact?->name ?? 'Conversation' }}</strong>
                        <div class="muted" style="margin-top:6px;">{{ $conversation['last_message']->body ?: 'Pièce jointe' }}</div>
                    </div>
                    <a href="{{ route('message.show', $contact) }}" class="btn btn-primary">Ouvrir</a>
                </div>
            @empty
                <div class="card"><p class="muted">Aucune conversation pour le moment.</p></div>
            @endforelse
        </div>
    </div>
@endsection
