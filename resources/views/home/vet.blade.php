@extends('layouts.vet.app')

@section('title', 'Panel Veterinario')

@section('styles')
<style>
    .admin-sections { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; padding: 20px; }
    .admin-card { background: white; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(32, 178, 170, 0.1); border: 1px solid #e0fff9; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-align: center; position: relative; overflow: hidden; }
    .admin-card::before { content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: linear-gradient(90deg, #7FFFD4, #20B2AA); }
    .admin-card:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(32, 178, 170, 0.2); }
    .admin-card h3 { color: #1C9F96; font-size: 1.5em; margin: 15px 0; font-family: 'Open Sans', sans-serif; }
    .admin-card p { color: #666; font-size: 1em; line-height: 1.6; margin-bottom: 25px; }
    .admin-card a { display: inline-block; background: #20B2AA; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: 0.3s; box-shadow: 0 4px 10px rgba(32, 178, 170, 0.3); }
    .admin-card a:hover { background: #1C9F96; transform: scale(1.05); box-shadow: 0 6px 15px rgba(32, 178, 170, 0.4); }
    .admin-card .icon { font-size: 50px; background: #e0fff9; width: 90px; height: 90px; line-height: 90px; border-radius: 50%; margin: 0 auto 10px; color: #20B2AA; }
</style>
@endsection

@section('content')
<div style="text-align: center; margin-bottom: 40px;">
    <h1 style="color: #1C9F96; font-family: 'Pacifico', cursive; font-size: 2.5em;">Bienvenido, Dr. {{ Auth::user()->name }} 🐾</h1>
    <p style="color: #666;">Gestiona la salud y bienestar de nuestros rescatados hoy.</p>
</div>

<section class="admin-sections">
    <div class="admin-card">
        <div class="icon">📋</div>
        <h3>Historiales Médicos</h3>
        <p>Accede a la base de datos completa de historiales clínicos y registros de salud.</p>
        <a href="{{ route('vet.animals') }}">Gestionar Historiales</a>
    </div>
    <div class="admin-card">
        <div class="icon">💉</div>
        <h3>Mi Disponibilidad</h3>
        <p>Registra y gestiona tu horario de atención y disponibilidad médica.</p>
        <a href="{{ route('vet.availability') }}">Gestionar Horario</a>
    </div>
    <div class="admin-card">
        <div class="icon">📝</div>
        <h3>Mis Tareas</h3>
        <p>Revisa las tareas asignadas por el administrador y regístralas como completadas.</p>
        <a href="{{ route('vet.tasks') }}">Ver Tareas</a>
    </div>
    <div class="admin-card">
        <div class="icon">🔔</div>
        <h3>Notificaciones</h3>
        <p>Mantente informado sobre todas tus actividades y cambios asignados.</p>
        <a href="{{ route('notifications') }}">Ver Notificaciones</a>
    </div>
    <div class="admin-card" style="border-top: 5px solid #ffa500;">
        <div class="icon">📈</div>
        <h3>Mi Progreso</h3>
        <p>Consulta el historial y avance visual de tus labores clínicas.</p>
        <a href="{{ route('vet.progress') }}" style="background: #ffa500; box-shadow: 0 4px 10px rgba(255, 165, 0, 0.3);">Ver Mi Progreso</a>
    </div>
</section>
@endsection
