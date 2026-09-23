<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    public function index()
    {
        if (Auth::check() && ! Auth::user()->is_premium) {
            return redirect()->route('dashboard')->with('error', 'Cette fonctionnalité premium nécessite un abonnement actif.');
        }

        return view('premium.index', [
            'plans' => [
                ['name' => 'Starter', 'price' => 5000, 'features' => ['Candidatures prioritaires', 'Alertes avancées']],
                ['name' => 'Pro', 'price' => 15000, 'features' => ['Tout le Starter', 'Matching personnalisé', 'Statistiques avancées']],
            ],
        ]);
    }

    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan' => ['required', 'string'],
        ]);

        Auth::user()->update([
            'is_premium' => true,
            'premium_plan' => $validated['plan'],
        ]);

        return redirect()->route('premium.index')->with('success', 'Abonnement premium activé.');
    }
}
