@extends('layouts.admin.app')

@section('title', 'Gestión de Productos | SDAANIM')

@section('content')
<div style="max-width: 1100px; margin: 30px auto; padding: 20px;">
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Inicio</a>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>Catálogo de Productos (Tienda)</h2>
        <a href="{{ route('admin.products.create') }}" style="background: #2e8b57; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none;">+ Agregar Producto</a>
    </div>
    
    <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
        <thead style="background: #2e8b57; color: white;">
            <tr>
                <th style="padding: 12px;">Imagen</th>
                <th style="padding: 12px;">Nombre</th>
                <th style="padding: 12px;">Categoría</th>
                <th style="padding: 12px;">Precio</th>
                <th style="padding: 12px;">Stock</th>
                <th style="padding: 12px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr style="border-bottom: 1px solid #eee; text-align: center;">
                    <td style="padding: 12px;"><img src="{{ asset('img/' . ($product->prod_imagen ?? 'default.jpg')) }}" style="width: 50px; height: 50px; object-fit: contain;"></td>
                    <td style="padding: 12px;">{{ $product->prod_nombre }}</td>
                    <td style="padding: 12px;">{{ $product->prod_categoria }}</td>
                    <td style="padding: 12px;">${{ number_format($product->prod_precio, 0) }}</td>
                    <td style="padding: 12px;">{{ $product->prod_cantidad }}</td>
                    <td style="padding: 12px;">
                        <a href="{{ route('admin.products.edit', $product->prod_id) }}" style="color: #007bff; font-weight: bold; margin-right: 10px; text-decoration: none;">Editar</a>
                        <form action="{{ route('admin.products.destroy', $product->prod_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color: #dc3545; font-weight: bold; cursor: pointer;">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
