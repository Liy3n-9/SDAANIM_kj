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
@endsection
