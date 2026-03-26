@extends('layouts.volunteer.app')

@section('title', 'Mis Tareas | SDAANIM')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">
    <h2>Mis Tareas Asignadas</h2>
    <p>Lista de actividades pendientes para el refugio.</p>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-top: 20px;">
        @forelse($tasks as $task)
            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; border-left: 5px solid {{ match($task->Tar_estado) { 'Pendiente' => '#ffc107', 'Observación' => '#17a2b8', 'En Proceso' => '#fd7e14', 'Completado' => '#28a745' } }};">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h3 style="margin: 0; color: #2e8b57;">{{ $task->Tar_titulo }}</h3>
                        <p style="margin: 10px 0; color: #444;">{{ $task->Tar_descripcion }}</p>
                        <p style="font-size: 0.9em; color: #666; margin: 2px 0;"><strong>Base:</strong> {{ $task->Tar_base ?? 'Centro Principal' }}</p>
                        <p style="font-size: 0.9em; color: #666; margin: 2px 0;"><strong>Asignada el:</strong> {{ $task->Tar_fecha_asignacion->format('d/m/Y') }}</p>
                        <p style="font-size: 0.9em; color: #666; margin: 2px 0;"><strong>Fecha de visita:</strong> {{ $task->Tar_fecha_limite->format('d/m/Y') }}@if($task->Tar_hora) a las {{ $task->Tar_hora }}@endif</p>
                    </div>
                    <div>
                        <span style="padding: 5px 12px; border-radius: 20px; font-size: 0.8em; font-weight: bold; 
                            background: {{ match($task->Tar_estado) { 'Pendiente' => '#fff3cd', 'Observación' => '#d1ecf1', 'En Proceso' => '#ffeaa7', 'Completado' => '#d4edda' } }};
                            color: {{ match($task->Tar_estado) { 'Pendiente' => '#856404', 'Observación' => '#0c5460', 'En Proceso' => '#d68910', 'Completado' => '#155724' } }};">
                            {{ $task->Tar_estado }}
                        </span>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">

                @if($task->Tar_estado == 'Pendiente')
                    <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 15px;">
                        <form action="{{ route('volunteer.tasks.updateStatus', $task->Tar_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="Tar_estado" value="Observación">
                            <button type="submit" style="background: #17a2b8; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9em; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#138496'" onmouseout="this.style.background='#17a2b8'">
                                Marcar en Observación
                            </button>
                        </form>
                        <form action="{{ route('volunteer.tasks.updateStatus', $task->Tar_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="Tar_estado" value="En Proceso">
                            <button type="submit" style="background: #fd7e14; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9em; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#e17a0c'" onmouseout="this.style.background='#fd7e14'">
                                Marcar en Proceso
                            </button>
                        </form>
                        <form action="{{ route('volunteer.tasks.complete', $task->Tar_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="comentario" value="">
                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9em; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                                Marcar como Completado
                            </button>
                        </form>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <label style="display: block; margin-bottom: 5px; font-size: 0.9em; color: #555;">Comentario de cumplimiento (opcional):</label>
                        <form action="{{ route('volunteer.tasks.complete', $task->Tar_id) }}" method="POST">
                            @csrf
                            <div style="display: flex; gap: 10px;">
                                <textarea name="comentario" style="flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-family: inherit; resize: vertical;" rows="2" placeholder="Describe lo que hiciste..."></textarea>
                                <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; align-self: center;" onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                                    Enviar
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif($task->Tar_estado != 'Completado')
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        @if($task->Tar_estado == 'Observación')
                            <form action="{{ route('volunteer.tasks.updateStatus', $task->Tar_id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="Tar_estado" value="En Proceso">
                                <button type="submit" style="background: #fd7e14; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9em; cursor: pointer;">
                                    Marcar en Proceso
                                </button>
                            </form>
                        @endif
                        <form action="{{ route('volunteer.tasks.complete', $task->Tar_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="comentario" value="">
                            <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-size: 0.9em; cursor: pointer;">
                                Marcar como Completado
                            </button>
                        </form>
                    </div>
                @elseif($task->Tar_comentario)
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eef0f2;">
                        <p style="margin: 0; font-size: 0.9em; color: #666;"><strong>Tu comentario:</strong> {{ $task->Tar_comentario }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div style="text-align: center; padding: 40px; background: #fff; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                <p style="font-size: 1.2em; color: #666;">No tienes tareas asignadas por el momento. ¡Buen trabajo! 🐾</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
