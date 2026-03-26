@extends('layouts.admin.app')

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
