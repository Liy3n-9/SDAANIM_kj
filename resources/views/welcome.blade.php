@extends('layouts.adopter.app')

@section('title', 'SDAANIM | Adopción de Mascotas')

@section('content')
<!-- Banner -->
<div class="banner">
    <h2>¡Encuentra a tu nuevo mejor amigo!</h2>
    <p>Todos los animales de la calle necesitan nuestra protección.
        <br>¡Ayúdanos hoy!
    </p>
</div>

<!-- Recién llegados -->
<div class="section-header">
    <h3>Recién llegados</h3>
    <a href="{{ route('adopta') }}">Ver más</a>
</div>
<br>
<div class="cards" id="animales">
    @forelse($animals ?? [] as $animal)
    <div class="card">
        <a href="{{ route('animal.show', $animal->Anim_id) }}">
            <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" alt="{{ $animal->Anim_nombre }}">
            <p>{{ $animal->Anim_nombre }} - {{ $animal->Anim_edad }}</p>
        </a>
    </div>
    @empty
    <div class="card">
        <img src="https://placedog.net/600/400?id=1" alt="Zurito">
        <p>Zurito - 1 año</p>
    </div>
    <div class="card">
        <img src="https://placedog.net/600/400?id=2" alt="Hanna">
        <p>Hanna - 3 meses</p>
    </div>
    @endforelse
</div>
<h2>📍 Nuestra ubicación</h2>

<div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>

<script>
    function initMap() {

        // 📍 Coordenadas (ejemplo Barranquilla)
        const ubicacion = {
            lat: 10.920758332832074,
            lng: -74.824875070815
        };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: ubicacion,
        });

        const marker = new google.maps.Marker({
            position: ubicacion,
            map: map,
            title: "Esperanza Animal BQ 🐾"
        });
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSxjXAhrgyp8ytXfE_3WEjiFvGUz61woM&callback=initMap">
</script>
@endsection