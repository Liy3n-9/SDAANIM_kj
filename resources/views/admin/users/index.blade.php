@extends('layouts.admin.app')

@section('title', 'Gestión de Usuarios | SDAANIM')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 20px;">
    <h2>Usuarios del Sistema</h2>
    <p>Administra los roles y estados de los usuarios registrados.</p>
    
<div class="premium-card" style="margin-top: 20px;">
    <h3 style="margin-bottom: 25px; color: #1e293b;">Lista de Usuarios Registrados</h3>
    <div style="overflow-x: auto;">
        <table class="premium-table">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre Principal</th>
                    <th>Correo Electrónico</th>
                    <th>Rol Asignado</th>
                    <th>Estado</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="font-weight: 700;">{{ $user->Usu_documento }}</td>
                        <td>{{ $user->name }}</td>
                        <td style="color: #64748b;">{{ $user->email }}</td>
                        <td>
                            <span class="premium-btn" style="background: {{ $user->role == 'Administrador' ? '#fee2e2' : ($user->role == 'Veterinario' ? '#e0f2fe' : '#f0fdf4') }}; color: {{ $user->role == 'Administrador' ? '#991b1b' : ($user->role == 'Veterinario' ? '#075985' : '#166534') }}; padding: 4px 12px; font-size: 0.8em;">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <div style="width: 8px; height: 8px; border-radius: 50%; background: {{ $user->status == 'Activo' ? '#22c55e' : '#ef4444' }};"></div>
                                <span style="font-size: 0.9em; font-weight: 600;">{{ $user->status }}</span>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <button class="premium-btn" style="background: #f1f5f9; color: #475569; padding: 6px 15px; font-size: 0.85em;">Configurar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
