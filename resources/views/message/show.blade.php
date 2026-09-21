@extends('layouts.app')

@section('title', 'Conversation')

@section('content')
    <div style="display:grid; gap:24px; max-width:900px; margin:0 auto;">
        <section class="card" style="padding:0; overflow:hidden; border-radius:24px; border:1px solid #e2e8f0; background:linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; padding:18px 22px; background:linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%); color:white;">
                <div>
                    <p style="margin:0 0 6px; font-size:0.7rem; font-weight:800; letter-spacing:0.14em; text-transform:uppercase; opacity:0.85;">Conversation</p>
                    <h1 style="margin:0; font-size:1.7rem; font-weight:800;">{{ $user->name }}</h1>
                </div>
                <div style="width:12px; height:12px; border-radius:9999px; background:#22c55e; box-shadow:0 0 0 4px rgba(34,197,94,0.15);"></div>
            </div>
        </section>

        <div class="card" style="display:grid; gap:16px; padding:22px 18px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:24px;">
            @forelse ($messages as $message)
                @php $isMine = $message->sender_id === Auth::id(); @endphp
                <div style="display:flex; justify-content:{{ $isMine ? 'flex-end' : 'flex-start' }};">
                    <div style="max-width:72%;">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px; justify-content:{{ $isMine ? 'flex-end' : 'flex-start' }}; color:#64748b; font-size:0.72rem; font-weight:600;">
                            <span>{{ $isMine ? 'Vous' : $user->name }}</span>
                            <span>•</span>
                            <span>{{ $message->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="background:{{ $isMine ? 'linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%)' : '#ffffff' }}; color:{{ $isMine ? '#ffffff' : '#0f172a' }}; border:1px solid {{ $isMine ? '#2563eb' : '#e2e8f0' }}; border-radius:18px 18px {{ $isMine ? '4px' : '18px' }} {{ $isMine ? '18px' : '4px' }}; padding:12px 14px; box-shadow:0 6px 14px rgba(15, 23, 42, 0.06);">
                            <div style="line-height:1.6; white-space:pre-wrap; word-break:break-word;">{{ $message->body ?: 'Pièce jointe' }}</div>
                            @if ($message->attachment_path)
                                <div style="margin-top:12px;">
                                    <a href="{{ Storage::url($message->attachment_path) }}" class="btn btn-secondary" target="_blank" rel="noopener" style="background:{{ $isMine ? 'rgba(255,255,255,0.14)' : '#f8fafc' }}; border-color:{{ $isMine ? 'rgba(255,255,255,0.3)' : '#e2e8f0' }}; color:{{ $isMine ? '#ffffff' : '#0f172a' }};">
                                        {{ $message->attachment_name ?? 'Télécharger la pièce jointe' }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="muted" style="margin:0;">Aucune conversation pour le moment.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('message.store', $user) }}" enctype="multipart/form-data" class="card" style="display:grid; gap:16px; padding:20px; border-radius:24px; border:1px solid #e2e8f0; background:white; box-shadow:0 10px 30px rgba(15,23,42,0.04);">
            @csrf
            <div>
                <label for="message" style="display:block; margin-bottom:8px; font-weight:700; color:#0f172a;">Votre message</label>
                <textarea id="message" name="message" placeholder="Écrivez votre message ici..." style="min-height:110px; resize:vertical; border:1px solid #cbd5e1; border-radius:16px; padding:14px 16px; background:#f8fafc; color:#0f172a; width:100%;"></textarea>
            </div>
            <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                <div style="flex:1; min-width:220px;">
                    <label for="attachment" style="display:block; margin-bottom:8px; font-weight:700; color:#0f172a;">Pièce jointe</label>
                    <input id="attachment" type="file" name="attachment" style="width:100%; border:1px dashed #94a3b8; border-radius:12px; background:#f8fafc; padding:10px 12px; color:#0f172a;">
                </div>
                <button type="submit" class="btn btn-primary" style="align-self:flex-end; border-radius:12px; padding:0.9rem 1.4rem; font-weight:700;">Envoyer</button>
            </div>
        </form>
    </div>
@endsection
