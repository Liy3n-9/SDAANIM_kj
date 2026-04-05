@php
    $layout = Auth::user()->role == 'Veterinario' ? 'layouts.vet.app' : 'layouts.volunteer.app';
@endphp

@extends($layout)

@section('title', 'Mis Tareas | SDAANIM')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">

    <h2>Mis Tareas Asignadas</h2>
    <p>Lista de actividades pendientes para el refugio.</p>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-top: 20px;">
        @forelse($tasks as $task)

            @php
                $estado = $task->Tar_estado;
                $routePrefix = Auth::user()->role == 'Veterinario' ? 'vet' : 'volunteer';

                $colores = [
                    'Pendiente' => ['bg' => '#fff3cd', 'text' => '#856404', 'border' => '#ffc107'],
                    'Observación' => ['bg' => '#d1ecf1', 'text' => '#0c5460', 'border' => '#17a2b8'],
                    'En Proceso' => ['bg' => '#ffeaa7', 'text' => '#d68910', 'border' => '#fd7e14'],
                    'Completada' => ['bg' => '#d4edda', 'text' => '#155724', 'border' => '#28a745'],
                ];
            @endphp

            <div style="
                background: white;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                margin-bottom: 20px;
                border-left: 5px solid {{ $colores[$estado]['border'] ?? '#ccc' }};
            ">

                <div style="display: flex; justify-content: space-between; align-items: flex-start;">

                    {{-- Info --}}
                    <div>
                        <h3 style="margin: 0; color: #2e8b57;">{{ $task->Tar_titulo }}</h3>
                        <p style="margin: 10px 0; color: #444;">{{ $task->Tar_descripcion }}</p>

                        <p><strong>Base:</strong> {{ $task->Tar_base ?? 'Centro Principal' }}</p>
                        <p><strong>Asignada el:</strong> {{ $task->Tar_fecha_asignacion ? $task->Tar_fecha_asignacion->format('d/m/Y') : '-' }}</p>
                        <p>
                            <strong>Fecha de visita:</strong>
                            {{ $task->Tar_fecha_limite ? $task->Tar_fecha_limite->format('d/m/Y') : '-' }}
                            @if($task->Tar_hora) a las {{ $task->Tar_hora }} @endif
                        </p>
                    </div>

                    {{-- Estado --}}
                    <span style="
                        padding: 5px 12px;
                        border-radius: 20px;
                        font-size: 0.8em;
                        font-weight: bold;
                        background: {{ $colores[$estado]['bg'] ?? '#f1f5f9' }};
                        color: {{ $colores[$estado]['text'] ?? '#475569' }};
                    ">
                        {{ $estado }}
                    </span>
                </div>

                <hr style="margin: 15px 0;">

                {{-- ACCIONES --}}
                @if($estado !== 'Completada')

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">

                        {{-- Cambiar a Observación --}}
                        @if($estado == 'Pendiente')
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="Observación">
                                <button style="background:#17a2b8;color:#fff;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;">
                                    Observación
                                </button>
                            </form>
                        @endif

                        {{-- Cambiar a En Proceso --}}
                        @if($estado == 'Pendiente' || $estado == 'Observación')
                            <form action="{{ route($routePrefix . '.tasks.updateStatus', $task->Tar_id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="Tar_estado" value="En Proceso">
                                <button style="background:#fd7e14;color:#fff;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;">
                                    En Proceso
                                </button>
                            </form>
                        @endif

                        {{-- Completar --}}
                        <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST">
                            @csrf
                            <button style="background:#28a745;color:#fff;padding:8px 16px;border:none;border-radius:6px;cursor:pointer;">
                                Completar
                            </button>
                        </form>
                    </div>

                    {{-- Comentario --}}
                    <form action="{{ route($routePrefix . '.tasks.complete', $task->Tar_id) }}" method="POST">
                        @csrf
                        <label style="font-size:0.9em;">Comentario (opcional)</label>
                        <div style="display:flex; gap:10px;">
                            <textarea name="comentario" rows="2" style="flex:1; padding:10px; border-radius:8px; border:1px solid #ddd;">{{ $task->Tar_comentario }}</textarea>
                            <button style="background:#28a745;color:#fff;padding:10px 20px;border:none;border-radius:8px;cursor:pointer;">
                                Enviar
                            </button>
                        </div>
                    </form>

                @else
                    {{-- Comentario final --}}
                    @if($task->Tar_comentario)
                        <div style="background:#f8f9fa;padding:15px;border-radius:8px;">
                            <strong>Comentario:</strong> {{ $task->Tar_comentario }}
                        </div>
                    @endif
                @endif

            </div>

        @empty
            <div style="text-align:center;padding:40px;">
                <p>No tienes tareas asignadas 🐾</p>
            </div>
        @endforelse

        <a href="{{ route('dashboard') }}" style="display:inline-block;margin-top:20px;background:#6c757d;color:#fff;padding:10px 20px;border-radius:6px;text-decoration:none;">
            ← Volver
        </a>

    </div>
</div>
@endsection