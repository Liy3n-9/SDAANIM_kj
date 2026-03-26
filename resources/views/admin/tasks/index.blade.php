@extends('layouts.admin.app')

@section('title', 'Gestión de Tareas | SDAANIM')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 20px;">
    <h2>Asignación de Tareas</h2>
    
    <div class="premium-card" style="margin-bottom: 50px; border-left: 8px solid #2e8b57;">
        <h3 style="margin-bottom: 25px; color: #1e293b;">🎯 Asignar Nueva Tarea</h3>
        <form action="{{ route('admin.tasks.store') }}" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            @csrf
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Título de la Tarea</label>
                <input type="text" name="Tar_titulo" required placeholder="Ej: Alimentar perros, Limpieza patio..." style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Voluntario Responsable</label>
                <select name="Usu_documento" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none; background: white;">
                    <option value="">Seleccione un voluntario</option>
                    @foreach($volunteers as $vol)
                        <option value="{{ $vol->Usu_documento }}">👤 {{ $vol->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Fecha de la Tarea</label>
                <input type="date" name="Tar_fecha_limite" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Hora (opcional)</label>
                <input type="time" name="Tar_hora" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Base/Centro (opcional)</label>
                <input type="text" name="Tar_base" placeholder="Ej: Centro Principal, Sucursal Norte..." style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;">
            </div>
            <div style="grid-column: span 1 / span 2;">
                <label style="display: block; margin-bottom: 8px; font-weight: 700; color: #475569;">Instrucciones Detalladas</label>
                <textarea name="Tar_descripcion" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; outline: none;" rows="3"></textarea>
            </div>
            <div style="grid-column: span 1 / span 2;">
                <button type="submit" class="premium-btn premium-btn-primary" style="width: 100%; justify-content: center; padding: 15px;">Confirmar Asignación ✅</button>
            </div>
        </form>
    </div>

    <h3 style="margin-bottom: 25px; color: #334155;">📋 Historial y Seguimiento</h3>
    <div class="premium-card">
        <div style="overflow-x: auto;">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Voluntario</th>
                        <th>Tarea / Objetivo</th>
                        <th>Base</th>
                        <th>Estado Actual</th>
                        <th>Fecha / Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td style="font-weight: 700;">{{ $task->user->name }}</td>
                            <td>{{ $task->Tar_titulo }}</td>
                            <td style="color: #64748b; font-size: 0.9em;">{{ $task->Tar_base ?? 'Centro Principal' }}</td>
                            <td>
                                <span class="premium-btn" style="background: {{ match($task->Tar_estado) { 'Pendiente' => '#fef3c7', 'Observación' => '#d1ecf1', 'En Proceso' => '#ffeaa7', 'Completado' => '#dcfce7', default => '#f3f4f6' } }}; color: {{ match($task->Tar_estado) { 'Pendiente' => '#92400e', 'Observación' => '#0c5460', 'En Proceso' => '#d68910', 'Completado' => '#166534', default => '#374151' } }}; padding: 4px 12px; font-size: 0.8em; border-radius: 20px;">
                                    {{ $task->Tar_estado }}
                                </span>
                            </td>
                            <td style="color: #64748b;">{{ \Carbon\Carbon::parse($task->Tar_fecha_limite)->format('d M, Y') }}@if($task->Tar_hora) - {{ $task->Tar_hora }}@endif</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
