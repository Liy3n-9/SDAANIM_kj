@extends('layouts.admin.app')

@section('title', 'Solicitudes de Adopción')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 1.75rem; font-weight: 700; color: #1e293b; margin: 0;">Solicitudes de Adopción</h1>
    <p style="color: #64748b; margin-top: 5px;">Revisa y gestiona las solicitudes de nuevos adoptantes.</p>
</div>

<<<<<<< HEAD
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
=======
<div class="premium-card" style="padding: 0; overflow: hidden; border: 1px solid #e2e8f0;">
    <div style="padding: 20px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
        <h3 style="margin: 0; color: #1e293b; font-size: 1rem;">Bandeja de Entrada</h3>
    </div>
    <div style="overflow-x: auto;">
        <table class="premium-table" style="margin-top: 0;">
            <thead>
                <tr>
                    <th style="padding-left: 20px;">Fecha</th>
                    <th>Adoptante</th>
                    <th>Animal</th>
                    <th>Estado</th>
                    <th>Verificador</th>
                    <th style="text-align: center; padding-right: 20px;">Acciones</th>
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
<<<<<<< HEAD
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
=======
                        <td style="padding-left: 20px; font-size: 0.85rem; color: #64748b;">
                            {{ \Carbon\Carbon::parse($request->Soli_fecha)->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #1e293b;">{{ $request->user->name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $request->user->Usu_documento }}</div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <img src="{{ asset('img/' . ($request->animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 32px; height: 32px; border-radius: 6px; object-fit: cover;">
                                <span style="font-weight: 500;">{{ $request->animal->Anim_nombre }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusStyles = [
                                    'Pendiente' => ['bg' => '#fef3c7', 'color' => '#92400e'],
                                    'Aprobada' => ['bg' => '#dcfce7', 'color' => '#166534'],
                                    'Rechazada' => ['bg' => '#fee2e2', 'color' => '#991b1b'],
                                    'En Proceso' => ['bg' => '#e0f2fe', 'color' => '#075985'],
                                ];
                                $style = $statusStyles[$request->Soli_estado] ?? ['bg' => '#f1f5f9', 'color' => '#475569'];
                            @endphp
                            <span style="background: {{ $style['bg'] }}; color: {{ $style['color'] }}; padding: 4px 10px; font-size: 0.75rem; border-radius: 12px; font-weight: 600;">
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
                                {{ $request->Soli_estado }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="estado" value="{{ $request->Soli_estado }}">
<<<<<<< HEAD
                                <select name="voluntario_doc" onchange="this.form.submit()" style="padding: 8px 12px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 0.9em; outline: none; transition: 0.3s; width: 100%;">
                                    <option value="">-- Seleccionar Voluntario --</option>
                                    @foreach($volunteers as $vol)
                                        <option value="{{ $vol->Usu_documento }}" {{ $request->Soli_voluntario == $vol->Usu_documento ? 'selected' : '' }}>
                                            👤 {{ $vol->name }}
=======
                                <select name="voluntario_doc" onchange="this.form.submit()" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e2e8f0; background: white; font-size: 0.85rem; outline: none; width: 100%;">
                                    <option value="">No asignado</option>
                                    @foreach($volunteers as $vol)
                                        <option value="{{ $vol->Usu_documento }}" {{ $request->Soli_voluntario == $vol->Usu_documento ? 'selected' : '' }}>
                                            {{ $vol->name }}
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
<<<<<<< HEAD
                        <td style="text-align: center;">
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Aprobada">
                                    <button type="submit" class="premium-btn" style="background: #22c55e; color: white; padding: 6px 14px; font-size: 0.85em;">Aprobar</button>
=======
                        <td style="text-align: center; padding-right: 20px;">
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Aprobada">
                                    <button type="submit" class="premium-btn" style="background: #22c55e; color: white; padding: 4px 10px; font-size: 0.8rem; border-radius: 6px;">Aprobar</button>
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
                                </form>
                                <form action="{{ route('admin.requests.approve', $request->Soli_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="estado" value="Rechazada">
<<<<<<< HEAD
                                    <button type="submit" class="premium-btn" style="background: #ef4444; color: white; padding: 6px 14px; font-size: 0.85em;">Rechazar</button>
=======
                                    <button type="submit" class="premium-btn" style="background: #ef4444; color: white; padding: 4px 10px; font-size: 0.8rem; border-radius: 6px;">Rechazar</button>
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<<<<<<< HEAD
</div>
=======
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
</div>
@endsection
