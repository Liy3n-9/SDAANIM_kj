@extends('layouts.admin.app')

@section('title', 'Actividades de Voluntarios | SDAANIM')

@section('content')
<div style="max-width: 1400px; margin: 30px auto; padding: 20px;">
    <a href="{{ route('admin.dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Inicio</a>
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #2e8b57;">Supervisión de Actividades</h2>
        <a href="{{ route('admin.tasks.index') }}" style="background: #0ea5e9; color: white; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">📝 Ir a Gestión de Tareas (Asignar)</a>
    </div>

    {{-- FILTROS DE TAREAS --}}
    <div style="background: white; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border-left: 4px solid #f59e0b;">
        <h3 style="margin-top: 0; color: #f59e0b; font-size: 1.1em;">🔍 Filtrar Búsqueda</h3>
        <form method="GET" action="{{ route('admin.activities') }}" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label style="font-size: 0.9em; font-weight: bold; display:block; margin-bottom: 5px;">Rol Asignado</label>
                <select name="role" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc; width: 150px;">
                    <option value="">Todos</option>
                    <option value="Voluntario" {{ request('role') == 'Voluntario' ? 'selected' : '' }}>Voluntario</option>
                    <option value="Veterinario" {{ request('role') == 'Veterinario' ? 'selected' : '' }}>Veterinario</option>
                </select>
            </div>
            <div>
                <label style="font-size: 0.9em; font-weight: bold; display:block; margin-bottom: 5px;">Nombre Usuario</label>
                <select name="volunteer_id" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc; width: 220px;">
                    <option value="">Cualquiera</option>
                    @foreach($assignees as $assignee)
                        <option value="{{ $assignee->Usu_documento }}" {{ request('volunteer_id') == $assignee->Usu_documento ? 'selected' : '' }}>{{ $assignee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size: 0.9em; font-weight: bold; display:block; margin-bottom: 5px;">Fase/Estado</label>
                <select name="status" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc; width: 160px;">
                    <option value="">Cualquiera</option>
                    <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Observación" {{ request('status') == 'Observación' ? 'selected' : '' }}>Observación</option>
                    <option value="En Proceso" {{ request('status') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                    <option value="Completado" {{ request('status') == 'Completado' ? 'selected' : '' }}>Completado</option>
                </select>
            </div>
            <div style="display: flex; gap: 10px;">
                <button type="submit" style="padding: 9px 15px; background: #2e8b57; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Filtrar</button>
                <a href="{{ route('admin.activities') }}" style="padding: 8px 15px; background: #e2e8f0; color: #475569; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Limpiar</a>
            </div>
        </form>
    </div>

    {{-- TABLA DE ACTIVIDADES DE VOLUNTARIOS --}}
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">
        <h3 style="margin-top: 0; color: #1e293b;">📋 Tareas Activas / Finalizadas</h3>
        <div style="overflow-x: auto;">
            <table class="premium-table" style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th style="padding:12px; text-align:left;">Tarea Reportada</th>
                        <th style="padding:12px; text-align:left;">Voluntario Asignado</th>
                        <th style="padding:12px; text-align:left;">Estado Actual</th>
                        <th style="padding:12px; text-align:left;">Fecha Límite</th>
                        <th style="padding:12px; text-align:left;">Comentario del Voluntario</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $act)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding:12px;">
                                <strong style="color: #2e8b57;">{{ $act->Tar_titulo }}</strong><br>
                                <small style="color:#64748b;">{{ Str::limit($act->Tar_descripcion, 60) ?? 'Sin descripción' }}</small>
                            </td>
                            <td style="padding:12px; font-weight:600;">{{ $act->user->name ?? 'Desconocido' }}</td>
                            <td style="padding:12px;">
                                @php
                                    $estadoColors = [
                                        'Pendiente' => ['bg' => '#fff3cd', 'text' => '#856404'],
                                        'Observación' => ['bg' => '#d1ecf1', 'text' => '#0c5460'],
                                        'En Proceso' => ['bg' => '#ffeaa7', 'text' => '#d68910'],
                                        'Completado' => ['bg' => '#d4edda', 'text' => '#155724'],
                                    ];
                                    $c = $estadoColors[$act->Tar_estado] ?? ['bg' => '#f1f5f9', 'text' => '#475569'];
                                @endphp
                                <span style="padding:4px 10px; border-radius:10px; font-size:0.8em; font-weight:bold; background:{{ $c['bg'] }}; color:{{ $c['text'] }};">
                                    {{ $act->Tar_estado }}
                                </span>
                            </td>
                            <td style="padding:12px; font-size:0.9em;">{{ $act->Tar_fecha_limite ? \Carbon\Carbon::parse($act->Tar_fecha_limite)->format('d/m/Y') : '-' }}</td>
                            <td style="padding:12px;">
                                @if($act->Tar_comentario)
                                    <em style="font-size: 0.85em; color: #444; border-left: 2px solid #ccc; padding-left: 5px;">"{{ $act->Tar_comentario }}"</em>
                                @else
                                    <span style="font-size: 0.8em; color: #aaa;">Sin reporte/comentario</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding:30px; text-align:center; color:#666;">No hay actividades que coincidan con la búsqueda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
