<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function index()
    {
        $resumes = Auth::user()->resumes;
        return view('resume.index', compact('resumes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('resumes', 'private');
        }

        if (!empty($validated['is_default'])) {
            Auth::user()->resumes()->update(['is_default' => false]);
        }

        Auth::user()->resumes()->create([
            'title' => $validated['title'],
            'file_path' => $path,
            'is_default' => $validated['is_default'] ?? false,
        ]);

        return redirect()->route('resume.index')->with('success', 'CV créé!');
    }

    public function update(Request $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('resumes', 'private');
            $resume->file_path = $path;
        }

        $resume->update(['title' => $validated['title']]);

        return redirect()->route('resume.index')->with('success', 'CV mis à jour!');
    }

    public function setDefault(Resume $resume)
    {
        $this->authorize('update', $resume);

        Auth::user()->resumes()->update(['is_default' => false]);
        $resume->update(['is_default' => true]);

        return redirect()->route('resume.index')->with('success', 'CV défini par défaut!');
    }

    public function destroy(Resume $resume)
    {
        $this->authorize('delete', $resume);
        $resume->delete();

        return redirect()->route('resume.index')->with('success', 'CV supprimé!');
    }

    public function download(Resume $resume)
    {
        $this->authorize('view', $resume);

        if (! $resume->file_path || ! storage_path('app/' . $resume->file_path)) {
            return redirect()->back()->with('error', 'Ce CV n’a pas de fichier associé.');
        }

        $path = storage_path('app/' . $resume->file_path);

        return response()->download($path, $resume->title . '.pdf');
    }
}
