<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlertController extends Controller
{
    protected function normalizeEmploymentType(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($value) {
            'cdi', 'full_time' => 'full_time',
            'cdd', 'contract' => 'contract',
            'stage', 'internship' => 'internship',
            'freelance', 'independant', 'independent' => 'contract',
            'temporary', 'part_time', 'full_time', 'contract', 'internship' => $value,
            default => $value,
        };
    }

    public function index()
    {
        $alerts = Auth::user()->alerts()->latest()->get();

        return view('alert.index', compact('alerts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keywords' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'min_salary' => ['nullable', 'numeric', 'min:0'],
            'max_salary' => ['nullable', 'numeric', 'min:0'],
        ]);

        if (! empty($validated['employment_type'])) {
            $validated['employment_type'] = $this->normalizeEmploymentType($validated['employment_type']);
        }

        if (! empty($validated['keywords'])) {
            $validated['keywords'] = array_values(array_filter(array_map('trim', preg_split('/[;,]+/', $validated['keywords']))));
        } else {
            $validated['keywords'] = null;
        }

        Auth::user()->alerts()->create($validated);

        return redirect()->route('alert.index')->with('success', 'Alerte créée!');
    }

    public function update(Request $request, Alert $alert)
    {
        $this->authorize('update', $alert);

        $validated = $request->validate([
            'keywords' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'in:full_time,part_time,contract,temporary,internship,cdi,cdd,stage,freelance,independant,independent'],
            'min_salary' => ['nullable', 'numeric', 'min:0'],
            'max_salary' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        if (! empty($validated['employment_type'])) {
            $validated['employment_type'] = $this->normalizeEmploymentType($validated['employment_type']);
        }

        if (! empty($validated['keywords'])) {
            $validated['keywords'] = array_values(array_filter(array_map('trim', preg_split('/[;,]+/', $validated['keywords']))));
        } else {
            $validated['keywords'] = null;
        }

        $alert->update($validated);

        return redirect()->route('alert.index')->with('success', 'Alerte mise à jour!');
    }

    public function destroy(Alert $alert)
    {
        $this->authorize('delete', $alert);
        $alert->delete();

        return redirect()->route('alert.index')->with('success', 'Alerte supprimée!');
    }
}
