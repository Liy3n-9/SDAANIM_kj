@extends('layouts.admin.app')

@section('title', 'Solicitudes de Adopción | SDAANIM')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <h2>Solicitudes de Adopción Recibidas</h2>
    
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

<div class="premium-card">
    <h3 style="margin-bottom: 25px; color: #1e293b;">Bandeja de Entrada: Solicitudes</h3>
    <div style="overflow-x: auto;">
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Fecha Solicitud</th>
                    <th>Adoptante</th>
                    <th>Animal</th>
                    <th>Estado</th>
                    <th>Voluntario</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td style="font-size: 0.9em; color: #64748b;">{{ \Carbon\Carbon::parse($request->Soli_fecha)->format('d M, Y') }}</td>
                        <td style="font-weight: 700;">{{ $request->user->name }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="{{ asset('img/' . ($request->animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                <span>{{ $request->animal->Anim_nombre }}</span>
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST" style="display: inline;">
                                @csrf
                                <select name="estado" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 0.9em; outline: none; transition: 0.3s; width: 100%;">
                                    <option value="Pendiente" {{ $request->Soli_estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="En Entrevista" {{ $request->Soli_estado == 'En Entrevista' ? 'selected' : '' }}>Observación</option>
                                    <option value="Aprobada" {{ $request->Soli_estado == 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
                                    <option value="Rechazada" {{ $request->Soli_estado == 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
                                    <option value="No Apta" {{ $request->Soli_estado == 'No Apta' ? 'selected' : '' }}>No Apta</option>
                                </select>
                            </form>
                        </td>
                        <td style="font-size: 0.9em;">
                            @if($request->Soli_voluntario)
                                <span style="padding: 4px 8px; background: #dcfce7; color: #166534; border-radius: 6px;">{{ $request->volunteer->name ?? 'N/A' }}</span>
                            @else
                                <span style="padding: 4px 8px; background: #fee2e2; color: #991b1b; border-radius: 6px;">Sin asignar</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                @if(!$request->Soli_voluntario)
                                    <button data-request-id="{{ $request->Soli_id }}" onclick="openAssignModal(this)" class="premium-btn" style="background: #0ea5e9; color: white; padding: 6px 14px; font-size: 0.85em; border: none; border-radius: 6px; cursor: pointer;">
                                        Asignar Voluntario
                                    </button>
                                @else
                                    <span style="padding: 6px 14px; font-size: 0.85em; color: #64748b;">✓ Asignado</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal para asignar voluntario -->
<div id="assignModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; max-width: 500px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.3);">
        <h3 style="margin-bottom: 20px;">Asignar Voluntario a Solicitud</h3>
        <form id="assignForm" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Voluntario</label>
                <select name="voluntario_doc" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
                    <option value="">-- Seleccionar Voluntario --</option>
                    @foreach($volunteers as $vol)
                        <option value="{{ $vol->Usu_documento }}">👤 {{ $vol->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Fecha de Visita</label>
                <input type="date" name="Tar_fecha_limite" required style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Hora de Visita (opcional)</label>
                <input type="time" name="Tar_hora" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="premium-btn" style="flex: 1; background: #22c55e; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">Asignar</button>
                <button type="button" onclick="closeAssignModal()" class="premium-btn" style="flex: 1; background: #cbd5e1; color: #1e293b; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAssignModal(button) {
    const requestId = button.getAttribute('data-request-id');
    const form = document.getElementById('assignForm');
    form.action = `/admin/solicitudes/${requestId}/assign-volunteer`;
    document.getElementById('assignModal').style.display = 'flex';
}

function closeAssignModal() {
    document.getElementById('assignModal').style.display = 'none';
}

// Cerrar modal al hacer click fuera
document.getElementById('assignModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAssignModal();
    }
});
</script>
@endsection
