@extends('layouts.app')

@section('title', 'Signalements')

@section('content')
    <div class="card" style="display:grid; gap:18px;">
        <h1 class="section-title">Gestion des signalements</h1>

        @foreach ($reports as $report)
            <div class="list-item" style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
                <div>
                    <strong>{{ $report['title'] }}</strong><br>
                    <span class="muted">Type : {{ $report['type'] }}</span>
                </div>
                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                    <span class="badge">{{ $report['status'] }}</span>
                    <button class="btn btn-secondary" style="padding:0.65rem 0.9rem;">Examiner</button>
                </div>
            </div>
        @endforeach
    </div>
@endsection
