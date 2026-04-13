@extends('layouts.adopter.app')
@section('title', 'Editar Historia | SDAANIM')
@section('content')
<div style="max-width: 900px; margin: 40px auto; padding: 20px;">
    <div class="premium-card" style="padding: 40px;">
        <h2 style="color: #2c3e50; margin-bottom: 30px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">📖 Editar Historia de Quiénes Somos</h2>
        
        <form action="{{ route('adopter.history.update') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 25px;">
                <label style="display:block; margin-bottom: 10px; font-weight: 700; color: #334155; font-size: 1.1em;">Nuestra Historia (Descripción Principal)</label>
                <textarea name="historia" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 1em; line-height: 1.6; box-sizing: border-box;" rows="5" required>{{ old('historia', $about['historia']) }}</textarea>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display:block; margin-bottom: 10px; font-weight: 700; color: #334155; font-size: 1.1em;">Misión</label>
                <textarea name="mision" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 1em; line-height: 1.6; box-sizing: border-box;" rows="5" required>{{ old('mision', $about['mision']) }}</textarea>
            </div>
            
            <div style="margin-bottom: 25px;">
                <label style="display:block; margin-bottom: 10px; font-weight: 700; color: #334155; font-size: 1.1em;">Visión</label>
                <textarea name="vision" style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 1em; line-height: 1.6; box-sizing: border-box;" rows="5" required>{{ old('vision', $about['vision']) }}</textarea>
            </div>

            <div style="margin-top: 40px; display: flex; gap: 15px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
                <button type="submit" class="premium-btn premium-btn-primary" style="padding: 14px 40px; font-size: 1.1em; border-radius: 12px; justify-content: center;">Guardar Cambios</button>
                <a href="{{ route('adopter.dashboard') }}" class="premium-btn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 14px 40px; font-size: 1.1em; border-radius: 12px; display: flex; align-items: center; justify-content: center;">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
