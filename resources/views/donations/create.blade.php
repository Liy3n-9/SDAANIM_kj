@extends('layouts.adopter.app')

@section('title', 'Donaciones | SDAANIM')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/adopter/animals.css') }}">
@endsection

@section('content')
<main class="donaciones">
    <a href="{{ route('dashboard') }}" style="display: inline-block; margin-bottom: 20px; background: #f1f5f9; color: #475569; padding: 8px 15px; border-radius: 8px; text-decoration: none; font-weight: bold;">← Volver al Inicio</a>
    <section class="banner-dona">
        <h2>Donaciones</h2>
        <p>Tu apoyo económico ayuda a cubrir gastos de alimentación y salud de los peluditos.</p>
    </section>

    <div class="contenido-dona">
        <section class="info-dona">
            <h3>¿Cómo ayudamos?</h3>
            <p>Con tu aporte mensual o único, garantizamos que cada animal rescatado tenga:</p>
            <ul>
                <li>Alimento balanceado.</li>
                <li>Atención veterinaria inmediata.</li>
                <li>Un espacio limpio y seguro mientras espera su nuevo hogar.</li>
            </ul>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px;">
                <div class="metodo-card"><img src="{{ asset('img/paypal.png') }}" alt="PayPal"></div>
                <div class="metodo-card"><img src="{{ asset('img/nequi.png') }}" alt="Nequi"></div>
                <div class="metodo-card"><img src="{{ asset('img/daviplata.png') }}" alt="Daviplata"></div>
                <div class="metodo-card"><img src="{{ asset('img/bancolombia.png') }}" alt="Bancolombia"></div>
            </div>
        </section>

        <section class="form-donar">
            <h3>Registra tu Donación</h3>


            <form action="{{ route('adopter.donation.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Monto (COP)</label>
                    <input type="number" name="Don_monto" required min="1000" step="100" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;" placeholder="Ej: 50000">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: bold;">Método de Pago</label>
                    <select name="Don_metodo_pago" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
                        <option value="Nequi">Nequi</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Daviplata">Daviplata</option>
                        <option value="Bancolombia">Bancolombia</option>
                    </select>
                </div>

                <button type="submit" style="width: 100%; background: #e67e22; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer;">
                    Confirmar Donación ❤️
                </button>
            </form>
        </section>
    </div>
</main>
@endsection
