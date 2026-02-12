@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Restaurants</h1>

    {{-- Formulaire de recherche --}}
    <form method="GET" action="{{ route('restaurants.index') }}">
        <input type="text" name="ville" placeholder="Ville" value="{{ request('ville') }}">
        <input type="text" name="cuisine" placeholder="Cuisine" value="{{ request('cuisine') }}">
        
        <select name="per_page">
            <option value="4" {{ request('per_page') == 4 ? 'selected' : '' }}>4</option>
            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
        </select>

        <button type="submit">Rechercher</button>
    </form>

    {{-- Résultats --}}
    $user = Use
    @foreach($restos as $resto)
        <div>
            <h3>{{ $resto->nom }}</h3>
            <p>Ville : {{ $resto->ville }}</p>
            <p>Cuisine : {{ $resto->cuisine }}</p>
            <a href="{{ route('restaurants.show', $resto->id) }}">Voir détails</a>
        </div>
    @endforeach

    {{-- Pagination --}}
    {{ $restos->links()}}
</div>
@endsection
