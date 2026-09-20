<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('jobOffer')->paginate(15);
        return view('favorite.index', compact('favorites'));
    }

    public function store(Request $request, JobOffer $jobOffer)
    {
        Auth::user()->favorites()->firstOrCreate([
            'job_offer_id' => $jobOffer->id,
        ]);

        return redirect()->back()->with('success', 'Offre ajoutée aux favoris!');
    }

    public function destroy(Favorite $favorite)
    {
        $this->authorize('delete', $favorite);
        $favorite->delete();

        return redirect()->back()->with('success', 'Offre supprimée des favoris!');
    }
}
