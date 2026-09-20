<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard')->with('success', 'Premium sera bientôt disponible.');
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
