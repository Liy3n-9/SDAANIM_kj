<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDAANIM - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mm.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <header class="main-header">
        <div class="header-top">
            <div class="logo">
                <img src="{{ asset('img/a.png') }}" alt="logo">
                <span>Esperanza Animal BQ</span>
            </div>

            <nav class="nav-menu">
                <a href="{{ url('/') }}">Inicio</a>
                <a href="#">Quienes somos</a>
                <a href="#">Adopta</a>
                <a href="#">Dona</a>
            </nav>

            <div class="search-container">
                <nav class="nav-right">
                    <button onclick="window.location.href='{{ route('login') }}'" class="filtro">Iniciar Sesión</button>
                </nav>
                <div class="usuario">
                    <a href="#"><img src="{{ asset('img/usuario.png') }}" alt="Usuario" id="usuario-icon"></a>
                </div>
            </div>
        </div>
    </header>

    <br><br><br>

    <div class="login-container">
        <h2>Crear Cuenta</h2>
        <form action="{{ route('register.custom') }}" method="POST">
            @csrf
            <input
                type="text"
                name="Usu_documento"
                placeholder="Número de Documento"
                value="{{ old('Usu_documento') }}"
                required />
            @error('Usu_documento') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="text"
                name="name"
                placeholder="Nombre Completo"
                value="{{ old('name') }}"
                required />
            @error('name') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="email"
                name="email"
                placeholder="Correo Electrónico"
                value="{{ old('email') }}"
                required />
            @error('email') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="text"
                name="Usu_telefono"
                placeholder="Número de Teléfono"
                value="{{ old('Usu_telefono') }}"
                required />
            @error('Usu_telefono') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="text"
                name="Usu_direccion"
                placeholder="Dirección"
                value="{{ old('Usu_direccion') }}"
                required />
            @error('Usu_direccion') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                required />
            @error('password') <p style="color:red; font-size:0.8rem;">{{ $message }}</p> @enderror

            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirmar Contraseña"
                required />

            <button type="submit" class="btn">Registrarse</button>
        </form>

        <div class="social-login">
            <button class="google-btn">Registrarse con Google</button>
            <button class="facebook-btn">Registrarse con Facebook</button>
        </div>

        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
        <br>
        <a href="{{ url('/') }}" class="btn volver-btn">Regresar</a>
    </div>
    @if(session('mostrar_modal') || session('error'))
    <div class="modal-overlay">
        <div class="modal-box">

            <h3>Verifica tu correo 📩</h3>
            <p>Ingresa el código que te enviamos</p>

            {{-- 🔥 MENSAJE DE ERROR --}}
            @if(session('error'))
            <p style="color:red; margin-top:10px; font-weight:bold;">
                {{ session('error') }}
            </p>
            @endif

            <form action="{{ url('/verificar') }}" method="POST">
                @csrf

                <input
                    type="text"
                    name="codigo"
                    placeholder="Código de 6 dígitos"
                    style="margin-top:15px; text-align:center; font-size:18px;"
                    required>

                <button type="submit" class="btn" style="margin-top:15px;">
                    Verificar
                </button>
            </form>

        </div>
    </div>
    @endif
</body>

</html>