@extends('layouts.adopter.app')

@section('title', 'Mi Panel | Esperanza Animal BQ')

@section('styles')
<style>
    .welcome-container { text-align: center; padding: 40px 20px; background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-bottom: 40px; }
    .welcome-container h1 { font-family: 'Pacifico', cursive; color: #2d7d46; font-size: 2.5em; margin-bottom: 15px; }
    .adopter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; }
    .adopter-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; border-bottom: 5px solid #2d7d46; transition: 0.3s; }
    .adopter-card:hover { transform: translateY(-10px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .adopter-card .icon { font-size: 45px; margin-bottom: 15px; display: block; }
    .adopter-card h3 { color: #333; margin-bottom: 15px; }
    .adopter-card p { color: #666; margin-bottom: 20px; font-size: 0.95em; }
    .adopter-card a { background: #2d7d46; color: white; padding: 10px 20px; border-radius: 50px; text-decoration: none; font-weight: bold; }
</style>
@endsection

@section('content')

    <!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <div class="premium-card" style="text-align: center; margin-bottom: 50px; background: linear-gradient(135deg, #ffffff, #f0fdf4); border-top: 8px solid #2d7d46;">
        <h1 style="font-family: 'Pacifico', cursive; color: #2d7d46; font-size: 3em; margin-bottom: 15px;">¡Hola, {{ Auth::user()->name }}! 🐾</h1>
        <p style="color: #64748b; font-size: 1.2em; max-width: 600px; margin: 0 auto;">Gracias por ser parte de nuestra comunidad y apoyarnos en nuestra misión de rescatar vidas.</p>
    </div>

    <!-- Recién llegados -->
<div class="section-header">
    <h3>Recién llegados</h3>
    <a href="{{ route('adopta') }}">Ver más</a>
</div>

<br>

<!-- Carrusel -->
<div class="swiper mySwiper">
    <div class="swiper-wrapper">

        @forelse($animals ?? [] as $animal)
        <div class="swiper-slide">
            <div class="card">
                <a href="{{ route('animal.show', $animal->Anim_id) }}">
                    <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" alt="{{ $animal->Anim_nombre }}">
                    <p>{{ $animal->Anim_nombre }} - {{ $animal->Anim_edad }}</p>
                </a>
            </div>
        </div>
        @empty
        <div class="swiper-slide">
            <div class="card">
                <img src="https://placedog.net/600/400?id=1" alt="Zurito">
                <p>Zurito - 1 año</p>
            </div>
        </div>
        <div class="swiper-slide">
            <div class="card">
                <img src="https://placedog.net/600/400?id=2" alt="Hanna">
                <p>Hanna - 3 meses</p>
            </div>
        </div>
        @endforelse

    </div>

    <!-- Botones -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

    <!-- Paginación -->
    <div class="swiper-pagination"></div>
</div>

<!-- Ubicación -->
<h2>📍 Nuestra ubicación</h2>
<div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Inicializar carrusel
        const swiper = new Swiper(".mySwiper", {
            slidesPerView: 3,
            spaceBetween: 20,
            loop: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });

        // Google Maps
        function initMap() {
            const ubicacion = {
                lat: 10.920758332832074,
                lng: -74.824875070815
            };

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: ubicacion,
            });

            new google.maps.Marker({
                position: ubicacion,
                map: map,
                title: "Esperanza Animal BQ 🐾"
            });
        }
    </script>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSxjXAhrgyp8ytXfE_3WEjiFvGUz61woM&callback=initMap">
    </script>

    <!-- Estilos -->
    <style>
    .swiper {
        width: 100%;
        padding: 20px 0;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
    }

    .card {
        width: 100%;
        max-width: 300px;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        text-align: center;
    }

    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card p {
        padding: 10px;
        font-weight: bold;
    }
    </style>


    <div class="adopter-grid">
        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">🐶</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Busca un Amigo</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Explora nuestro catálogo de peluditos que buscan un hogar para siempre.</p>
            <a href="{{ route('adopta') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Ver Perros</a>
        </div>
        
        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">📋</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Mis Solicitudes</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Sigue el estado de tus procesos de adopción en tiempo real.</p>
            <a href="{{ route('adopter.requests') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Ver Solicitudes</a>
        </div>

        <div class="premium-card" style="text-align: center;">
            <span class="icon" style="font-size: 4em; margin-bottom: 20px; display: block;">❤️</span>
            <h3 style="font-size: 1.5em; color: #1e293b; margin-bottom: 10px;">Hacer Donación</h3>
            <p style="color: #64748b; margin-bottom: 30px;">Tu aporte ayuda a comprar comida y medicinas para los que aún esperan.</p>
            <a href="{{ route('adopter.donation.create') }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">Donar Ahora</a>
        </div>
    </div>
@endsection
