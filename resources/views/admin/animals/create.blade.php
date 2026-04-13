@extends('layouts.admin.app')

@section('title', 'Registrar Animal | SDAANIM')

@section('content')
<div style="max-width: 900px; margin: 40px auto; padding: 20px;">
    <div class="premium-card" style="padding: 40px;">
        <h2 style="color: #2c3e50; margin-bottom: 30px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">🐾 Registrar Nuevo Animal</h2>
        
        <form action="{{ route('admin.animals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Nombre</label>
                    <input type="text" name="Anim_nombre" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Raza / Especie</label>
                    <input type="text" name="Anim_raza" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Edad</label>
                    <input type="text" name="Anim_edad" required placeholder="Ej: 2 años" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Sexo</label>
                    <select name="Anim_sexo" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; background: white;">
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Estado</label>
                    <select name="Anim_estado" required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; background: white;">
                        <option value="Disponible">Disponible</option>
                        <option value="Adoptado">Adoptado</option>
                        <option value="En Proceso">En Proceso</option>
                        <option value="En tratamiento">En tratamiento</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; margin-bottom: 8px; font-weight: 600; color: #475569;">Foto</label>
                    <input type="file" name="Anim_foto" style="width: 100%; padding: 8px;">
                </div>
            </div>
            
            <div style="margin-top: 25px;">
                <label style="display:block; margin-bottom: 10px; font-weight: 700; color: #334155;">Historia</label>
                <textarea name="Anim_historia" style="width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; box-sizing: border-box;" rows="4"></textarea>
            </div>

            <div style="margin-top: 40px; display: flex; gap: 15px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                <button type="submit" class="premium-btn premium-btn-primary" style="padding: 14px 40px; font-size: 1.1em; border-radius: 12px; justify-content: center;">Guardar Animal</button>
                <a href="{{ route('admin.animals.index') }}" class="premium-btn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 14px 40px; font-size: 1.1em; border-radius: 12px; display: flex; align-items: center; justify-content: center;">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
