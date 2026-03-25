<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Esperanza Animal BQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @yield('styles')
    <style>
        body {
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            overflow-x: hidden;
        }

        /* -----------------------------
           HEADER ADMIN
        ----------------------------- */

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

        /* -----------------------------
           BOTÓN NOTIFICACIONES
        ----------------------------- */

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

        /* -----------------------------
           BARRA LATERAL DERECHA (Notificaciones)
        ----------------------------- */

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

        /* -----------------------------
           MAIN CONTENT
        ----------------------------- */

        main {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 70vh;
        }

        /* -----------------------------
           FOOTER
        ----------------------------- */

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
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="logo">
            <img src="{{ asset('img/a.png') }}" alt="Logo">
            <h2>Panel Administrador</h2>
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

    <!-- BARRA LATERAL DE NOTIFICACIONES -->
    <div id="notifSidebar" class="notif-sidebar">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Notificaciones</h3>
        <div class="notif-list">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(8)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}">
                        {{ $notification->Noti_mensaje }}<br>
                        <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
                    </a>
                @empty
                    <p style="text-align: center; color: #999; font-size: 0.9em;">No tienes notificaciones nuevas.</p>
                @endforelse
            @endauth
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <h3 style="font-size: 1.1em;">Menú Admin</h3>
        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('admin.animals.index') }}">🐾 Gestión de Animales</a>
        <a href="{{ route('admin.requests.index') }}">📋 Solicitudes Adopción</a>
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
