@extends('layouts.adopter.app')

@section('title', 'Mi Perfil | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 30px auto; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eee;">
    <h2 style="color: #2d7d46; font-family: 'Pacifico', cursive; margin-bottom: 10px;">Hola, {{ $user->name }} 👋</h2>
    <p style="color: #666;">Mantén tus datos actualizados para tus solicitudes de adopción.</p>
    <hr style="border: 0; border-top: 2px solid #f1f1f1; margin: 25px 0;">

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 600;">Nombre Completo</label>
                <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 600;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 600;">Teléfono / Celular</label>
                <input type="text" name="Usu_telefono" value="{{ $user->Usu_telefono }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 600;">Dirección de Envío/Visitas</label>
                <input type="text" name="Usu_direccion" value="{{ $user->Usu_direccion }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 600;">Nueva Contraseña</label>
                <input type="password" name="password" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 600;">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; outline: none;">
            </div>
        </div>
        
        <div style="margin-top: 35px;">
            <button type="submit" style="background: #2d7d46; color: white; border: none; padding: 15px 30px; border-radius: 12px; font-weight: bold; cursor: pointer; width: 100%; font-size: 1.1em; transition: 0.3s; box-shadow: 0 5px 15px rgba(45, 125, 70, 0.2);">Guardar Cambios 🐾</button>
        </div>
    </form>
</div>
@endsection
