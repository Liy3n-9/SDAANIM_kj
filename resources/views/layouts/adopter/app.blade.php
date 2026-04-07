<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | JKD</title>
    <link rel="stylesheet" href="{{ asset('css/shared/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shared/premium.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adopter/dashboard.css') }}">
    @yield('styles')
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
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
                <a href="{{ route('adopter.requests') }}">Solicitudes</a>
                <a href="{{ route('adopter.donation.create') }}">Dona</a>
                <div class="dropdown">
                    <a href="#" class="dropbtn">Apóyanos ▾</a>
                    <div class="dropdown-content">
                        <a href="{{ route('inscriptions.volunteer') }}">Voluntario</a>
                        <a href="{{ route('inscriptions.veterinarian') }}">Veterinario</a>
                    </div>
                </div>
            </nav>

            <div class="search-container">
                <nav class="nav-right">
                    @auth
                    @php
                        $notifCount = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->whereNull('read_at')->count();
                    @endphp
                    <div style="position: relative; display: inline-block; margin-right: 15px;">
                        <button type="button" class="notif-toggle" onclick="toggleSidebar()" style="background: none; border: none; font-size: 1.4em; cursor: pointer; padding: 0;">🔔</button>
                        @if($notifCount > 0)
                            <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7em; font-weight: bold;">{{ $notifCount }}</span>
                        @endif
                    </div>
                    <span style="font-weight: bold; margin-right: 10px;">{{ Auth::user()->name }}</span>
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

        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <a href="#" style="color: #666; font-weight: bold;">❓ Ayuda y Soporte</a>
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
            @csrf
            <button type="submit" style="width: 100%; text-align: left; padding: 12px; background: transparent; border: none; cursor: pointer; color: #d9534f; font-size: 0.9em; border-radius: 5px; font-family: inherit; transition: 0.3s;" onmouseover="this.style.backgroundColor='#ffe6e6'" onmouseout="this.style.backgroundColor='transparent'">
                🚪 Cerrar sesión
            </button>
        </form>
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
            const sidebar = document.getElementById("notifSidebar");
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                const badge = document.getElementById("notifBadge");
                if (badge) {
                    fetch('{{ route("notificaciones.leer") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => {
                        if(response.ok) {
                            badge.style.display = 'none';
                        }
                    }).catch(error => console.error('Error:', error));
                }
            }
        }
    </script>
</body>

</html>