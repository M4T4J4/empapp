@extends('layouts.app')

@section('title', 'Premium')

@section('content')
    <div style="display:grid; gap:20px;">
        <section class="hero">
            <p class="muted" style="margin:0 0 10px; font-weight:800; color:var(--primary-dark); letter-spacing:0.08em; text-transform:uppercase; font-size:0.72rem;">Premium</p>
            <h1>Accédez aux services premium</h1>
            <p>Boostez votre visibilité, votre matching et vos statistiques.</p>
        </section>

        <div class="grid grid-3">
            @foreach ($plans as $plan)
                <div class="card">
                    <h2>{{ $plan['name'] }}</h2>
                    <div class="stat-number">{{ number_format($plan['price'], 0, ',', ' ') }} FCFA</div>
                    <ul>
                        @foreach ($plan['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('premium.checkout') }}">
                        @csrf
                        <input type="hidden" name="plan" value="{{ $plan['name'] }}">
                        <button type="submit" class="btn btn-primary">Choisir</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@endsection
