@extends('layouts.adopter.app')

@section('title', 'Mis Solicitudes | SDAANIM')

@section('content')
<div style="max-width: 1000px; margin: 30px auto; padding: 20px;">
    <h2>Mis Solicitudes de Adopción</h2>
    <p>Historial y estado actual de tus aplicaciones.</p>

    <div style="margin-top: 30px;">
        @forelse($requests as $request)
            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; align-items: center; gap: 20px;">
                <img src="{{ asset('img/' . ($request->animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover;">
                <div style="flex: 1;">
                    <h3>{{ $request->animal->Anim_nombre }}</h3>
                    <p><strong>Fecha:</strong> {{ $request->Soli_fecha }}</p>
                    <p><strong>Estado:</strong> 
                        <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.8em; font-weight: bold; 
                            background: {{ $request->Soli_estado == 'Pendiente' ? '#fff3cd' : ($request->Soli_estado == 'En Proceso' ? '#e0f7fa' : ($request->Soli_estado == 'Aprobada' ? '#d4edda' : '#f8d7da')) }};
                            color: {{ $request->Soli_estado == 'Pendiente' ? '#856404' : ($request->Soli_estado == 'En Proceso' ? '#006064' : ($request->Soli_estado == 'Aprobada' ? '#155724' : '#721c24')) }};">
                            {{ $request->Soli_estado }}
                        </span>
                    </p>
                </div>
                <a href="javascript:void(0);" onclick="abrirModal('{{ $request->animal->Anim_nombre }}', '{{ $request->animal->Anim_edad }}', '{{ $request->animal->Anim_raza }}', '{{ $request->animal->Anim_historia ?? 'Sin historia disponible' }}', '{{ asset('img/' . ($request->animal->Anim_foto ?? 'placeholder.jpg')) }}')" style="text-decoration: none; color: #007bff; font-weight: bold;">Ver Detalles</a>
            </div>
        @empty
            <p>Aún no has enviado ninguna solicitud 🐾</p>
        @endforelse
    </div>
</div>

@include('partials.animal_modal')
@endsection
