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
            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 20px; border-left: 5px solid {{ $task->Tar_estado == 'Pendiente' ? '#ffc107' : '#28a745' }};">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h3 style="margin: 0; color: #2e8b57;">{{ $task->Tar_titulo }}</h3>
                        <p style="margin: 10px 0; color: #444;">{{ $task->Tar_descripcion }}</p>
                        <p style="font-size: 0.9em; color: #666; margin: 2px 0;"><strong>Asignada el:</strong> {{ $task->Tar_fecha_asignacion }}</p>
                        <p style="font-size: 0.9em; color: #666; margin: 2px 0;"><strong>Fecha Límite:</strong> {{ $task->Tar_fecha_limite }}</p>
                    </div>
                    <div>
                        <span style="padding: 5px 12px; border-radius: 20px; font-size: 0.8em; font-weight: bold; 
                            background: {{ $task->Tar_estado == 'Pendiente' ? '#fff3cd' : '#d4edda' }};
                            color: {{ $task->Tar_estado == 'Pendiente' ? '#856404' : '#155724' }};">
                            {{ $task->Tar_estado }}
                        </span>
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">

                @if($task->Tar_estado == 'Pendiente')
                    <form action="{{ route('volunteer.tasks.complete', $task->Tar_id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; margin-bottom: 5px; font-size: 0.9em; color: #555;">Comentario de cumplimiento (opcional):</label>
                            <textarea name="comentario" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-family: inherit; resize: vertical;" rows="2"></textarea>
                        </div>
                        <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s;" onmouseover="this.style.background='#218838'" onmouseout="this.style.background='#28a745'">
                            Marcar como Completada
                        </button>
                    </form>
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
