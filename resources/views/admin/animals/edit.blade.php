@extends('layouts.admin.app')

@section('title', 'Editar Animal | SDAANIM')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <div class="premium-card">
        <h2 style="color: #2c3e50; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px;">✏️ Editar Animal: {{ $animal->Anim_nombre }}</h2>
        
        <form action="{{ route('admin.animals.update', $animal->Anim_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Nombre</label>
                    <input type="text" name="Anim_nombre" value="{{ $animal->Anim_nombre }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Raza / Especie</label>
                    <input type="text" name="Anim_raza" value="{{ $animal->Anim_raza }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Edad</label>
                    <input type="text" name="Anim_edad" value="{{ $animal->Anim_edad }}" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Sexo</label>
                    <select name="Anim_sexo" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; background: white;">
                        <option value="Macho" {{ $animal->Anim_sexo == 'Macho' ? 'selected' : '' }}>Macho</option>
                        <option value="Hembra" {{ $animal->Anim_sexo == 'Hembra' ? 'selected' : '' }}>Hembra</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Estado</label>
                    <select name="Anim_estado" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; background: white;">
                        <option value="Disponible" {{ $animal->Anim_estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="Adoptado" {{ $animal->Anim_estado == 'Adoptado' ? 'selected' : '' }}>Adoptado</option>
                        <option value="En Proceso" {{ $animal->Anim_estado == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
                        <option value="En tratamiento" {{ $animal->Anim_estado == 'En tratamiento' ? 'selected' : '' }}>En tratamiento</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Foto</label>
                    <input type="file" name="Anim_foto" style="width: 100%; padding: 8px;">
                </div>
            </div>
            
            <div style="margin-top: 20px;">
                <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Historia</label>
                <textarea name="Anim_historia" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;" rows="4">{{ $animal->Anim_historia }}</textarea>
            </div>

            <div style="margin-top: 30px; display: flex; gap: 15px;">
                <button type="submit" class="premium-btn premium-btn-primary" style="flex: 1; justify-content: center;">Actualizar</button>
                <a href="{{ route('admin.animals.index') }}" class="premium-btn" style="background: #f1f5f9; color: #475569; border: 1px solid #ddd;">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
