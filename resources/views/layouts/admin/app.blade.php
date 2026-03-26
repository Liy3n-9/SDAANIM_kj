<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SDAANIM Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @yield('styles')
    <style>
        body { margin: 0; font-family: 'Open Sans', sans-serif; background: #f4f7f6; color: #333; }
        .admin-header { background: #1e5631; padding: 12px 30px; display: flex; justify-content: space-between; align-items: center; color: white; }
        .logo-text { font-size: 1.5em; font-weight: 700; color: white; margin: 0; }
        
        .notif-toggle { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 8px; cursor: pointer; }
        .notif-toggle:hover { background: rgba(255,255,255,0.2); }

        .sidebar-admin { background: white; border-left: 1px solid #ddd; }
        .sidebar-admin a { display: block; padding: 12px 20px; color: #444; text-decoration: none; border-bottom: 1px solid #f0f0f0; transition: 0.2s; }
        .sidebar-admin a:hover { background: #f8fafc; color: #2e8b57; padding-left: 25px; }
        .sidebar-admin h3 { padding: 20px; margin: 0; background: #f8fafc; font-size: 1em; color: #666; border-bottom: 2px solid #eee; }
    </style>
</head>
<body>
    <header class="admin-header">
        <div style="display: flex; align-items: center; gap: 15px;">
            <img src="{{ asset('img/a.png') }}" alt="Logo" style="height: 40px;">
            <h2 class="logo-text">SDAANIM</h2>
        </div>
        <div>
            <button class="notif-toggle" onclick="toggleSidebar()">🔔 Notificaciones</button>
            <span style="margin-left:15px; font-weight:bold;">{{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:10px;">
                @csrf
                <button type="submit" style="background:none; border:none; color:white; font-weight:bold; cursor:pointer;">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <div id="notifSidebar" class="notif-sidebar sidebar-admin">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Canal de Notificaciones</h3>
        <div style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(5)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}" style="font-size: 0.9em; border-left: 3px solid #2e8b57; margin-bottom: 5px; background: #f9f9f9;">
                        {{ $notification->Noti_mensaje }}<br>
                        <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
                    </a>
                @empty
                    <p style="text-align: center; color: #999; font-size: 0.9em;">No tienes notificaciones nuevas.</p>
                @endforelse
            @endauth
        </div>
        
        <h3>Menú Admin</h3>
        <a href="{{ route('profile.edit') }}">👤 Mi Perfil</a>
        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('admin.users.index') }}">👥 Usuarios</a>
        <a href="{{ route('admin.animals.index') }}">🐾 Animales</a>
        <a href="{{ route('admin.requests.index') }}">📋 Solicitudes Adopción</a>
        <a href="{{ route('admin.inscriptions.index') }}">📩 Ver Inscripciones</a>
        <a href="{{ route('admin.products.index') }}">🛒 Productos</a>
        <a href="{{ route('admin.tasks.index') }}">📅 Tareas Voluntarios</a>
    </div>

    <main>
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; margin: 20px auto; max-width: 1100px; border-radius: 8px; text-align: center; font-weight: bold;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('welcome'))
            <script>
                alert("{{ session('welcome') }}");
            </script>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>© 2025 Esperanza Animal BQ | Panel Administrador</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById("notifSidebar").classList.toggle("active");
        }
    </script>
</body>
</html>
