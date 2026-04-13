@extends('layouts.admin.app')

@section('title', 'Solicitudes de Inscripción | SDAANIM')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 20px;">
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Inicio</a>
    <h2>Solicitudes de Voluntarios y Veterinarios</h2>
    <p>Revisa los perfiles de los nuevos interesados en unirse a la fundación.</p>



    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <thead style="background: #2e8b57; color: white;">
            <tr>
                <th style="padding: 15px; text-align: left;">Nombre</th>
                <th style="padding: 15px; text-align: left;">Rol Solicitado</th>
                <th style="padding: 15px; text-align: left;">Especialidad / Ayuda</th>
                <th style="padding: 15px; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscriptions as $ins)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">
                        <strong>{{ $ins->ins_nombre }}</strong><br>
                        <small style="color: #666;">Doc: {{ $ins->ins_documento }}</small>
                    </td>
                    <td style="padding: 15px;">
                        <span style="background: #e0f2f1; color: #00796b; padding: 4px 10px; border-radius: 10px; font-size: 0.85em; font-weight: bold; text-transform: uppercase;">
                            {{ $ins->ins_tipo_rol }}
                        </span>
                    </td>
                    <td style="padding: 15px; font-size: 0.9em;">
                        {{ $ins->ins_especialidad ?? $ins->ins_tipo_ayuda }}
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <form action="{{ route('admin.inscriptions.approve', $ins->ins_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #2e8b57; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; margin-right: 5px;">Aprobar</button>
                        </form>
                        <form action="{{ route('admin.inscriptions.reject', $ins->ins_id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #c62828; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold;">Rechazar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 40px; text-align: center; color: #666;">No hay solicitudes de inscripción pendientes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
