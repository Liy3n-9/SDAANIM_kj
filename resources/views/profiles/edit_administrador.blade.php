@extends('layouts.admin.app')

@section('title', 'Editar Perfil Administrador | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h2>Mi Perfil de Administrador</h2>
    <p>Actualiza tus datos de acceso y contacto.</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Nombre Completo</label>
                <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Correo Electrónico</label>
                <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Teléfono</label>
                <input type="text" name="Usu_telefono" value="{{ $user->Usu_telefono }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Dirección</label>
                <input type="text" name="Usu_direccion" value="{{ $user->Usu_direccion }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Nueva Contraseña (dejar en blanco para no cambiar)</label>
                <input type="password" name="password" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <button type="submit" style="background: #2e8b57; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%;">Actualizar Perfil ✅</button>
        </div>
    </form>
</div>
@endsection
