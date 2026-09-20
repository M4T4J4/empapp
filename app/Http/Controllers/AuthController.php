<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'company_name' => ['nullable', 'string', 'max:255'],
            'is_recruiter' => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'company_name' => $validated['company_name'] ?? null,
            'is_recruiter' => (bool) ($validated['is_recruiter'] ?? false),
        ]);

        event(new Registered($user));

        Auth::login($user);

        $redirectRoute = $user->is_recruiter ? 'recruiter.dashboard' : 'dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Inscription réussie!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->is_blocked) {
            return back()->withErrors(['email' => 'Ce compte est bloqué. Contactez l’administration.'])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            $redirectRoute = Auth::user()->is_recruiter ? 'recruiter.dashboard' : 'dashboard';

            return redirect()->route($redirectRoute)->with('success', 'Connexion réussie!');
        }

        return back()->withErrors(['email' => 'Identifiants invalides'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnecté avec succès!');
    }
}
