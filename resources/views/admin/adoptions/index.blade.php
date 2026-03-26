@extends('layouts.admin.app')

@section('title', 'Solicitudes de Adopción | SDAANIM')

@section('content')
<div style="max-width: 1200px; margin: 30px auto; padding: 20px;">
    <h2>Solicitudes de Adopción Recibidas</h2>
    
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
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
                    <th>Asignar Verificador</th>
                    <th style="text-align: center;">Decisión Final</th>
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
                            <span class="premium-btn" style="background: {{ $request->Soli_estado == 'Pendiente' ? '#fef3c7' : ($request->Soli_estado == 'Aprobada' ? '#dcfce7' : '#fee2e2') }}; color: {{ $request->Soli_estado == 'Pendiente' ? '#92400e' : ($request->Soli_estado == 'Aprobada' ? '#166534' : '#991b1b') }}; padding: 4px 12px; font-size: 0.8em; border-radius: 20px;">
                                {{ $request->Soli_estado }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="{{ $request->Soli_estado }}">
                                <select name="voluntario_doc" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 0.9em; outline: none; transition: 0.3s; width: 100%;">
                                    <option value="">-- Seleccionar Voluntario --</option>
                                    @foreach($volunteers as $vol)
                                        <option value="{{ $vol->Usu_documento }}" {{ $request->Soli_voluntario == $vol->Usu_documento ? 'selected' : '' }}>
                                            👤 {{ $vol->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Aprobada">
                                    <button type="submit" class="premium-btn" style="background: #22c55e; color: white; padding: 6px 14px; font-size: 0.85em;">Aprobar</button>
                                </form>
                                <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Rechazada">
                                    <button type="submit" class="premium-btn" style="background: #ef4444; color: white; padding: 6px 14px; font-size: 0.85em;">Rechazar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
