@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $restaurant->nom }}</h1>

    <p><strong>Ville :</strong> {{ $restaurant->ville }}</p>
    <p><strong>Cuisine :</strong> {{ $restaurant->cuisine }}</p>
    <p><strong>Capacité :</strong> {{ $restaurant->capacite }} personnes</p>
    <p><strong>Horaires :</strong> {{ $restaurant->horaires }}</p>

    {{-- Affichage des photos si disponibles --}}
    @if($restaurant->photos)
        <div>
            <h3>Photos</h3>
            @foreach($restaurant->photos as $photo)
                <img src="{{ asset('storage/' . $photo) }}" alt="Photo du restaurant" width="200">
            @endforeach
        </div>
    @endif

    {{-- Affichage du menu si disponible --}}
    @if($restaurant->menu)
        <div>
            <h3>Menu</h3>
            <p>{{ $restaurant->menu }}</p>
        </div>
    @endif

    {{-- Bouton retour --}}
    <a href="{{ route('restaurants.index') }}" class="btn btn-secondary">← Retour à la liste</a>
</div>
@endsection
