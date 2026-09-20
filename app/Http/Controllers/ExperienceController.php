<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['boolean'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['employment_type'] = match ($validated['employment_type']) {
            'cdi', 'full_time' => 'full_time',
            'cdd', 'contract' => 'contract',
            'stage', 'internship' => 'internship',
            default => $validated['employment_type'],
        };

        Auth::user()->experiences()->create($validated);

        return redirect()->route('profile.edit')->with('success', 'Expérience ajoutée!');
    }

    public function update(Request $request, Experience $experience)
    {
        $this->authorize('update', $experience);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'is_current' => ['boolean'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $validated['employment_type'] = match ($validated['employment_type']) {
            'cdi', 'full_time' => 'full_time',
            'cdd', 'contract' => 'contract',
            'stage', 'internship' => 'internship',
            default => $validated['employment_type'],
        };

        $experience->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Expérience mise à jour!');
    }

    public function destroy(Experience $experience)
    {
        $this->authorize('delete', $experience);
        $experience->delete();

        return redirect()->route('profile.edit')->with('success', 'Expérience supprimée!');
    }
}
