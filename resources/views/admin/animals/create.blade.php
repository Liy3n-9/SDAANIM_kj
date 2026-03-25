@extends('layouts.admin.app')

@section('title', 'Registrar Animal')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="premium-card">
        <h2 style="color: #1e293b; margin-bottom: 25px; font-weight: 700;">Registrar Nuevo Animal</h2>
        
        <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div style="grid-column: span 2;">
                    <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Nombre</label>
                    <input type="text" name="Anim_nombre" required style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.95rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Raza / Especie</label>
                    <input type="text" name="Anim_raza" required style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.95rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Edad</label>
                    <input type="text" name="Anim_edad" required placeholder="Ej: 2 años" style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.95rem;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Sexo</label>
                    <select name="Anim_sexo" required style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; font-size: 0.95rem;">
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Estado</label>
                    <select name="Anim_estado" required style="width: 100%; padding: 8px 12px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; font-size: 0.95rem;">
                        <option value="Disponible">Disponible</option>
                        <option value="Adoptado">Adoptado</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="En tratamiento">En tratamiento</option>
                    </select>
                </div>
                <div style="grid-column: span 2;">
                    <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Foto</label>
                    <input type="file" name="Anim_foto" style="width: 100%; font-size: 0.9rem;">
                </div>
            </div>
            
            <div style="margin-top: 15px;">
                <label style="display:block; margin-bottom: 6px; font-weight: 600; color: #475569; font-size: 0.9rem;">Historia</label>
                <textarea name="Anim_historia" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-family: inherit; font-size: 0.95rem;" rows="3"></textarea>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 12px;">
                <button type="submit" class="premium-btn premium-btn-primary" style="flex: 1; justify-content: center;">Guardar Animal</button>
                <a href="{{ route('admin.animals.index') }}" class="premium-btn" style="background: #f8fafc; color: #64748b; border: 1px solid #e2e8f0; flex: 1; justify-content: center;">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
