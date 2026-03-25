@extends('layouts.vet.app')

@section('title', 'Perfil Veterinario | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 30px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(32, 178, 170, 0.1); border: 1px solid #e0fff9;">
    <h2 style="color: #1C9F96; font-family: 'Pacifico', cursive;">Perfil del Dr. {{ $user->name }}</h2>
    <p>Gestiona tu información profesional y personal.</p>
    <hr style="border: 0; border-top: 1px solid #e0fff9; margin: 20px 0;">

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #1C9F96;">Nombre Clínico</label>
                <input type="text" name="name" value="{{ $user->name }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #20B2AA;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #1C9F96;">Email Profesional</label>
                <input type="email" name="email" value="{{ $user->email }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #20B2AA;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #1C9F96;">Teléfono de Contacto</label>
                <input type="text" name="Usu_telefono" value="{{ $user->Usu_telefono }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #20B2AA;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #1C9F96;">Consultorio / Dirección</label>
                <input type="text" name="Usu_direccion" value="{{ $user->Usu_direccion }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #20B2AA;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #1C9F96;">Cambiar Contraseña</label>
                <input type="password" name="password" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #20B2AA;">
            </div>
            <div>
                <label style="display:block; margin-bottom: 5px; font-weight: bold; color: #1C9F96;">Confirmar Nueva</label>
                <input type="password" name="password_confirmation" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #20B2AA;">
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <button type="submit" style="background: linear-gradient(90deg, #7FFFD4, #20B2AA); color: #333; border: none; padding: 15px 25px; border-radius: 50px; font-weight: bold; cursor: pointer; width: 100%; box-shadow: 0 4px 15px rgba(32, 178, 170, 0.3);">Guardar Cambios Profesionales 🩺</button>
        </div>
    </form>
</div>
@endsection
