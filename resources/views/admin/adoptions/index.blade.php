@extends('layouts.admin.app')

@section('title', 'Solicitudes de Adopción | SDAANIM')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Inicio</a>
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
                    <th>Reporte</th>
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
                            <span style="padding: 4px 8px; background: {{ $request->Soli_estado == 'Pendiente' ? '#fef3c7' : ($request->Soli_estado == 'En Revisión' ? '#dbeafe' : ($request->Soli_estado == 'Aceptada' ? '#dcfce7' : '#fee2e2')) }}; color: {{ $request->Soli_estado == 'Pendiente' ? '#92400e' : ($request->Soli_estado == 'En Revisión' ? '#1e40af' : ($request->Soli_estado == 'Aceptada' ? '#166534' : '#991b1b')) }}; border-radius: 6px;">{{ $request->Soli_estado }}</span>
                        </td>
                        <td style="font-size: 0.9em;">
                            @if($request->Soli_voluntario)
                                <span style="padding: 4px 8px; background: #dcfce7; color: #166534; border-radius: 6px;">{{ $request->volunteer->name ?? 'N/A' }}</span>
                            @else
                                <span style="padding: 4px 8px; background: #fee2e2; color: #991b1b; border-radius: 6px;">Sin asignar</span>
                            @endif
                        </td>
                        <td style="font-size: 0.9em;">
                            @if($request->reporte_voluntario)
                                <span style="color: green;">✓ Enviado</span>
                            @else
                                <span style="color: gray;">Pendiente</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center; flex-wrap: wrap;">
                                @if($request->reporte_voluntario && $request->Soli_estado == 'En Revisión')
                                    <button
                                        type="button"
                                        data-request-id="{{ $request->Soli_id }}"
                                        data-report="{{ e($request->reporte_voluntario) }}"
                                        data-apto="{{ $request->apto ? 'Sí' : 'No' }}"
                                        data-volunteer="{{ $request->volunteer->name ?? 'Voluntario' }}"
                                        data-visit="{{ $request->visita_fecha ? \Carbon\Carbon::parse($request->visita_fecha)->format('d/m/Y') : 'No programada' }}"
                                        onclick="openReportModal(this)"
                                        class="premium-btn"
                                        style="background: #0c6dfd; color: white; padding: 6px 14px; font-size: 0.85em; border: none; border-radius: 6px; cursor: pointer;"
                                    >
                                        Ver Reporte
                                    </button>
                                @elseif(!$request->Soli_voluntario)
                                    <button data-request-id="{{ $request->Soli_id }}" onclick="openAssignModal(this)" class="premium-btn" style="background: #0ea5e9; color: white; padding: 6px 14px; font-size: 0.85em; border: none; border-radius: 6px; cursor: pointer;">
                                        Asignar Voluntario
                                    </button>
                                @elseif($request->Soli_estado == 'En Revisión')
                                    <span style="padding: 6px 14px; font-size: 0.85em; color: #64748b;">Esperando reporte</span>
                                @else
                                    <span style="padding: 6px 14px; font-size: 0.85em; color: #64748b;">Finalizada</span>
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

<!-- Modal para ver reporte de voluntario -->
<div id="reportModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.55); z-index: 1001; justify-content: center; align-items: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; max-width: 560px; width: 92%; box-shadow: 0 10px 40px rgba(0,0,0,0.3); position: relative;">
        <button onclick="closeReportModal()" style="position:absolute; top: 18px; right: 18px; background: transparent; border: none; font-size: 1.3em; cursor: pointer; color: #64748b;">×</button>
        <h3 style="margin-bottom: 18px;">Reporte de Visita de Adopción</h3>
        <div style="margin-bottom: 15px;">
            <p><strong>Voluntario:</strong> <span id="reportVolunteer"></span></p>
            <p><strong>Fecha de visita:</strong> <span id="reportVisit"></span></p>
            <p><strong>Apto:</strong> <span id="reportApto"></span></p>
        </div>
        <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-bottom: 20px; min-height: 140px; white-space: pre-wrap;">
            <strong>Descripción del reporte:</strong>
            <p id="reportText" style="margin-top: 10px; line-height: 1.5; color: #334155;"></p>
        </div>
        <form id="reportDecisionForm" method="POST" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
            @csrf
            <button type="submit" name="decision" value="Aceptada" class="premium-btn" style="background: #22c55e; color: white; padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">Aceptar</button>
            <button type="submit" name="decision" value="Rechazada" class="premium-btn" style="background: #ef4444; color: white; padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">Rechazar</button>
            <button type="button" onclick="closeReportModal()" class="premium-btn" style="background: #e2e8f0; color: #1e293b; padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer;">Cerrar</button>
        </form>
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
                <select name="Usu_documento" required>
                    <option value="">-- Seleccionar Voluntario --</option>
                    @foreach($volunteers as $vol)
                        <option value="{{ $vol->Usu_documento }}">👤 {{ $vol->name }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700;">Fecha de Visita</label>
                <input type="date" name="visita_fecha" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; outline: none;">
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

function openReportModal(button) {
    const requestId = button.getAttribute('data-request-id');
    const report = button.getAttribute('data-report');
    const apto = button.getAttribute('data-apto');
    const volunteer = button.getAttribute('data-volunteer');
    const visit = button.getAttribute('data-visit');
    document.getElementById('reportVolunteer').textContent = volunteer;
    document.getElementById('reportVisit').textContent = visit;
    document.getElementById('reportApto').textContent = apto;
    document.getElementById('reportText').textContent = report;
    const form = document.getElementById('reportDecisionForm');
    form.action = `/admin/solicitudes/${requestId}/decide`;
    document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}

// Cerrar modal al hacer click fuera
document.getElementById('assignModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAssignModal();
    }
});
document.getElementById('reportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReportModal();
    }
});
</script>
@endsection
