@extends('layouts.admin.app')

@section('title', 'Panel Administrador')

@section('content')

<div class="admin-sections">

    {{-- Gestionar Usuarios --}}
    <div class="admin-card">
        <div class="icon">👥</div>
        <h3>Gestionar Usuarios</h3>
        <p>Administra los roles y estados de los usuarios registrados en el sistema.</p>
        <a href="{{ route('admin.users.index') }}">Gestionar Usuarios</a>
    </div>

    {{-- Tareas --}}
    <div class="admin-card">
        <div class="icon">📝</div>
        <h3>Tareas</h3>
        <p>Crea y asigna tareas a voluntarios y veterinarios según su disponibilidad.</p>
        <a href="{{ route('admin.tasks.index') }}">Gestionar Tareas</a>
    </div>

    {{-- Adopciones --}}
    <div class="admin-card">
        <div class="icon">🐶</div>
        <h3>Adopciones</h3>
        <p>Gestiona animales en adopción y agrega nuevas fotos o perfiles para adopción.</p>
        <a href="{{ route('admin.animals.index') }}">Gestionar Animales</a>
    </div>

    {{-- Productos --}}
    <div class="admin-card">
        <div class="icon">🛒</div>
        <h3>Productos</h3>
        <p>Gestiona los productos disponibles y administra su información.</p>
        <a href="{{ route('admin.products.index') }}">Gestionar Productos</a>
    </div>

    {{-- Inscripciones --}}
    <div class="admin-card">
        <div class="icon">📊</div>
        <h3>Inscripciones</h3>
        <p>Revisa las inscripciones de voluntarios y veterinarios postulados.</p>
        <a href="{{ route('admin.inscriptions.index') }}">Ver Inscripciones</a>
    </div>

    {{-- Solicitudes --}}
    <div class="admin-card">
        <div class="icon">📋</div>
        <h3>Solicitudes</h3>
        <p>Revisar postulaciones, asignar voluntarios y aprobar procesos.</p>
        <a href="{{ route('admin.requests.index') }}">Ver Solicitudes</a>
    </div>

    {{-- Progreso de Actividades (NUEVO) --}}
    <div class="admin-card" style="border-top: 4px solid #f59e0b;">
        <div class="icon">📈</div>
        <h3>Progreso de Actividades</h3>
        <p>Supervisa el avance real, fases y comentarios de las tareas de voluntarios.</p>
        <a href="{{ route('admin.activities') }}" style="background: linear-gradient(90deg, #f59e0b, #d97706);">Ver Progreso</a>
    </div>

</div>

<style>
/* Contenedor */
.admin-sections {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

/* Tarjetas */
.admin-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    border: 1px solid #eef2f5;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

/* Hover tarjeta */
.admin-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Icono */
.admin-card .icon {
    font-size: 40px;
    color: #4caf50;
    margin-bottom: 10px;
}

/* Título */
.admin-card h3 {
    color: #2e8b57;
    font-size: 1.4em;
    margin-bottom: 10px;
}

/* Texto */
.admin-card p {
    color: #555;
    font-size: 0.95em;
    margin-bottom: 20px;
}

/* Botón */
.admin-card a {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
    color: #fff;
    background: linear-gradient(90deg, #2e8b57, #4caf50);
    transition: 0.3s;
}

/* Hover botón */
.admin-card a:hover {
    background: linear-gradient(90deg, #256d45, #3e9e42);
}
</style>

@endsection