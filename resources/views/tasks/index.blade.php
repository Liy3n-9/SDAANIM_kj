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

<div style="margin-top: 30px;">
    @forelse($tasks as $task)
        <div class="premium-card" style="margin-bottom: 25px; border-left: 8px solid {{ $task->Tar_estado == 'Pendiente' ? '#f59e0b' : '#10b981' }};">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h3 style="margin: 0; color: #1e293b; font-size: 1.4em;">{{ $task->Tar_titulo }}</h3>
                    <p style="margin: 15px 0; color: #475569; line-height: 1.6;">{{ $task->Tar_descripcion }}</p>
                    <div style="display: flex; gap: 20px; font-size: 0.85em; color: #64748b; font-weight: 600;">
                        <span>📅 Límite: {{ \Carbon\Carbon::parse($task->Tar_fecha_limite)->format('d/m/Y') }}</span>
                        <span>⏱️ Asignada: {{ \Carbon\Carbon::parse($task->Tar_fecha_asignacion)->diffForHumans() }}</span>
                    </div>
                </div>
                <span class="premium-btn" style="background: {{ $task->Tar_estado == 'Pendiente' ? '#fef3c7' : '#dcfce7' }}; color: {{ $task->Tar_estado == 'Pendiente' ? '#92400e' : '#166534' }}; padding: 6px 15px; font-size: 0.8em; border-radius: 20px;">
                    {{ $task->Tar_estado }}
                </span>
            </div>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px dashed #e2e8f0;">
                @if($task->Tar_estado == 'Pendiente')
                    <form action="{{ route('volunteer.tasks.complete', $task->Tar_id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Reporte de cumplimiento (Opcional)</label>
                            <textarea name="comentario" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: #f8fafc;" rows="2" placeholder="Describe brevemente cómo finalizaste la tarea..."></textarea>
                        </div>
                        <button type="submit" class="premium-btn premium-btn-volunteer" style="width: 100%; justify-content: center; padding: 12px;">Finalizar Tarea Ahora ✅</button>
                    </form>
                @elseif($task->Tar_comentario)
                    <div style="background: #f0fdf4; padding: 15px; border-radius: 12px; border-left: 4px solid #10b981;">
                        <p style="margin: 0; font-size: 0.9em; color: #166534;"><strong>Tu reporte:</strong> {{ $task->Tar_comentario }}</p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="premium-card" style="text-align: center; padding: 50px;">
            <span style="font-size: 3em;">🎉</span>
            <h3 style="color: #64748b; margin-top: 20px;">¡Todo al día! No tienes tareas pendientes.</h3>
        </div>
    @endforelse
</div>
</div>
@endsection
