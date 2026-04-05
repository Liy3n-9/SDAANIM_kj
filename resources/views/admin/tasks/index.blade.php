@extends('layouts.admin.app')

@section('title', 'Tareas | SDAANIM')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Inicio</a>
    <h2>Gestión de Tareas</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- FORMULARIO CREAR TAREA --}}
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 30px; border-top: 4px solid #2e8b57;">
        <h3 style="margin-top: 0; color: #2e8b57;">➕ Crear Nueva Tarea</h3>
        <form action="{{ route('admin.tasks.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Asignar a</label>
                    <select name="Usu_documento" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        <option value="">-- Seleccionar Voluntario/Veterinario --</option>
                        @foreach($volunteers as $vol)
                            <option value="{{ $vol->Usu_documento }}">
                                {{ $vol->name }} ({{ $vol->role }})
                                @if(isset($availabilities[$vol->Usu_documento]))
                                    - 📅 {{ $availabilities[$vol->Usu_documento]->count() }} días disponibles
                                @else
                                    - ⚠️ Sin disponibilidad registrada
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Título de la tarea</label>
                    <input type="text" name="Tar_titulo" required placeholder="Ej: Alimentar animales sector A" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Fecha límite</label>
                    <input type="date" name="Tar_fecha_limite" required min="{{ date('Y-m-d') }}" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Hora (opcional)</label>
                    <input type="time" name="Tar_hora" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Base / Sede (opcional)</label>
                    <input type="text" name="Tar_base" placeholder="Ej: Sede Norte" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                </div>
                <div style="grid-column: 1 / -1;">
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Descripción</label>
                    <textarea name="Tar_descripcion" rows="2" placeholder="Detalle de la tarea..." style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;"></textarea>
                </div>
            </div>
            <button type="submit" style="margin-top:15px; background: linear-gradient(90deg, #2e8b57, #4caf50); color:white; padding:12px 30px; border:none; border-radius:8px; font-weight:bold; cursor:pointer; font-size:1em;">
                Crear Tarea
            </button>
        </form>
    </div>

    {{-- DISPONIBILIDAD DE VOLUNTARIOS/VETERINARIOS --}}
    @if($volunteers->count() > 0)
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 30px; border-top: 4px solid #0ea5e9;">
        <h3 style="margin-top: 0; color: #0ea5e9;">📅 Disponibilidad de Voluntarios y Veterinarios</h3>
        <div style="overflow-x: auto;">
            <table class="premium-table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th style="padding:12px; text-align:left;">Nombre</th>
                        <th style="padding:12px; text-align:left;">Rol</th>
                        <th style="padding:12px; text-align:left;">Próximos Días Disponibles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($volunteers as $vol)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding:12px; font-weight:700;">{{ $vol->name }}</td>
                            <td style="padding:12px;">
                                <span style="padding: 3px 10px; border-radius: 10px; font-size: 0.85em; font-weight: 600; background: {{ $vol->role == 'Veterinario' ? '#e0f2fe' : '#f0fdf4' }}; color: {{ $vol->role == 'Veterinario' ? '#075985' : '#166534' }};">
                                    {{ $vol->role }}
                                </span>
                            </td>
                            <td style="padding:12px;">
                                @if(isset($availabilities[$vol->Usu_documento]) && $availabilities[$vol->Usu_documento]->count() > 0)
                                    @foreach($availabilities[$vol->Usu_documento]->take(5) as $ava)
                                        <span style="display:inline-block; background:#e0f2fe; color:#075985; padding:3px 8px; border-radius:6px; font-size:0.8em; margin:2px;">
                                            {{ \Carbon\Carbon::parse($ava->Ava_date)->format('d/m') }}
                                            ({{ \Carbon\Carbon::parse($ava->Ava_start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($ava->Ava_end_time)->format('H:i') }})
                                        </span>
                                    @endforeach
                                    @if($availabilities[$vol->Usu_documento]->count() > 5)
                                        <span style="font-size:0.8em; color:#64748b;">+{{ $availabilities[$vol->Usu_documento]->count() - 5 }} más</span>
                                    @endif
                                @else
                                    <span style="color:#94a3b8; font-size:0.85em;">Sin disponibilidad registrada</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- TABLA DE TAREAS EXISTENTES --}}
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h3 style="margin-top: 0; color: #1e293b;">📋 Tareas Existentes</h3>
        <div style="overflow-x: auto;">
            <table class="premium-table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th style="padding:12px; text-align:left;">Tarea</th>
                        <th style="padding:12px; text-align:left;">Asignada a</th>
                        <th style="padding:12px; text-align:left;">Estado</th>
                        <th style="padding:12px; text-align:left;">Fecha límite</th>
                        <th style="padding:12px; text-align:left;">Hora</th>
                        <th style="padding:12px; text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding:12px;">
                                <strong>{{ $task->Tar_titulo }}</strong><br>
                                <small style="color:#64748b;">{{ Str::limit($task->Tar_descripcion, 60) ?? 'Sin descripción' }}</small>
                            </td>
                            <td style="padding:12px; font-weight:600;">{{ $task->user->name ?? 'Sin asignar' }}</td>
                            <td style="padding:12px;">
                                @php
                                    $estadoColors = [
                                        'Pendiente' => ['bg' => '#fff3cd', 'text' => '#856404'],
                                        'Observación' => ['bg' => '#d1ecf1', 'text' => '#0c5460'],
                                        'En Proceso' => ['bg' => '#ffeaa7', 'text' => '#d68910'],
                                        'Completada' => ['bg' => '#d4edda', 'text' => '#155724'],
                                    ];
                                    $c = $estadoColors[$task->Tar_estado] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                                @endphp
                                <span style="padding:4px 10px; border-radius:10px; font-size:0.8em; font-weight:bold; background:{{ $c['bg'] }}; color:{{ $c['text'] }};">
                                    {{ $task->Tar_estado }}
                                </span>
                            </td>
                            <td style="padding:12px; font-size:0.9em;">{{ $task->Tar_fecha_limite ? $task->Tar_fecha_limite->format('d/m/Y') : '-' }}</td>
                            <td style="padding:12px; font-size:0.9em;">{{ $task->Tar_hora ?? '-' }}</td>
                            <td style="padding:12px; text-align:center;">
                                @if(!$task->Usu_documento)
                                    <button data-task-id="{{ $task->Tar_id }}" onclick="openAssignModal(this)" style="background: #0ea5e9; color: white; padding: 6px 14px; font-size: 0.85em; border: none; border-radius: 6px; cursor: pointer;">
                                        Asignar
                                    </button>
                                @else
                                    <span style="padding: 6px 14px; font-size: 0.85em; color: #64748b;">✓ Asignado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:30px; text-align:center; color:#666;">No hay tareas creadas aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para reasignar voluntario/veterinario -->
<div id="assignModal" style="display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content:center; align-items:center;">
    <div style="background: white; padding: 30px; border-radius: 12px; max-width: 500px; width: 90%;">
        <h3 style="margin-bottom: 20px;">Asignar Voluntario/Veterinario</h3>
        <form id="assignForm" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display:block; margin-bottom:8px; font-weight:700;">Voluntario/Veterinario</label>
                <select name="voluntario_doc" required style="width: 100%; padding:12px; border-radius:10px; border:1px solid #e2e8f0;">
                    <option value="">-- Seleccionar --</option>
                    @foreach($volunteers as $vol)
                        <option value="{{ $vol->Usu_documento }}">{{ $vol->name }} ({{ $vol->role }})</option>
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
                <button type="submit" style="flex:1; background:#22c55e; color:white; padding:12px; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">Asignar</button>
                <button type="button" onclick="closeAssignModal()" style="flex:1; background:#cbd5e1; color:#1e293b; padding:12px; border:none; border-radius:8px; cursor:pointer;">Cancelar</button>
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

document.getElementById('assignModal').addEventListener('click', function(e){
    if(e.target === this) closeAssignModal();
});
</script>
@endsection