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
<div class="premium-card" style="text-align: center; margin-bottom: 50px; background: linear-gradient(135deg, #ffffff, #f0fdf4); border-top: 8px solid #2d7d46;">
    <h1 style="font-family: 'Pacifico', cursive; color: #2d7d46; font-size: 3em; margin-bottom: 15px;">¡Hola, {{ Auth::user()->name }}! 🐾</h1>
    <p style="color: #64748b; font-size: 1.2em; max-width: 600px; margin: 0 auto;">Gracias por ser parte de nuestra comunidad y apoyarnos en nuestra misión de rescatar vidas.</p>
</div>

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
