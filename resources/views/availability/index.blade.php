@extends(Auth::user()->role == 'Veterinario' ? 'layouts.vet.app' : 'layouts.volunteer.app')

@section('title', 'Mi Disponibilidad | SDAANIM')

@section('content')
<div style="max-width: 900px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>Mi Disponibilidad / Horario</h2>
        <a href="{{ route('dashboard') }}" style="text-decoration: none; color: #20B2AA; font-weight: bold;">← Volver al Panel</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORMULARIO AGREGAR -->
    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 40px; border-top: 5px solid #20B2AA;">
        <h3 style="margin-top: 0; color: #1C9F96;">Agregar Nuevo Horario</h3>
        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.store' : 'volunteer.availability.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha</label>
                    <input type="date" name="Ava_date" required min="{{ date('Y-m-d') }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Hora Inicio</label>
                    <input type="time" name="Ava_start_time" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Hora Fin</label>
                    <input type="time" name="Ava_end_time" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                </div>
            </div>
            <button type="submit" style="margin-top: 20px; background: linear-gradient(90deg, #7FFFD4, #20B2AA); color: #333; font-weight: bold; border: none; padding: 12px 25px; border-radius: 50px; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 10px rgba(32, 178, 170, 0.3);">
                Guardar Disponibilidad
            </button>
        </form>
    </div>

    <!-- LISTA DE HORARIOS -->
    <h3 style="color: #1C9F96;">Mis Próximos Horarios</h3>
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #e0fff9; color: #1C9F96;">
                <tr>
                    <th style="padding: 15px; text-align: left;">Fecha</th>
                    <th style="padding: 15px; text-align: left;">Horario</th>
                    <th style="padding: 15px; text-align: left;">Estado</th>
                    <th style="padding: 15px; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($availabilities as $ava)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">{{ \Carbon\Carbon::parse($ava->Ava_date)->format('d/m/Y') }}</td>
                    <td style="padding: 15px;">{{ \Carbon\Carbon::parse($ava->Ava_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($ava->Ava_end_time)->format('H:i') }}</td>
                    <td style="padding: 15px;">
                        <span style="background: #20B2AA; color: white; padding: 3px 10px; border-radius: 10px; font-size: 0.8em;">{{ $ava->Ava_status }}</span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <form action="{{ route(Auth::user()->role == 'Veterinario' ? 'vet.availability.destroy' : 'volunteer.availability.destroy', $ava->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 1.2em;" title="Eliminar">🗑️</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 30px; text-align: center; color: #666;">No has programado disponibilidad aún.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
