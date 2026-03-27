@extends(Auth::user()->role == 'Veterinario' ? 'layouts.vet.app' : 'layouts.volunteer.app')

@section('title', 'Mi Disponibilidad | SDAANIM')

@section('styles')
<style>
/* CONTENEDOR PRINCIPAL */
.container {
    max-width: 900px;
    margin: 30px auto;
    padding: 20px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.btn-volver {
    text-decoration: none;
    background: #374151;
    color: white;
    padding: 8px 15px;
    border-radius: 8px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-volver:hover {
    background: #1f2937;
}

/* ALERTAS */
.alert-success {
    background: #e6f4ea;
    color: #1e7e34;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-error {
    background: #fdecea;
    color: #b02a37;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}

/* CARD */
.card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin-bottom: 40px;
    border-top: 4px solid #d1d5db; /* neutro */
}

/* FORM */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
}

input {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

/* BOTÓN */
.btn-primary {
    margin-top: 20px;
    background: #2d7d46;
    color: white;
    font-weight: bold;
    border: none;
    padding: 12px 25px;
    border-radius: 50px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #25663a;
}

/* TABLA */
.table-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f3f4f6;
}

th, td {
    padding: 15px;
    text-align: left;
}

tr {
    border-bottom: 1px solid #eee;
}

/* ESTADO */
.badge {
    background: #6b7280;
    color: white;
    padding: 4px 10px;
    border-radius: 10px;
    font-size: 0.8em;
}

/* ELIMINAR */
.btn-delete {
    background: none;
    border: none;
    color: #dc2626;
    cursor: pointer;
    font-size: 1.2em;
}
</style>
@endsection

@section('content')
<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>Mi Disponibilidad / Horario</h2>
        <a href="{{ route('dashboard') }}" class="btn-volver">← Volver al Panel</a>
    </div>

    <!-- ALERTAS -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORMULARIO AGREGAR -->
    <div class="card">
        <h3>Agregar Nuevo Horario</h3>

        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.store' : 'volunteer.availability.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div>
                    <label>Fecha</label>
                    <input type="date" name="Ava_date" required min="{{ date('Y-m-d') }}">
                </div>
                <div>
                    <label>Hora Inicio</label>
                    <input type="time" name="Ava_start_time" required>
                </div>
                <div>
                    <label>Hora Fin</label>
                    <input type="time" name="Ava_end_time" required>
                </div>
            </div>
            <button type="submit" class="btn-primary">Guardar Disponibilidad</button>
        </form>
    </div>

    <!-- TABLA HORARIOS -->
    <h3>Mis Próximos Horarios</h3>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($availabilities as $ava)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($ava->Ava_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($ava->Ava_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($ava->Ava_end_time)->format('H:i') }}</td>
                    <td><span class="badge">{{ $ava->Ava_status }}</span></td>
                    <td style="text-align:center;">
                        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.destroy' : 'volunteer.availability.destroy', $ava->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete" title="Eliminar">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:30px; color:#666;">
                        No has programado disponibilidad aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection