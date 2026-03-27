@extends('layouts.adopter.app')

@section('title', 'SDAANIM | Adopción de Mascotas')

@section('content')

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

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

<!-- Carrusel -->
<div class="swiper mySwiper">
    <div class="swiper-wrapper">

        @forelse($animals ?? [] as $animal)
        <div class="swiper-slide">
            <div class="card">
                <a href="javascript:void(0);" 
                    onclick="abrirModal(
                        '{{ $animal->Anim_nombre }}',
                        '{{ $animal->Anim_edad }}',
                        '{{ $animal->Anim_raza }}',
                        '{{ $animal->Anim_historia ?? 'Sin historia disponible' }}',
                        '{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}'
                    )">
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

    /* MODAL */
    .modal {
        display: none;
        position: fixed;
        z-index: 999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
    }

    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 25px;
        width: 90%;
        max-width: 400px;
        border-radius: 15px;
        text-align: center;
        animation: fadeIn 0.3s ease;
    }

    .modal-content img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .close {
        float: right;
        font-size: 28px;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }
    </style>

    <!-- MODAL -->
    <div id="animalModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>

            <img id="modalImg" src="" alt="">

            <h2 id="modalNombre"></h2>
            <p><strong>Edad:</strong> <span id="modalEdad"></span></p>
            <p><strong>Raza:</strong> <span id="modalRaza"></span></p>
            <p id="modalHistoria"></p>
        </div>
    </div>

    <script>
        function abrirModal(nombre, edad, raza, historia, foto) {
            document.getElementById('modalNombre').innerText = nombre;
            document.getElementById('modalEdad').innerText = edad;
            document.getElementById('modalRaza').innerText = raza;
            document.getElementById('modalHistoria').innerText = historia;
            document.getElementById('modalImg').src = foto;

            document.getElementById('animalModal').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('animalModal').style.display = 'none';
        }

        /* cerrar al hacer click afuera */
        window.onclick = function(e) {
            const modal = document.getElementById('animalModal');
            if (e.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>


    @endsection