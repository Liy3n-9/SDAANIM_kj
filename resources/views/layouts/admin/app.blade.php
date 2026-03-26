<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>@yield('title') | SDAANIM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
=======
    <title>@yield('title') | Esperanza Animal BQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @yield('styles')
    <style>
<<<<<<< HEAD
        body { margin: 0; font-family: 'Open Sans', sans-serif; background: #f4f7f6; color: #333; }
        .admin-header { background: #1e5631; padding: 12px 30px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .logo-text { font-size: 1.5em; font-weight: 700; color: white; margin: 0; }
        
        .notif-toggle { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 8px; cursor: pointer; }
        .notif-toggle:hover { background: rgba(255,255,255,0.2); }

        .sidebar-admin { background: white; border-left: 1px solid #ddd; }
        .sidebar-admin a { display: block; padding: 12px 20px; color: #444; text-decoration: none; border-bottom: 1px solid #f0f0f0; transition: 0.2s; }
        .sidebar-admin a:hover { background: #f8fafc; color: #2e8b57; padding-left: 25px; }
        .sidebar-admin h3 { padding: 20px; margin: 0; background: #f8fafc; font-size: 1em; color: #666; border-bottom: 2px solid #eee; }
=======
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            overflow-x: hidden;
        }

        /* HEADER ADMIN */
        .admin-header {
            background: linear-gradient(90deg, #2e8b57, #4caf50);
            color: white;
            padding: 12px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .admin-header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-header img {
            height: 45px;
        }

        .admin-header h2 {
            font-family: 'Pacifico', cursive;
            font-size: 1.8em;
            margin: 0;
            color: black;
        }

        /* BOTÓN NOTIFICACIONES */
        .notif-toggle {
            background-color: white;
            color: #2e8b57;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .notif-toggle:hover {
            background-color: #f0f0f0;
        }

        /* BARRA LATERAL DERECHA (Notificaciones) */
        .notif-sidebar {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background-color: #ffffff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
            transition: right 0.4s ease;
            z-index: 1000;
            padding: 20px;
            overflow-y: auto;
        }

        .notif-sidebar.active {
            right: 0;
        }

        .notif-sidebar h3 {
            color: #2e8b57;
            text-align: center;
            margin-bottom: 20px;
        }

        .notif-sidebar a {
            display: block;
            padding: 12px;
            color: #333;
            border-bottom: 1px solid #eee;
            transition: 0.3s;
            border-radius: 5px;
            font-size: 0.9em;
        }

        .notif-sidebar a:hover {
            background-color: #e9f7ef;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #2e8b57;
        }

        /* MAIN CONTENT */
        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 70vh;
        }

        /* FOOTER */
        footer {
            background: #2e8b57;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: 40px;
            font-size: 0.9em;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .admin-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
    </style>
</head>
<body>
    <header class="admin-header">
<<<<<<< HEAD
        <div style="display: flex; align-items: center; gap: 15px;">
            <img src="{{ asset('img/a.png') }}" alt="Logo" style="height: 40px;">
            <h2 class="logo-text">SDAANIM</h2>
=======
        <div class="logo">
            <img src="{{ asset('img/a.png') }}" alt="Logo">
            <h2>Panel Administrador</h2>
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
        </div>

        <div style="display: flex; align-items: center; gap: 15px;">
            <button class="notif-toggle" onclick="toggleSidebar()">🔔 Notificaciones</button>
            <span style="font-weight: bold;">{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; font-weight:bold; cursor:pointer;">Cerrar sesión</button>
            </form>
        </div>
    </header>

<<<<<<< HEAD
    <div id="notifSidebar" class="notif-sidebar sidebar-admin">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Canal de Notificaciones</h3>
        <div style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(5)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}" style="font-size: 0.9em; border-left: 3px solid #2e8b57; margin-bottom: 5px; background: #f9f9f9;">
=======
    <!-- BARRA LATERAL DE NOTIFICACIONES -->
    <div id="notifSidebar" class="notif-sidebar">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Notificaciones</h3>
        <div class="notif-list">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(8)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}">
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
                        {{ $notification->Noti_mensaje }}<br>
                        <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
                    </a>
                @empty
                    <p style="text-align: center; color: #999; font-size: 0.9em;">No tienes notificaciones nuevas.</p>
                @endforelse
            @endauth
        </div>
        
<<<<<<< HEAD
        <h3>Menú Admin</h3>
        <a href="{{ route('profile.edit') }}">👤 Mi Perfil</a>
=======
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <h3 style="font-size: 1.1em;">Menú Admin</h3>
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('admin.animals.index') }}">🐾 Gestión de Animales</a>
        <a href="{{ route('admin.requests.index') }}">📋 Solicitudes Adopción</a>
<<<<<<< HEAD
        <a href="{{ route('admin.inscriptions.index') }}">📩 Ver Inscripciones</a>
        <a href="{{ route('admin.products.index') }}">🛒 Productos</a>
=======
>>>>>>> f395b0108094aa578f674cc5e814ef4b188bfbb7
        <a href="{{ route('admin.tasks.index') }}">📅 Tareas Voluntarios</a>
        <a href="{{ route('admin.users.index') }}">👥 Gestión de Usuarios</a>
        <a href="{{ route('profile.edit') }}">👤 Mi Perfil</a>
    </div>

    <main>
        @if(session('success'))
            <div class="alert-success">
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
        <p>© {{ date('Y') }} Esperanza Animal BQ | Panel Administrador</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById("notifSidebar").classList.toggle("active");
        }
    </script>
</body>
</html>