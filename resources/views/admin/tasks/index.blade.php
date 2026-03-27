@extends('layouts.admin.app')

@section('title', 'Tareas | SDAANIM')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <h2>Tareas Asignadas</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Tarea</th>
                    <th>Asignada a</th>
                    <th>Fecha límite</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->description ?? 'Sin descripción' }}</td>
                        <td>{{ $task->volunteer->name ?? 'Sin asignar' }}</td>
                        <td>{{ $task->Tar_fecha_limite ?? '-' }}</td>
                        <td>{{ $task->Tar_hora ?? '-' }}</td>
                        <td>
                            @if(!$task->Usu_documento)
                                <button data-task-id="{{ $task->id }}" onclick="openAssignModal(this)" class="premium-btn" style="background: #0ea5e9; color: white; padding: 6px 14px; font-size: 0.85em; border: none; border-radius: 6px; cursor: pointer;">
                                    Asignar Voluntario
                                </button>
                            @else
                                <span style="padding: 6px 14px; font-size: 0.85em; color: #64748b;">✓ Asignado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para asignar voluntario -->
<div id="assignModal" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content:center; align-items:center;">
    <div style="background: white; padding: 30px; border-radius: 12px; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 20px;">Asignar Voluntario</h3>
        <form id="assignForm" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Voluntario</label>
                <select name="voluntario_doc" required style="width: 100%; padding:12px; border-radius:10px; border:1px solid #e2e8f0;">
                    <option value="">-- Seleccionar Voluntario --</option>
                    @foreach($volunteers as $vol)
                        <option value="{{ $vol->Usu_documento }}">{{ $vol->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Fecha límite</label>
                <input type="date" name="Tar_fecha_limite" required style="width:100%; padding:12px; border-radius:10px; border:1px solid #e2e8f0;">
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Hora (opcional)</label>
                <input type="time" name="Tar_hora" style="width:100%; padding:12px; border-radius:10px; border:1px solid #e2e8f0;">
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" class="premium-btn" style="flex:1; background:#22c55e; color:white; padding:12px; border:none; border-radius:8px;">Asignar</button>
                <button type="button" onclick="closeAssignModal()" class="premium-btn" style="flex:1; background:#cbd5e1; color:#1e293b; padding:12px; border:none; border-radius:8px;">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignModal(button) {
    const taskId = button.getAttribute('data-task-id');
    const form = document.getElementById('assignForm');
    form.action = `/admin/tareas/${taskId}/assign-volunteer`;
    document.getElementById('assignModal').style.display = 'flex';
}

function closeAssignModal() {
    document.getElementById('assignModal').style.display = 'none';
}

// Cerrar modal al hacer click fuera
document.getElementById('assignModal').addEventListener('click', function(e){
    if(e.target === this) closeAssignModal();
});
</script>
@endsection