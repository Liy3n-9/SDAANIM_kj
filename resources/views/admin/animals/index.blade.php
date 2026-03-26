@extends('layouts.admin.app')

@section('title', 'Gestión de Animales | SDAANIM')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>Animales en el Refugio</h2>
        <a href="{{ route('admin.animals.create') }}" style="background: #2e8b57; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none;">+ Agregar Animal</a>
    </div>
    
    <div class="premium-grid">
        @foreach($animals as $animal)
            <div class="premium-card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column;">
                <div style="height: 220px; position: relative;">
                    <img src="{{ asset('img/' . ($animal->Anim_foto ?? 'placeholder.jpg')) }}" style="width: 100%; height: 100%; object-fit: cover;">
                    <div style="position: absolute; top: 10px; right: 10px; background: rgba(255,255,255,0.9); padding: 4px 12px; border-radius: 20px; font-size: 0.75em; font-weight: 700; color: #2e8b57; border: 1px solid #eee;">
                        {{ $animal->Anim_estado }}
                    </div>
                </div>
                <div style="padding: 20px; flex-grow: 1;">
                    <h3 style="margin: 0; font-size: 1.3em; color: #2c3e50;">{{ $animal->Anim_nombre }}</h3>
                    <p style="color: #64748b; margin: 8px 0; font-size: 0.9em; line-height: 1.4;">
                        {{ $animal->Anim_raza }} <br>
                        {{ $animal->Anim_edad }}
                    </p>
                </div>
                <div style="padding: 15px 20px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; gap: 10px;">
                    <a href="{{ route('admin.animals.edit', $animal->Anim_id) }}" class="premium-btn" style="flex: 1; justify-content: center; background: #e0f2fe; color: #075985; font-size: 0.85em; padding: 6px;">Editar</a>
                    <form action="{{ route('admin.animals.destroy', $animal->Anim_id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('¿Eliminar?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="premium-btn" style="width: 100%; justify-content: center; background: #fee2e2; color: #991b1b; font-size: 0.85em; padding: 6px;">Borrar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
