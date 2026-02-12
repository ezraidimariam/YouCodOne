<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;   
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function store(Request $request)
    {
        
        if (auth()->user()->role !== 'restaurateur') {
            return back()->with('error', 'Accès refusé');
        }
        

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ville' => 'required|string|max:200',
            'capacity' => 'required|integer|min:1',
            'cuisine' => 'required|string|max:200',
        ]);

      
        $validated['user_id'] = auth()->id();

        Restaurant::create($validated);

        return redirect()->route('restaurants.index')
                         ->with('success', 'Restaurant créé avec succès');
    }

    public function edit(Restaurant $restaurant)
    {
        if ($restaurant->user_id !== auth()->id()) {
            abort(403, 'Accès refusé');
        }

        return view('restaurants.edit', compact('restaurant'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {
        if ($restaurant->user_id !== auth()->id()) {
            abort(403, 'Accès refusé');
        }

        $restaurant->update($request->validate([
            'name' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'cuisine' => 'required|string|max:255',
        ]));

        return redirect()->route('restaurants.index')
                         ->with('success', 'Restaurant mis à jour');
    }

    public function destroy(Restaurant $restaurant)
    {
        if ($restaurant->user_id !== auth()->id()) {
            abort(403, 'Accès refusé');
        }

        $restaurant->delete();

        return redirect()->route('restaurants.index')
                         ->with('success', 'Restaurant supprimé');
                         
                    

                                  
    }
    public function index()
{
    $restos = Restaurant::when(request()->filled('ville'), function ($q) {
            $q->where('ville', 'like', '%' . request('ville') . '%');
        })
        ->when(request()->filled('cuisine'), function ($q) {
            $q->where('cuisine', 'like', '%' . request('cuisine') . '%');
           
        })
        ->paginate(request('per_page',10));

    return view('restaurants.index', compact('restos'));
}


public function show($id)
{
    $restaurant = Restaurant::findOrFail($id);
    return view('restaurants.show', compact('restaurant'));
}

}

