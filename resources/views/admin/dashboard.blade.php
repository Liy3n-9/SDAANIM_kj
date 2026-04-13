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

    {{-- Quiénes Somos --}}
    <div class="admin-card">
        <div class="icon">🏢</div>
        <h3>Quiénes Somos</h3>
        <p>Edita la historia, misión y visión para el panel de adoptantes.</p>
        <a href="{{ route('admin.about.edit') }}">Editar Historia</a>
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

@endsection