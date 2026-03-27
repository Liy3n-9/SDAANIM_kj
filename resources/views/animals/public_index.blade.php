@extends('layouts.adopter.app')

@section('title', 'Adopta un Amigo')

@section('styles')
<style>
    /* Contenedor principal */
    .adopta-section { 
        padding: 40px 20px; 
        max-width: 1200px; 
        margin: 0 auto; 
        text-align: center; 
    }

    /* FILTROS (BARRA DE ETAPAS CORREGIDA) */
    .adopta-filtros {
        margin: 30px auto;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;

        flex-wrap: nowrap;        /* siempre una sola fila */
        overflow-x: auto;         /* permite scroll si no cabe */
        
        max-width: 100%;
        width: max-content;       /* el contenido define el ancho */
        padding: 10px 20px;

        scrollbar-width: none;    /* Firefox */
    }

    /* Ocultar scrollbar */
    .adopta-filtros::-webkit-scrollbar {
        display: none;
    }

    /* Botones */
    .filtro-btn {
        padding: 10px 25px;
        font-size: 1.05em;
        border-radius: 30px;
        border: 2px solid #ff6b6b;
        color: #ff6b6b;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 700;
        min-width: 110px;
        text-align: center;
        user-select: none;
        box-shadow: 0 2px 6px rgba(255,107,107,0.3);
    }

    /* Hover + activo */
    .filtro-btn:hover, 
    .filtro-btn.activo {
        background-color: #ff6b6b;
        color: white;
        box-shadow: 0 4px 12px rgba(255,107,107,0.6);
    }

    /* GRID */
    .premium-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 25px;
        justify-items: center;
        margin-top: 30px;
    }

    .premium-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 320px;
        width: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .premium-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .premium-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-bottom: 3px solid #2e8b57;
    }

    .premium-card div {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .premium-card h3 {
        margin: 0 0 10px;
        color: #2e8b57;
        font-weight: 800;
    }

    .premium-card p {
        color: #555;
        font-size: 0.95em;
        margin: 0 0 15px;
        line-height: 1.4;
    }

    .premium-btn-adopter {
        background: #2e8b57;
        color: white;
        padding: 12px 0;
        border-radius: 6px;
        font-weight: 700;
        text-align: center;
        width: 100%;
        cursor: pointer;
        transition: background-color 0.3s;
        user-select: none;
        text-decoration: none;
    }

    .premium-btn-adopter:hover {
        background: #276c45;
    }

    .no-animals {
        grid-column: 1 / -1;
        padding: 50px;
        color: #999;
        font-size: 1.2em;
        font-style: italic;
        text-align: center;
    }
</style>
@endsection

@section('content')
<section class="adopta-section">
    <h1 style="color: #2e8b57; margin-bottom: 10px; font-weight: 800;">
        Adopta un Amigo 🐾
    </h1>

    <p style="color: #64748b; margin-bottom: 40px;">
        Encuentra el compañero perfecto para tu hogar.
    </p>

    <!-- FILTROS -->
    <div class="adopta-filtros">
        <a href="{{ route('adopta', ['etapa' => 'todos']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'todos' ? 'activo' : '' }}">
           Todos
        </a>

        <a href="{{ route('adopta', ['etapa' => 'cachorro']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'cachorro' ? 'activo' : '' }}">
           Cachorros
        </a>

        <a href="{{ route('adopta', ['etapa' => 'joven']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'joven' ? 'activo' : '' }}">
           Jóvenes
        </a>

        <a href="{{ route('adopta', ['etapa' => 'adulto']) }}" 
           class="filtro-btn {{ $etapaFiltro == 'adulto' ? 'activo' : '' }}">
           Adultos
        </a>
    </div>

    <!-- CARDS -->
    <div class="premium-grid">
        @forelse($animals as $animal)
            <div class="premium-card">
                <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" 
                     alt="{{ $animal->Anim_nombre }}">

                <div>
                    <h3>{{ $animal->Anim_nombre }}</h3>

                    <p>
                        {{ $animal->Anim_raza }} • {{ $animal->Anim_sexo }} <br>
                        {{ $animal->Anim_edad }}
                    </p>

                    <a href="{{ route('adopter.adoption.create', $animal->Anim_id) }}" 
                       class="premium-btn-adopter">
                        ¡Quiero Adoptarlo! ❤️
                    </a>
                </div>
            </div>
        @empty
            <p class="no-animals">
                No hay peluditos disponibles por ahora 🐾
            </p>
        @endforelse
    </div>
</section>
@endsection