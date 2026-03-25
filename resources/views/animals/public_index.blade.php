@extends('layouts.adopter.app')

@section('title', 'Adopta un Amigo')

@section('styles')
<style>
    .adopta-section { padding: 40px 20px; max-width: 1200px; margin: 0 auto; text-align: center; }
    .adopta-filtros { margin: 30px 0; }
    .filtro-btn { padding: 8px 15px; border-radius: 20px; border: 2px solid #ff6b6b; color: #ff6b6b; text-decoration: none; margin-right: 10px; transition: 0.3s; }
    .filtro-btn:hover, .filtro-btn.activo { background-color: #ff6b6b; color: white; }
    .adopta-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 30px; }
    .adopta-card { background: white; border-radius: 10px; padding: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: 0.3s; }
    .adopta-card:hover { transform: translateY(-5px); }
    .adopta-card img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; }
    .adoptar-btn { display: inline-block; margin-top: 15px; background: #2e8b57; color: white; padding: 10px 20px; border-radius: 5px; font-weight: bold; }
</style>
@endsection

@section('content')
<section style="padding: 40px 20px; max-width: 1200px; margin: 0 auto; text-align: center;">
    <h1 style="color: #2e8b57; margin-bottom: 10px; font-weight: 800;">Adopta un Amigo 🐾</h1>
    <p style="color: #64748b; margin-bottom: 40px;">Encuentra el compañero perfecto para tu hogar.</p>

    <!-- FILTROS SIMPLE -->
    <div style="margin-bottom: 30px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
        <a href="{{ route('adopta', ['etapa' => 'todos']) }}" class="premium-btn" style="background: {{ $etapaFiltro == 'todos' ? 'var(--primary-adopter)' : '#fff' }}; color: {{ $etapaFiltro == 'todos' ? '#fff' : '#64748b' }}; border: 1px solid #ddd;">Todos</a>
        <a href="{{ route('adopta', ['etapa' => 'cachorro']) }}" class="premium-btn" style="background: {{ $etapaFiltro == 'cachorro' ? 'var(--primary-adopter)' : '#fff' }}; color: {{ $etapaFiltro == 'cachorro' ? '#fff' : '#64748b' }}; border: 1px solid #ddd;">Cachorros</a>
        <a href="{{ route('adopta', ['etapa' => 'joven']) }}" class="premium-btn" style="background: {{ $etapaFiltro == 'joven' ? 'var(--primary-adopter)' : '#fff' }}; color: {{ $etapaFiltro == 'joven' ? '#fff' : '#64748b' }}; border: 1px solid #ddd;">Jóvenes</a>
        <a href="{{ route('adopta', ['etapa' => 'adulto']) }}" class="premium-btn" style="background: {{ $etapaFiltro == 'adulto' ? 'var(--primary-adopter)' : '#fff' }}; color: {{ $etapaFiltro == 'adulto' ? '#fff' : '#64748b' }}; border: 1px solid #ddd;">Adultos</a>
    </div>

    <!-- CARDS GRID WITH SPACING -->
    <div class="premium-grid">
        @forelse($animals as $animal)
            <div class="premium-card" style="padding: 0; overflow: hidden; text-align: left;">
                <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 100%; height: 250px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="margin: 0; color: #333;">{{ $animal->Anim_nombre }}</h3>
                    <p style="color: #666; font-size: 0.9em; margin: 10px 0;">
                        {{ $animal->Anim_raza }} • {{ $animal->Anim_sexo }} <br>
                        {{ $animal->Anim_edad }}
                    </p>
                    <a href="{{ route('adopter.adoption.create', $animal->Anim_id) }}" class="premium-btn premium-btn-adopter" style="width: 100%; justify-content: center;">¡Quiero Adoptarlo! ❤️</a>
                </div>
            </div>
        @empty
            <p style="grid-column: 1/-1; padding: 50px; color: #999;">No hay peluditos disponibles por ahora 🐾</p>
        @endforelse
    </div>
</section>
@endsection
