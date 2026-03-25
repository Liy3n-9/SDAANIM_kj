@extends('layouts.admin.app')

@section('title', 'Panel Administrador')

@section('content')
<div class="admin-sections" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 25px;">
    
    <div class="admin-card">
        <div class="icon" style="font-size: 40px; color: #4caf50; margin-bottom: 10px;">🤝</div>
        <h3 style="color: #2e8b57; font-size: 1.4em; margin-bottom: 10px;">Voluntarios</h3>
        <p style="color: #555; font-size: 0.95em; margin-bottom: 20px;">Gestiona los voluntarios postulados y asigna sus roles dentro del sistema.</p>
        <a href="{{ route('admin.users.index') }}" style="display: inline-block; background: linear-gradient(90deg, #2e8b57, #4caf50); color: white; padding: 10px 20px; border-radius: 6px; transition: 0.3s; font-weight: bold; text-decoration: none;">Gestionar Usuarios</a>
    </div>

    <div class="admin-card">
        <div class="icon" style="font-size: 40px; color: #4caf50; margin-bottom: 10px;">⚕️</div>
        <h3 style="color: #2e8b57; font-size: 1.4em; margin-bottom: 10px;">Veterinarios</h3>
        <p style="color: #555; font-size: 0.95em; margin-bottom: 20px;">Agenda citas, revisa solicitudes y coordina las atenciones médicas de las mascotas.</p>
        <a href="#" style="display: inline-block; background: linear-gradient(90deg, #2e8b57, #4caf50); color: white; padding: 10px 20px; border-radius: 6px; transition: 0.3s; font-weight: bold; text-decoration: none;">Agendar Citas</a>
    </div>

    <div class="admin-card">
        <div class="icon" style="font-size: 40px; color: #4caf50; margin-bottom: 10px;">🐶</div>
        <h3 style="color: #2e8b57; font-size: 1.4em; margin-bottom: 10px;">Adopciones</h3>
        <p style="color: #555; font-size: 0.95em; margin-bottom: 20px;">Gestiona animales en adopción y agrega nuevas fotos o perfiles para adopción.</p>
        <a href="{{ route('admin.animals.index') }}" style="display: inline-block; background: linear-gradient(90deg, #2e8b57, #4caf50); color: white; padding: 10px 20px; border-radius: 6px; transition: 0.3s; font-weight: bold; text-decoration: none;">Gestionar Animales</a>
    </div>

    <div class="admin-card">
        <div class="icon" style="font-size: 40px; color: #4caf50; margin-bottom: 10px;">🛒</div>
        <h3 style="color: #2e8b57; font-size: 1.4em; margin-bottom: 10px;">Productos</h3>
        <p style="color: #555; font-size: 0.95em; margin-bottom: 20px;">Gestiona los productos disponibles y administra su información.</p>
        <a href="{{ route('admin.products.index') }}" style="display: inline-block; background: linear-gradient(90deg, #2e8b57, #4caf50); color: white; padding: 10px 20px; border-radius: 6px; transition: 0.3s; font-weight: bold; text-decoration: none;">Gestionar Productos</a>
    </div>

    <div class="admin-card">
        <div class="icon" style="font-size: 40px; color: #4caf50; margin-bottom: 10px;">📊</div>
        <h3 style="color: #2e8b57; font-size: 1.4em; margin-bottom: 10px;">Inscripciones</h3>
        <p style="color: #555; font-size: 0.95em; margin-bottom: 20px;">Revisa las inscripciones a eventos y postulaciones del refugio.</p>
        <a href="{{ route('admin.inscriptions.index') }}" style="display: inline-block; background: linear-gradient(90deg, #2e8b57, #4caf50); color: white; padding: 10px 20px; border-radius: 6px; transition: 0.3s; font-weight: bold; text-decoration: none;">Ver Inscripciones</a>
    </div>

    <div class="admin-card">
        <div class="icon" style="font-size: 40px; color: #4caf50; margin-bottom: 10px;">📋</div>
        <h3 style="color: #2e8b57; font-size: 1.4em; margin-bottom: 10px;">Solicitudes</h3>
        <p style="color: #555; font-size: 0.95em; margin-bottom: 20px;">Revisar postulaciones, asignar voluntarios y aprobar procesos.</p>
        <a href="{{ route('admin.requests.index') }}" style="display: inline-block; background: linear-gradient(90deg, #2e8b57, #4caf50); color: white; padding: 10px 20px; border-radius: 6px; transition: 0.3s; font-weight: bold; text-decoration: none;">Ver Solicitudes</a>
    </div>

</div>

<style>
    .admin-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        text-align: center;
        border: 1px solid #eef2f5;
    }

    .admin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .admin-card a:hover {
        background: linear-gradient(90deg, #256d45, #3e9e42) !important;
    }
</style>
@endsection
