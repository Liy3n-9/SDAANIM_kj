@extends('layouts.volunteer.app')

@section('title', 'Panel Voluntario | SDAANIM')

@section('styles')
<style>
    .admin-sections { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; padding: 20px; }
    .admin-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid #007acc; transition: all 0.3s ease; text-align: center; }
    .admin-card:hover { transform: translateY(-5px); box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
    .admin-card h3 { color: #007acc; font-size: 1.4em; margin-bottom: 10px; }
    .admin-card p { color: #555; font-size: 0.95em; margin-bottom: 20px; }
    .admin-card a { display: inline-block; background: linear-gradient(90deg, #4a90e2, #007acc); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; }
    .admin-card .icon { font-size: 40px; color: #007acc; margin-bottom: 10px; }
</style>
@endsection

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <h1 style="color: #007acc; font-family: 'Pacifico', cursive;">Bienvenido, {{ Auth::user()->name }} 🐾</h1>
    <p>Tu labor como voluntario es fundamental para nosotros.</p>
</div>

<section class="admin-sections">
    <div class="admin-card">
        <div class="icon">📝</div>
        <h3>Tareas Asignadas</h3>
        <p>Revisa tus tareas pendientes y regístralas como completadas.</p>
        <a href="{{ route('volunteer.tasks') }}">Mis Tareas</a>
    </div>
    <div class="admin-card">
        <div class="icon">📅</div>
        <h3>Mi Disponibilidad</h3>
        <p>Define los días y horas en los que puedes apoyar en el refugio.</p>
        <a href="{{ route('volunteer.availability') }}">Gestionar Horario</a>
    </div>
    <div class="admin-card">
        <div class="icon">📊</div>
        <h3>Mi Progreso</h3>
        <p>Consulta las actividades que has realizado recientemente.</p>
        <a href="{{ route('volunteer.tasks') }}">Ver Historial</a>
    </div>
</section>
@endsection
