<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| Public routes (sans login)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));

Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');


Route::middleware(['auth'])->group(function () {

    // CRUD Restaurants (sauf index & show)
    Route::resource('restaurants', RestaurantController::class)
        ->except(['index', 'show']);

    // Favoris
    Route::post('/favorites/{restaurant}', [FavoriteController::class, 'toggle'])
        ->name('favorites.toggle');

    Route::get('/mes-favoris', [FavoriteController::class, 'index'])
        ->name('favorites.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role spaces (via Gates)
    Route::get('/client', fn () => 'Client space')->middleware('can:isClient');
    Route::get('/restaurateur', fn () => 'Restaurateur space')->middleware('can:isRestaurateur');
});

require __DIR__.'/auth.php';