<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

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
        $request->session()->regenerate();

        $redirectRoute = $user->is_recruiter ? 'recruiter.dashboard' : 'dashboard';

        return redirect()->route($redirectRoute)->with('success', 'Inscription réussie!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $throttleKey = $this->throttleKey($request, $credentials['email']);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => "Trop de tentatives. Réessayez dans {$seconds} secondes.",
            ]);
        }

        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->is_blocked) {
            return back()->withErrors(['email' => 'Ce compte est bloqué. Contactez l’administration.'])->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $redirectRoute = Auth::user()->is_recruiter ? 'recruiter.dashboard' : 'dashboard';

            return redirect()->route($redirectRoute)->with('success', 'Connexion réussie!');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors(['email' => 'Identifiants invalides'])->onlyInput('email');
    }

    private function throttleKey(Request $request, string $email): string
    {
        return strtolower($email).'|'.$request->ip();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnecté avec succès!');
    }
}
