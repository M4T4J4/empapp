<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'grade' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        Auth::user()->educations()->create($validated);

        return redirect()->route('profile.edit')->with('success', 'Formation ajoutée!');
    }

    public function update(Request $request, Education $education)
    {
        $this->authorize('update', $education);

        $validated = $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'field_of_study' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'grade' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $education->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Formation mise à jour!');
    }

    public function destroy(Education $education)
    {
        $this->authorize('delete', $education);
        $education->delete();

        return redirect()->route('profile.edit')->with('success', 'Formation supprimée!');
    }
}
