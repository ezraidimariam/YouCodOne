<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create($restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
    
        if(auth()->user()->role != 'client') {
            return back()->with('error', 'Seuls les clients peuvent réserver le resturant');
        }
        
        return view('reservations.create', compact('restaurant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'date' => 'required|date|after_or_equal:today',
            'tables' => 'required|integer|min:1',
        ]);
        
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        
        // si ferme
        if($restaurant->status == 'maintenance') {
            return back()->with('error', 'Restaurant fermé temporairement');
        }
        
        // calculer combien de table reserv
        $tablesReservees = Reservation::where('restaurant_id', $request->restaurant_id)
            ->where('date', $request->date)
            ->sum('tables');
        $nouveauTotal = $tablesReservees + $request->tables;
        
        
        if($nouveauTotal > $restaurant->capacity) {
            return back()->with('error', 'Désolé, plus assez de tables disponibles !');
        }
    
        
        Reservation::create([
            'user_id' => auth()->id(),
            'restaurant_id' => $request->restaurant_id,
            'date' => $request->date,
            'tables' => $request->tables,
        ]);
        
    
        if($nouveauTotal >= $restaurant->capacity * 0.9) {
            return redirect()->route('restaurants.browse')
               ->with('error!', 'Réservation OK mais pas complète!');
        }
        
   
        
        return redirect()->route('restaurants.browse')
            ->with('success', 'Réservation effectuée avec succès');
    }
}