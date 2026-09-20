<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'language_id' => ['required', 'exists:languages,id'],
            'proficiency_level' => ['required', 'in:elementary,limited_working,professional_working,full_professional,native'],
        ]);

        Auth::user()->languages()->syncWithoutDetaching([
            $validated['language_id'] => [
                'proficiency_level' => $validated['proficiency_level'],
            ]
        ]);

        return redirect()->route('profile.edit')->with('success', 'Langue ajoutée!');
    }

    public function destroy($languageId)
    {
        Auth::user()->languages()->detach($languageId);
        return redirect()->route('profile.edit')->with('success', 'Langue supprimée!');
    }
}
