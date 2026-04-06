<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Panel Voluntario</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @yield('styles')
    <style>
        /* Estilos generales */
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background: #f0f4f8;
            color: #333;
            overflow-x: hidden;
        }

        /* Header */
        .vol-header {
            background: linear-gradient(135deg, #005f9e, #007acc);
            padding: 15px 40px;
        }

        .logo-text {
            font-family: 'Pacifico', cursive;
            font-size: 1.8em;
            color: white !important;
            margin: 0;
        }

        /* Botón de notificaciones */
        .notif-toggle {
            background-color: white;
            color: #007acc;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        /* Sidebar de notificaciones */
        .notif-sidebar {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background: #fff;
            box-shadow: -2px 0 10px rgba(0,0,0,0.2);
            transition: right 0.4s ease;
            z-index: 1000;
            padding: 20px;
        }

        .notif-sidebar.active {
            right: 0;
        }

        .notif-sidebar h3 {
            text-align: center;
            color: #007acc;
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
            background-color: #e0f0ff;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #007acc;
        }

        /* Sidebar de voluntarios */
        .sidebar-vol {
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(15px);
            border-right: 5px solid #007acc;
        }

        .sidebar-vol a {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }

        .sidebar-vol a:hover {
            background: #e6f2ff;
            color: #007acc;
            transform: translateX(8px);
        }

        /* Contenido principal */
        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 80vh;
        }

        /* Pie de página */
        footer {
            background: #007acc;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 20px;
            font-size: 0.9em;
        }

        .vol-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #005f9e, #007acc);
            padding: 15px 40px;
        }

        .vol-header > div:last-child {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <header class="vol-header admin-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('img/a.png') }}" alt="Logo" style="height: 45px;">
            <h2 class="logo-text">SDAANIM Voluntarios</h2>
        </div>
        <div style="display: flex; align-items: center; gap: 15px;">
            @php
                $notifCount = \App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->whereNull('read_at')->count();
            @endphp
            <div style="position: relative; display: inline-block;">
                <button type="button" class="notif-toggle" onclick="toggleSidebar()" style="background: none; border: none; font-size: 1.4em; cursor: pointer; padding: 0;">🔔</button>
                @if($notifCount > 0)
                    <span id="notifBadge" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7em; font-weight: bold;">{{ $notifCount }}</span>
                @endif
            </div>
            <span style="font-weight:bold;">{{ Auth::user()->name }}</span>
        </div>
    </header>

    <div id="notifSidebar" class="notif-sidebar sidebar-vol">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Centro de Avisos</h3>
        <div style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(5)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}" style="font-size: 0.9em; border-left: 3px solid #007acc; margin-bottom: 5px; background: #f0f7ff;">
                        {{ $notification->Noti_mensaje }}<br>
                        <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
                    </a>
                @empty
                    <p style="text-align: center; color: #999; font-size: 0.9em;">Sin tareas pendientes hoy.</p>
                @endforelse
            @endauth
        </div>
        <h3>Mi Gestión</h3>
        <a href="{{ route('volunteer.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('volunteer.tasks') }}">📝 Mis Tareas</a>
        <a href="{{ route('profile.edit') }}">📊 Mi Perfil</a>

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

    <footer>
        <p>© 2025 Esperanza Animal BQ | Panel Voluntario</p>
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
