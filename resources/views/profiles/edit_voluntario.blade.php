@extends('layouts.volunteer.app')

@section('title', 'Perfil Voluntario | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(74, 144, 226, 0.1); border-left: 8px solid #4a90e2;">
    <h2 style="color: #007acc;">Perfil del Voluntario: {{ $user->name }}</h2>
    <p>Actualiza tu información para seguir ayudando a los animales.</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Nombre Completo</label>
                <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #4a90e2;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Correo Personal</label>
                <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #4a90e2;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">WhatsApp / Celular</label>
                <input type="text" name="Usu_telefono" value="{{ $user->Usu_telefono }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #4a90e2;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Dirección de Residencia</label>
                <input type="text" name="Usu_direccion" value="{{ $user->Usu_direccion }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #4a90e2;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Nueva Contraseña</label>
                <input type="password" name="password" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #4a90e2;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold;">Confirmar</label>
                <input type="password" name="password_confirmation" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #4a90e2;">
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <button type="submit" style="background: #007acc; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%;">Guardar Perfil de Héroe 🦸‍♂️</button>
        </div>
    </form>
</div>
@endsection
