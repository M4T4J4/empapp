<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'proficiency_level' => ['required', 'in:beginner,intermediate,expert'],
            'years_experience' => ['nullable', 'integer', 'min:0'],
        ]);

        $skill = Skill::firstOrCreate(
            ['name' => $validated['name']],
            ['category' => null]
        );

        Auth::user()->skills()->syncWithoutDetaching([
            $skill->id => [
                'proficiency_level' => $validated['proficiency_level'],
                'years_experience' => $validated['years_experience'] ?? 0,
            ]
        ]);

        return redirect()->route('profile.edit')->with('success', 'Compétence ajoutée!');
    }

    public function destroy($skillId)
    {
        Auth::user()->skills()->detach($skillId);
        return redirect()->route('profile.edit')->with('success', 'Compétence supprimée!');
    }
}
