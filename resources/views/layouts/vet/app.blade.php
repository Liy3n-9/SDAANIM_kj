<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Panel Veterinario</title>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium.css') }}">
    @yield('styles')
    <style>
        body { margin: 0; font-family: 'Open Sans', sans-serif; background: #f0f7f7; color: #333; overflow-x: hidden; }
        .vet-header { background: linear-gradient(135deg, #1C9F96, #20B2AA); padding: 15px 40px; color: white; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
        .logo-text { font-family: 'Pacifico', cursive; font-size: 1.8em; color: white !important; margin: 0; }
        
        .notif-toggle { background-color: white; color: #20B2AA; border: none; padding: 8px 14px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .notif-sidebar { position: fixed; top: 0; right: -320px; width: 300px; height: 100%; background: #fff; box-shadow: -2px 0 10px rgba(0,0,0,0.2); transition: right 0.4s ease; z-index: 1000; padding: 20px; }
        .notif-sidebar.active { right: 0; }
        .notif-sidebar h3 { text-align: center; color: #20B2AA; margin-bottom: 20px; }
        .notif-sidebar a { display: block; padding: 12px; color: #333; border-bottom: 1px solid #eee; border-radius: 5px; }
        .notif-sidebar a:hover { background-color: #e0fff9; }
        .close-btn { position: absolute; top: 10px; right: 15px; background: transparent; border: none; font-size: 20px; cursor: pointer; color: #20B2AA; }

        .sidebar-vet { background: rgba(255,255,255,0.98); backdrop-filter: blur(15px); border-right: 5px solid #20B2AA; }
        .sidebar-vet a { padding: 15px 20px; border-radius: 12px; margin-bottom: 8px; font-weight: 600; transition: 0.3s; color: #444; }
        .sidebar-vet a:hover { background: #e0fff9; color: #1C9F96; transform: translateX(8px); }
        
        main { padding: 40px 20px; max-width: 1200px; margin: 0 auto; min-height: 80vh; }
        footer { background: #20B2AA; color: white; text-align: center; padding: 15px 0; margin-top: 40px; font-size: 0.9em; }
    </style>
</head>
<body>
    <header class="vet-header">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('img/a.png') }}" alt="Logo" style="height: 45px;">
            <h2 class="logo-text">Bienestar Animal Vet</h2>
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

    <div id="notifSidebar" class="notif-sidebar sidebar-vet">
        <button class="close-btn" onclick="toggleSidebar()">✖</button>
        <h3>Canal Médico</h3>
        <div style="margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            @auth
                @forelse(\App\Models\Notification::where('Usu_documento', Auth::user()->Usu_documento)->latest()->take(5)->get() as $notification)
                    <a href="{{ $notification->Noti_link ?? '#' }}" style="font-size: 0.9em; border-left: 3px solid #20B2AA; margin-bottom: 5px; background: #f0fff9;">
                        {{ $notification->Noti_mensaje }}<br>
                        <small style="color: #999;">{{ \Carbon\Carbon::parse($notification->Noti_fecha)->diffForHumans() }}</small>
                    </a>
                @empty
                    <p style="text-align: center; color: #999; font-size: 0.9em;">Sin novedades médicas.</p>
                @endforelse
            @endauth
        </div>
        <h3>Navegación</h3>
        <a href="{{ route('vet.dashboard') }}">🏠 Dashboard</a>
        <a href="{{ route('vet.animals') }}">🏥 Ver Animales</a>
        <a href="{{ route('profile.edit') }}">📊 Mi Perfil</a>
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
        <p>© 2025 Esperanza Animal BQ | Panel Veterinario</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById("notifSidebar").classList.toggle("active");
        }
    </script>
</body>
</html>
