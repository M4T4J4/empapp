@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
    <div style="display:grid; gap:24px;">
        <section class="card">
            <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap;">
                <div>
                    <p class="muted" style="margin:0 0 8px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Conversation</p>
                    <h1 style="margin:0;">{{ $user->name }}</h1>
                </div>
            </div>
        </section>

        <div class="card" style="display:grid; gap:16px;">
            @forelse ($messages as $message)
                @php $isMine = $message->sender_id === Auth::id(); @endphp
                <div style="display:flex; justify-content:{{ $isMine ? 'flex-end' : 'flex-start' }};">
                    <div style="max-width:75%; background:{{ $isMine ? '#dbeafe' : '#f3f6fb' }}; border:1px solid var(--border); border-radius:18px; padding:12px 14px;">
                        <div style="font-size:0.75rem; color:var(--muted); margin-bottom:8px;">{{ $message->created_at->format('d/m/Y H:i') }}</div>
                        <div>{{ $message->body ?: 'Pièce jointe' }}</div>
                        @if ($message->attachment_path)
                            <div style="margin-top:10px;">
                                <a href="{{ Storage::url($message->attachment_path) }}" class="btn btn-secondary" target="_blank" rel="noopener">
                                    {{ $message->attachment_name ?? 'Télécharger la pièce jointe' }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p class="muted">Aucune conversation pour le moment.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('message.store', $user) }}" enctype="multipart/form-data" class="card form-grid">
            @csrf
            <div>
                <label for="message">Votre message</label>
                <textarea id="message" name="message" placeholder="Écrivez votre message ici..."></textarea>
            </div>
            <div>
                <label for="attachment">Pièce jointe</label>
                <input id="attachment" type="file" name="attachment">
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
@endsection
