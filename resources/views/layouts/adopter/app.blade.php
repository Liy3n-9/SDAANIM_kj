<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | JKD</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @yield('styles')
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        .notif-toggle {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .notif-sidebar {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background: #fff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            transition: right 0.4s ease;
            z-index: 1000;
            padding: 20px;
        }

        .notif-sidebar.active {
            right: 0;
        }

        .notif-sidebar h3 {
            text-align: center;
            color: #2d7d46;
            margin-bottom: 20px;
        }

        .notif-sidebar a {
            display: block;
            padding: 12px;
            color: #333;
            border-bottom: 1px solid #eee;
            border-radius: 5px;
        }

        .notif-sidebar a:hover {
            background-color: #f1f1f1;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #2d7d46;
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="header-top">
            <div class="logo">
                <img src="{{ asset('img/a.png') }}" alt="logo">
                <span>Esperanza Animal BQ</span>
            </div>

            <nav class="nav-menu">
                <a href="{{ url('/dashboard') }}">Inicio</a>
                <a href="{{ route('about') }}">Quienes somos</a>
                <a href="{{ route('adopta') }}">Adopta</a>
                <a href="{{ route('products.public') }}">Productos</a>
                <a href="{{ route('adopter.donation.create') }}">Dona</a>
            </nav>

            <div class="search-container">
                <nav class="nav-right">
                    @auth
                    @auth
                    <span>{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Cerrar sesión</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                    @endauth
                    @else
                    <button onclick="window.location.href='{{ route('login') }}'" class="filtro">Iniciar Sesión</button>
                    <button onclick="window.location.href='{{ route('register') }}'" class="filtro">Registrarse</button>
                    @endauth
                </nav>
                <div class="usuario">
                    <a href="#"><img src="{{ asset('img/usuario.png') }}" alt="Usuario" id="usuario-icon"></a>
                </div>
            </div>
        </div>
    </header>

    <div id="notifSidebar" class="notif-sidebar sidebar-adopter">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Notificaciones</h3>
        <div style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            @auth
            @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(5)->get() as $notification)
            <a href="{{ $notification->Noti_link ?? '#' }}" style="font-size: 0.85em; border-left: 3px solid #2d7d46; margin-bottom: 5px; background: #fcfcfc;">
                {{ $notification->Noti_mensaje }}<br>
                <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
            </a>
            @empty
            <p style="text-align: center; color: #999; font-size: 0.9em;">No tienes notificaciones.</p>
            @endforelse
            @else
            <p style="text-align: center; color: #999; font-size: 0.9em;">Inicia sesión para ver tus notificaciones.</p>
            @endauth
        </div>
        <h3>Mi Cuenta</h3>
        <a href="{{ route('profile.edit') }}">📋 Mi Perfil</a>
        <a href="{{ route('adopter.requests') }}">🐾 Mis Solicitudes</a>
    </div>

    <main>
        @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; margin: 20px auto; max-width: 1100px; border-radius: 8px; text-align: center; font-weight: bold;">
            {{ session('success') }}
        </div>
        @endif


        {{-- ✅ Bloque para mostrar notificación de bienvenida --}}
        @if(session('welcome'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: 'Bienvenido',
                text: "{{ session('welcome') }}",
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        </script>
        @endif

        @yield('content')
    </main>

    <footer id="contacto">
        <p>📞 Contáctanos: contacto@adoptaya.com | 📍 Barranquilla, Colombia</p>
        <p>© 2025 AdoptaYa - Todos los derechos reservados</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById("notifSidebar").classList.toggle("active");
        }
    </script>
</body>

</html>