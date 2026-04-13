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
        <form action="{{ route('admin.tasks.store') }}" method="POST" id="taskForm">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Asignar a</label>
                    <select name="Usu_documento" id="userSelect" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        <option value="">-- Seleccionar Voluntario/Veterinario --</option>
                        @foreach($volunteers as $vol)
                            <option value="{{ $vol->Usu_documento }}" data-role="{{ $vol->role }}">
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
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Tipo de tarea</label>
                    <select name="task_type" id="taskTypeSelect" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        <option value="">-- Seleccionar tipo --</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Título de la tarea</label>
                    <input type="text" name="Tar_titulo" id="taskTitle" required placeholder="Ej: Alimentar animales sector A" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
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

                {{-- CAMPOS ESPECÍFICOS PARA VOLUNTARIOS --}}
                <div id="volunteerFields" style="display: none; grid-column: 1 / -1;">
                    <h4 style="color: #2e8b57; margin-bottom: 10px;">Detalles para Voluntario</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Sector del refugio</label>
                            <select name="sector" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                                <option value="">Seleccionar sector</option>
                                <option value="Perros">Perros</option>
                                <option value="Gatos">Gatos</option>
                                <option value="Animales pequeños">Animales pequeños</option>
                                <option value="Área de cuarentena">Área de cuarentena</option>
                                <option value="Zona de recuperación">Zona de recuperación</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Tipo de actividad</label>
                            <select name="actividad_voluntario" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                                <option value="">Seleccionar actividad</option>
                                <option value="Alimentación">Alimentación</option>
                                <option value="Limpieza de jaulas">Limpieza de jaulas</option>
                                <option value="Paseo de perros">Paseo de perros</option>
                                <option value="Socialización">Socialización</option>
                                <option value="Administración de medicamentos">Administración de medicamentos</option>
                                <option value="Limpieza general">Limpieza general</option>
                                <option value="Recepción de donaciones">Recepción de donaciones</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Número de animales</label>
                            <input type="number" name="num_animales" min="1" placeholder="Ej: 5" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Duración estimada (horas)</label>
                            <input type="number" name="duracion_horas" min="0.5" step="0.5" placeholder="Ej: 2.5" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                    </div>
                </div>

                {{-- CAMPOS ESPECÍFICOS PARA VETERINARIOS --}}
                <div id="vetFields" style="display: none; grid-column: 1 / -1;">
                    <h4 style="color: #d32f2f; margin-bottom: 10px;">Detalles para Veterinario</h4>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Tipo de atención</label>
                            <select name="tipo_atencion" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                                <option value="">Seleccionar tipo</option>
                                <option value="Consulta general">Consulta general</option>
                                <option value="Vacunación">Vacunación</option>
                                <option value="Esterilización">Esterilización</option>
                                <option value="Cirugía">Cirugía</option>
                                <option value="Tratamiento">Tratamiento</option>
                                <option value="Urgencia">Urgencia</option>
                                <option value="Control post-operatorio">Control post-operatorio</option>
                            </select>
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Animal específico (opcional)</label>
                            <input type="text" name="animal_especifico" placeholder="Nombre o ID del animal" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Equipamiento necesario</label>
                            <input type="text" name="equipamiento" placeholder="Ej: anestesia, instrumental quirúrgico" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                        </div>
                        <div>
                            <label style="display:block; margin-bottom:5px; font-weight:700;">Prioridad</label>
                            <select name="prioridad" style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;">
                                <option value="Normal">Normal</option>
                                <option value="Alta">Alta</option>
                                <option value="Urgente">Urgente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="display:block; margin-bottom:5px; font-weight:700;">Descripción detallada</label>
                    <textarea name="Tar_descripcion" id="taskDescription" rows="3" placeholder="Detalle específico de la tarea..." style="width:100%; padding:10px; border-radius:8px; border:1px solid #e2e8f0;"></textarea>
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
                                        'Completado' => ['bg' => '#d4edda', 'text' => '#155724'],
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

<script>
// Definir tipos de tareas por rol
const taskTypes = {
    'Voluntario': [
        'Alimentación de animales',
        'Limpieza de jaulas',
        'Paseo de perros',
        'Socialización con animales',
        'Administración de medicamentos',
        'Limpieza general del refugio',
        'Recepción y organización de donaciones',
        'Ayuda en eventos',
        'Transporte de animales',
        'Mantenimiento de instalaciones'
    ],
    'Veterinario': [
        'Consulta veterinaria general',
        'Vacunación de animales',
        'Esterilización/castración',
        'Cirugía veterinaria',
        'Tratamiento médico',
        'Atención de urgencias',
        'Control post-operatorio',
        'Campañas de salud preventiva',
        'Diagnóstico y análisis',
        'Capacitación del personal'
    ]
};

// Función para actualizar campos basados en el usuario seleccionado
function updateTaskFields() {
    const userSelect = document.getElementById('userSelect');
    const taskTypeSelect = document.getElementById('taskTypeSelect');
    const volunteerFields = document.getElementById('volunteerFields');
    const vetFields = document.getElementById('vetFields');
    const taskTitle = document.getElementById('taskTitle');
    const taskDescription = document.getElementById('taskDescription');

    const selectedOption = userSelect.options[userSelect.selectedIndex];
    const userRole = selectedOption.getAttribute('data-role');

    // Limpiar opciones anteriores
    taskTypeSelect.innerHTML = '<option value="">-- Seleccionar tipo --</option>';

    // Ocultar todos los campos específicos
    volunteerFields.style.display = 'none';
    vetFields.style.display = 'none';

    if (userRole && taskTypes[userRole]) {
        // Agregar opciones del tipo de tarea
        taskTypes[userRole].forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = type;
            taskTypeSelect.appendChild(option);
        });

        // Mostrar campos específicos del rol
        if (userRole === 'Voluntario') {
            volunteerFields.style.display = 'block';
        } else if (userRole === 'Veterinario') {
            vetFields.style.display = 'block';
        }

        // Actualizar título y descripción sugeridos
        updateTaskSuggestions(userRole);
    }
}

// Función para actualizar sugerencias de título y descripción
function updateTaskSuggestions(role) {
    const taskTypeSelect = document.getElementById('taskTypeSelect');
    const taskTitle = document.getElementById('taskTitle');
    const taskDescription = document.getElementById('taskDescription');

    taskTypeSelect.addEventListener('change', function() {
        const selectedType = this.value;

        if (selectedType) {
            // Sugerir título basado en el tipo
            taskTitle.value = selectedType;

            // Sugerir descripción basada en el rol y tipo
            let description = '';
            if (role === 'Voluntario') {
                switch(selectedType) {
                    case 'Alimentación de animales':
                        description = 'Preparar y distribuir alimentos según el plan nutricional establecido para cada animal.';
                        break;
                    case 'Limpieza de jaulas':
                        description = 'Limpiar y desinfectar jaulas, cambiar agua y mantener el área higiénica.';
                        break;
                    case 'Paseo de perros':
                        description = 'Sacar a pasear a los perros asignados, asegurando su ejercicio y socialización.';
                        break;
                    case 'Socialización con animales':
                        description = 'Pasar tiempo con los animales para mejorar su socialización y bienestar emocional.';
                        break;
                    case 'Administración de medicamentos':
                        description = 'Administrar medicamentos según las indicaciones veterinarias.';
                        break;
                    case 'Limpieza general del refugio':
                        description = 'Realizar limpieza general de áreas comunes del refugio.';
                        break;
                    case 'Recepción y organización de donaciones':
                        description = 'Recibir donaciones y organizarlas en el almacén correspondiente.';
                        break;
                    case 'Ayuda en eventos':
                        description = 'Apoyar en la organización y ejecución de eventos del refugio.';
                        break;
                    case 'Transporte de animales':
                        description = 'Transportar animales a consultas veterinarias o adopciones.';
                        break;
                    case 'Mantenimiento de instalaciones':
                        description = 'Realizar tareas básicas de mantenimiento en las instalaciones.';
                        break;
                }
            } else if (role === 'Veterinario') {
                switch(selectedType) {
                    case 'Consulta veterinaria general':
                        description = 'Realizar consultas de rutina, exámenes físicos y diagnósticos básicos.';
                        break;
                    case 'Vacunación de animales':
                        description = 'Administrar vacunas según el calendario de vacunación establecido.';
                        break;
                    case 'Esterilización/castración':
                        description = 'Realizar procedimientos de esterilización y castración.';
                        break;
                    case 'Cirugía veterinaria':
                        description = 'Realizar cirugías programadas o de emergencia.';
                        break;
                    case 'Tratamiento médico':
                        description = 'Administrar tratamientos médicos a animales enfermos.';
                        break;
                    case 'Atención de urgencias':
                        description = 'Atender casos de emergencia veterinaria.';
                        break;
                    case 'Control post-operatorio':
                        description = 'Realizar controles y cuidados post-operatorios.';
                        break;
                    case 'Campañas de salud preventiva':
                        description = 'Realizar campañas de vacunación y chequeos preventivos.';
                        break;
                    case 'Diagnóstico y análisis':
                        description = 'Realizar diagnósticos y análisis clínicos.';
                        break;
                    case 'Capacitación del personal':
                        description = 'Capacitar al personal en temas veterinarios y de cuidado animal.';
                        break;
                }
            }

            taskDescription.value = description;
        }
    });
}

// Event listener para el cambio de usuario
document.getElementById('userSelect').addEventListener('change', updateTaskFields);

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    updateTaskFields();
});
</script>

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