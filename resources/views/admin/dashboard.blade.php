@extends('layouts.admin.app')

<<<<<<< HEAD
@section('title', 'Panel de Control | SDAANIM')

@section('content')
<div style="padding: 30px;">
    <div class="premium-card">
        <h1 style="color: #2c3e50; margin-bottom: 5px;">¡Bienvenido de nuevo! 🐾</h1>
        <p style="color: #64748b;">Aquí tienes un resumen de la actividad en el refugio.</p>
    </div>

    <!-- ESTADÍSTICAS EN GRID -->
    <div class="premium-grid">
        <div class="premium-card" style="text-align: center; border-top: 4px solid var(--primary-admin);">
            <h3 style="font-size: 2.5em; margin: 10px 0; color: var(--primary-admin);">{{ \App\Models\Animal::count() }}</h3>
            <p style="color: #64748b; font-weight: 700; margin: 0;">Animales</p>
        </div>
        <div class="premium-card" style="text-align: center; border-top: 4px solid #f59e0b;">
            <h3 style="font-size: 2.5em; margin: 10px 0; color: #f59e0b;">{{ \App\Models\AdoptionRequest::count() }}</h3>
            <p style="color: #64748b; font-weight: 700; margin: 0;">Solicitudes</p>
        </div>
        <div class="premium-card" style="text-align: center; border-top: 4px solid #007acc;">
            <h3 style="font-size: 2.5em; margin: 10px 0; color: #007acc;">{{ \App\Models\User::count() }}</h3>
            <p style="color: #64748b; font-weight: 700; margin: 0;">Usuarios</p>
        </div>
        <div class="premium-card" style="text-align: center; border-top: 4px solid #8b5cf6;">
            <h3 style="font-size: 2.5em; margin: 10px 0; color: #8b5cf6;">{{ \App\Models\Product::count() }}</h3>
            <p style="color: #64748b; font-weight: 700; margin: 0;">Productos</p>
        </div>
    </div>

    <!-- ACCIONES PRINCIPALES -->
    <div style="margin-top: 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="premium-card">
            <h4 style="margin-top: 0; color: #2d3748;">🐾 Gestión de Animales</h4>
            <p style="color: #718096; font-size: 0.9em;">Añade nuevos rescatados y gestiona su información.</p>
            <a href="{{ route('admin.animals.index') }}" class="premium-btn premium-btn-primary" style="width: 100%; justify-content: center;">Administrar</a>
        </div>

        <div class="premium-card">
            <h4 style="margin-top: 0; color: #2d3748;">📋 Solicitudes</h4>
            <p style="color: #718096; font-size: 0.9em;">Revisa y aprueba procesos de adopción.</p>
            <a href="{{ route('admin.requests.index') }}" class="premium-btn" style="width: 100%; justify-content: center; background: #f1f5f9; color: #475569;">Ver Solicitudes</a>
        </div>

        <div class="premium-card">
            <h4 style="margin-top: 0; color: #2d3748;">👥 Usuarios</h4>
            <p style="color: #718096; font-size: 0.9em;">Gestiona cuentas y roles del sistema.</p>
            <a href="{{ route('admin.users.index') }}" class="premium-btn" style="width: 100%; justify-content: center; background: #f1f5f9; color: #475569;">Gestionar</a>
        </div>
    </div>
</div>
@endsection
=======
@section('title', 'Panel Administrador')

@section('content')

<div class="admin-sections">

    {{-- Voluntarios --}}
    <div class="admin-card">
        <div class="icon">🤝</div>
        <h3>Voluntarios</h3>
        <p>Gestiona los voluntarios postulados y asigna sus roles dentro del sistema.</p>
        <a href="{{ route('admin.users.index') }}">Gestionar Usuarios</a>
    </div>

    {{-- Gestionar Usuarios --}}
    <div class="admin-card">
        <div class="icon">🤝</div>
        <h3>Gestionar Usuarios</h3>
        <p>Gestiona los usuarios postulados y asigna sus roles dentro del sistema.</p>
        <a href="{{ route('admin.users.index') }}">Gestionar Usuarios</a>
    </div>

    {{-- Veterinarios --}}
    <div class="admin-card">
        <div class="icon">⚕️</div>
        <h3>Veterinarios</h3>
        <p>Agenda citas, revisa solicitudes y coordina las atenciones médicas de las mascotas.</p>
        <a href="#">Agendar Citas</a>
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
        <p>Revisa las inscripciones a eventos y postulaciones del refugio.</p>
        <a href="{{ route('admin.inscriptions.index') }}">Ver Inscripciones</a>
    </div>

    {{-- Solicitudes --}}
    <div class="admin-card">
        <div class="icon">📋</div>
        <h3>Solicitudes</h3>
        <p>Revisar postulaciones, asignar voluntarios y aprobar procesos.</p>
        <a href="{{ route('admin.requests.index') }}">Ver Solicitudes</a>
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
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
