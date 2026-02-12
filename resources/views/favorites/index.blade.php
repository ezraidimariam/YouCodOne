<h2>Mes Favoris</h2>

@foreach($restos as $r)
    <p>{{ $r->name }} - {{ $r->ville }}</p>
@endforeach
