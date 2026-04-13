@extends('layouts.admin.app')

@section('title', 'Editar Producto')

@section('content')

<div style="max-width: 900px; margin: 40px auto; padding: 20px;">
    <div class="premium-card" style="padding: 40px;">
        <h2 style="color: #2e8b57; margin-bottom: 30px; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px;">🛍️ Editar Producto</h2>

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong>Errores:</strong>
            <ul style="margin: 10px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->prod_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">Nombre del Producto</label>
            <input type="text" name="prod_nombre" value="{{ old('prod_nombre', $product->prod_nombre) }}" required 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">Descripción</label>
            <textarea name="prod_descripcion" rows="4" required 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;">{{ old('prod_descripcion', $product->prod_descripcion) }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">Categoría</label>
                <select name="prod_categoria" required 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; background: white;">
                    <option value="">Seleccione una categoría</option>
                    @foreach(['Alimentos', 'Juguetes', 'Camas', 'Accesorios', 'Ropa'] as $category)
                        <option value="{{ $category }}" {{ old('prod_categoria', $product->prod_categoria) === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: bold; margin-bottom: 8px;">Precio (COP)</label>
                <input type="number" name="prod_precio" value="{{ old('prod_precio', $product->prod_precio) }}" step="0.01" min="0" required 
                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;">
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">Stock Cantidad</label>
            <input type="number" name="prod_cantidad" value="{{ old('prod_cantidad', $product->prod_cantidad) }}" min="0" required 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;">
        </div>

        <div style="margin-bottom: 30px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">Imagen del Producto</label>
            @if($product->prod_imagen)
                <div style="margin-bottom: 15px;">
                    <img src="{{ asset('img/' . $product->prod_imagen) }}" alt="{{ $product->prod_nombre }}" style="max-width: 150px; border-radius: 8px;">
                </div>
            @endif
            <input type="file" name="prod_imagen" accept="image/*" 
                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            <small style="color: #666; display: block; margin-top: 8px;">Dejar vacío para mantener la imagen actual</small>
        </div>

        <div style="margin-top: 40px; display: flex; gap: 15px; border-top: 1px solid #f1f5f9; padding-top: 25px;">
            <button type="submit" class="premium-btn premium-btn-primary" style="padding: 14px 40px; font-size: 1.1em; border-radius: 12px; justify-content: center;">Guardar Cambios</button>
            <a href="{{ route('admin.products.index') }}" class="premium-btn" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 14px 40px; font-size: 1.1em; border-radius: 12px; display: flex; align-items: center; justify-content: center;">Cancelar</a>
        </div>
    </form>
</div>

@endsection
